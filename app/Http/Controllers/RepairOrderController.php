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
use App\Models\RepairOrderCustomService;
use App\Models\RepairOrderDetails;
use App\Models\RepairOrderService;
use App\Models\Service;
use App\Models\SubService;
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
            ->with('images', 'customService', 'user', 'service')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        if (count($products) > 0) {
            foreach ($products[0]['service'] as $s) {
                $s['subService'] = SubService::query()->whereIn('id', explode(',', $s['subservice_id']))->get();
            }
            return response()->json(
                [
                    'items' => CustomProductResource::collection($products->items()),
                    'pagination' => $this->pagination($products),
                ]
            );
        } else {
            return [];
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $product = $this->customProductService->storeOrUpdateCustomProduct($request->all());
        if ($product['code'] == 200) {
            // Hellper::sendSMS($product['phone'], $this->MessageForMail('repair_order_create'));
            // Mail::to($product['product']->email)->send(new RepairOrderMail($this->MessageForMail('repair_order_create')));
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
        $order = RepairOrder::query()->findOrFail($id)->load('images', 'customService', 'service', 'details');
        foreach ($order['service'] as $s) {
            $s['subService'] = SubService::query()->whereIn('id', explode(',', $s['subservice_id']))->get();
        }
        return response()->json([
            'product' => new CustomProductResource($order),
        ], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request, $id)
    {
        DB::beginTransaction();
        $product = RepairOrder::query()->findOrFail($id);

        // Repair order status
        if (isset($request->status)) {
            $product->update([
                'status' => $request->status
            ]);
        }

        // pay status
        if (isset($request->payment_status)) {
            $product->update([
                'payment_status' => $request->payment_status
            ]);
        }

        // pay service status
        if (isset($request['service']['id'])) {
            $service = RepairOrderService::query()->findOrFail($request['service']['id']);
            $service->update([
                'status' => $request['service']['status']
            ]);
        }

        // pay custom service status
        if (isset($request['custom_service']['id'])) {
            $customService = RepairOrderCustomService::query()->findOrFail($request['custom_service']['id']);
            $customService->update([
                'status' => $request['custom_service']['status']
            ]);
        }

        DB::commit();
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
        $filePath = UploadFile::upload($request->bar_code, '/repair/order/barcode/');
        $product = RepairOrder::query()->findOrFail($id);
        $product->update([
            'bar_code' => $filePath
        ]);

        return response()->json([
            'message' => __('Updated bar code successfully'),
            'product' => new CustomProductResource($product),
        ], 200);
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
        // create and update in one function
        $details = $this->repairOrderDetailsService->repairOrderDetails($request->all());

        if ($details['code'] == 200) {
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function repairOrderDetailsDelete($id)
    {
        DB::beginTransaction();
        $detail = RepairOrderDetails::query()->findOrFail($id)->load('images');
        foreach ($detail->images as $image) {
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
