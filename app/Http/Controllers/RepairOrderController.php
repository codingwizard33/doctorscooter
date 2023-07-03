<?php

namespace App\Http\Controllers;

use App\Helper\Hellper;
use App\Helper\MessageHellper;
use App\Helper\UploadFile;
use App\Http\Requests\RepairOrder\CreateUpdateRequest;
use App\Http\Requests\RepairOrderDetail\CreateUpdateDetailRequest;
use App\Http\Resources\CustomProductResource;
use App\Mail\RepairOrderMail;
use App\Models\Image;
use App\Models\RepairOrder;
use App\Models\RepairOrderDetails;
use App\Services\CustomProductService;
use App\Services\RepairOrderDetailsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RepairOrderController extends Controller
{

    use MessageHellper;

    protected $customProductService;
    protected $repairOrderDetailsService;

    public function __construct()
    {
        $this->customProductService = app(CustomProductService::class);
        $this->repairOrderDetailsService = app(RepairOrderDetailsService::class);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = RepairOrder::query()
            ->with('images', 'customService', 'service', 'user')
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
    public function store(Request $request)
    {
        $product = $this->customProductService->storeOrUpdateCustomProduct($request->all());
        if ($product['code'] == 200){
            Hellper::sendSMS($product['phone'], $this->MessageForMail('repair_order_create'));
            Mail::to($product['product']->email)->send(new RepairOrderMail($this->MessageForMail('repair_order_create')));
        }
        return response()->json([
            'message' => $product['message'],
            'product' => new CustomProductResource($product['product']),
            'error' => $product['error'] ?? '',
        ], $product['code']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateUpdateRequest $request, $id)
    {
        $product = $this->customProductService->storeOrUpdateCustomProduct($request->all(), $id);
        return response()->json([
            'message' => $product['message'],
            'product' => new CustomProductResource($product['product']),
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function repairOrderDetailsCreate(CreateUpdateDetailRequest $request)
    {
        $details = $this->repairOrderDetailsService->repairOrderDetails($request->all());
        if ($details['code'] == 200){
            Hellper::sendSMS($details['details']->repairOrder->phone, $this->MessageForMail('repair_order_finish'));
            Mail::to($details['details']->repairOrder->email)->send(new RepairOrderMail($this->MessageForMail('repair_order_finish')));
        }
        return response()->json([
            'message' => $details['message'],
            'details' => $details['details'],
            'error' => $details['error'] ?? '',
        ], $details['code']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function repairOrderDetailsUpdate(CreateUpdateDetailRequest $request, $id)
    {
        $details = $this->repairOrderDetailsService->repairOrderDetails($request->all(), $id);
        return response()->json([
            'message' => $details['message'],
            'details' => $details['details'],
            'error' => $details['error'] ?? '',
        ], $details['code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function repairOrderDetailsDelete($id)
    {
        DB::beginTransaction();
            $detail = RepairOrderDetails::query()->findOrFail($id)->load('images');
            foreach ($detail->images as $image){
                $PathForDelete = str_replace('/storage', '', $image->path);
                Storage::delete('/public' . $PathForDelete);
            }
            $detail->images()->delete();
            $detail->delete();
        DB::commit();
        return response()->json([
            'message' => $this->MessageDelete(),
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
