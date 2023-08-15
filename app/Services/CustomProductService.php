<?php


namespace App\Services;


use App\Helper\MessageHellper;
use App\Helper\UploadFile;
use App\Models\RepairOrder;
use App\Models\RepairOrderCustomService;
use App\Models\RepairOrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// use Picqer\Barcode\BarcodeGeneratorSVG;

class CustomProductService
{ // RepairOrderService
    use MessageHellper;

    // private function barCode($itemId)
    // {
    //     $generator = new BarcodeGeneratorSVG();

    //     $barcode = $generator->getBarcode($itemId, $generator::TYPE_CODE_128);

    //     return $barcode;
    // }

    /**
     * @param $data
     * @param null $id
     * @return array
     */
    public function storeOrUpdateCustomProduct($data, $id = null)
    {
        try {
            DB::beginTransaction();
            $data['key'] = time();
            $data['uuid'] = \Str::orderedUuid();

            // $bar_code = UploadFile::barCode($data['serial_number']);
            $product = RepairOrder::query()->updateOrCreate(
                ['id' => $id],
                [
                    'key' => $data['key'],
                    'uuid' => $data['uuid']->toString(),
                    'user_id' => Auth::id(),
                    'full_name' => $data['full_name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'model' => $data['model'],
                    'price' => $data['price'],
                    'bar_code' => rand(5030000000001, 5099999999999),
                    'serial_number' => $data['serial_number'] ?? null,
                    'information' => $data['information'],
                    'payment_comment' => $data['payment_comment'],
                    'payment_option' => $data['payment_option'],
                    'payment_warranty' => json_encode($data['payment_warranty']),
                    'payment_status' => $data['payment_status'] ?? RepairOrder::paymentStatus()[2],
                    'status' => RepairOrder::status()[0],
                ]
            );

            if (!empty($data['images'])) {
                foreach ($data['images'] as $image) {
//                        $filePath =  UploadFile::upload($image, '/repair/order/');
                    $filePath = UploadFile::base64($image, 'image');
                    $product->images()->create(
                        [
                            'path' => $filePath,
                        ]
                    );
                }
            }

            if (!empty($data['services'])) {
                // ------ update ------ \\
                $ServiceDB = RepairOrderService::query()->where('order_id', $product->id)->get();
                if ($id && $ServiceDB) {
                    $ServiceFront = array_column($data['services'], 'id');
                    RepairOrderService::query()->whereIn('id', array_values(array_diff($ServiceDB->pluck('id')->toArray(), $ServiceFront)))->delete();
                }
                // ------ update or create ------ \\
                // ------ if !isset id -> create, if isset id -> update ------ \\

                foreach ($data['services'] as $service) {
                    foreach ($service['subService'] as $subService) {
                        $subserviseIds[] = $subService['id'];
                    }
                    RepairOrderService::query()->updateOrCreate(
                        ['id' => (int)$service['id']],
                        [
                            'order_id' => $product->id,
                            'service_id' => $service['id'],
                            'subservice_id' => implode(',', $subserviseIds),
                            'status' => isset($id)
                                ? $ServiceDB->where('id', (int)$service['id'])->first()->status
                                : RepairOrderService::status()[0],
                        ]
                    );
                }
            }


            if (!empty($data['custom_services'])) {
                // ------ update ------ \\
                $CustomServiceDB = RepairOrderCustomService::query()->where('order_id', $product->id)->get();
                if ($id && $CustomServiceDB) {
                    $CustomServiceFront = array_column($data['custom_services'], 'id');
                    RepairOrderCustomService::query()->whereIn('id', array_values(array_diff($CustomServiceDB->pluck('id')->toArray(), $CustomServiceFront)))->delete();
                }
                // ------ update or create ------ \\
                // ------ if !isset id -> create, if isset id -> update ------ \\
                foreach ($data['custom_services'] as $customService) {
                    RepairOrderCustomService::query()->updateOrCreate(
                        ['id' => $customService['id']],
                        [
                            'order_id' => $product->id,
                            'name' => $customService['name'],
                            'price' => $customService['price'] ?? null,
                            'status' => isset($customService['id'])
                                ? $CustomServiceDB->where('id', $customService['id'])->first()->status
                                : RepairOrderCustomService::status()[0],
                        ]);
                }
            }

            DB::commit();
            return [
                'message' => $this->MessageUpdateCreate($id),
                'product' => $product,
                'code' => 200,
            ];
        } catch (\Exception $error) {
            DB::rollBack();
            return [
                'message' => 'oops',
                'product' => [],
                'error' => [
                    'error' => $error->getMessage(),
                    'errorCode' => $error->getCode(),
                    'errorFile' => $error->getFile(),
                    'errorLine' => $error->getLine(),
                ],
                'code' => 500,
            ];
        }
    }
}
