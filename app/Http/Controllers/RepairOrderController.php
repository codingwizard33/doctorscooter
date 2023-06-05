<?php

namespace App\Http\Controllers;

use App\Helper\UploadFile;
use App\Http\Requests\RepairOrder\CreateRequest;
use App\Http\Requests\RepairOrder\UpdateRequest;
use App\Http\Resources\CustomProductResource;
use App\Models\Image;
use App\Models\RepairOrder;
use App\Services\CustomProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepairOrderController extends Controller
{

    protected $customProductService;

    public function __construct()
    {
        $this->customProductService = app(CustomProductService::class);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = RepairOrder::query()
            ->with('images', 'customService', 'service')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return response()->json(
            [
                'items' => CustomProductResource::collection($products->items()),
                'pagination' => $this->pagination($products),
            ]
        );
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $product = $this->customProductService->storeOrUpdateCustomProduct($request->all());
        return response()->json([
            'message' => $product['message'],
            'product' => $product['product'],
            'error' => $product['error'] ?? '',
        ], $product['code']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $product = $this->customProductService->storeOrUpdateCustomProduct($request->all(), $id);
        return response()->json([
            'message' => $product['message'],
            'product' => $product['product'],
            'error' => $product['error'] ?? '',
        ], $product['code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = RepairOrder::query()->findOrFail($id)->load('images', 'customService', 'service');
        return response()->json([
            'product' => new CustomProductResource($product),
        ], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request, $id)
    {
        $product = RepairOrder::query()->findOrFail($id);

        if (isset($request->payment_status)){
            $product->update([
                'payment_status' => $request->payment_status
            ]);
        }
        if (isset($request->status)){
            $product->update([
                'status' => $request->status
            ]);
        }else {
            return response()->json([
                'message' => __('oops invalid request'),
            ], 503);
        }

        return response()->json([
            'message' => __('Updated status successfully'),
            'product' => new CustomProductResource($product),
        ], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function barCode(Request $request, $id)
    {
        $filePath =  UploadFile::upload($request->bar_code, '/repair/order/barcode/');
        $product = RepairOrder::query()->findOrFail($id);
        $product->update([
            'bar_code' => $filePath
        ]);

        return response()->json([
            'message' => __('Updated bar code successfully'),
            'product' => new CustomProductResource($product),
        ],200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOneImage($id)
    {
        $image = Image::query()->findOrFail($id);
        $PathForDelete = str_replace('/storage', '', $image->path);
        Storage::delete('/public' . $PathForDelete);
        $image->delete();
        return response()->json([
            'message' => __('Successfully deleted one image'),
        ], 200);
    }

    /**
     * @param $items
     * @return array
     */
    protected function pagination($items): array
    {
        return [
            'currentPage' => $items->currentPage(),
            'perPage' => $items->perPage(),
            'total' => $items->total(),
            'totalPages' => $items->lastPage(),
        ];
    }
}
