<?php


namespace App\Services;


use App\Helper\MessageHellper;
use App\Helper\UploadFile;
use App\Models\RepairOrder;
use App\Models\RepairOrderCustomService;
use App\Models\RepairOrderService;
use App\Models\RepairOrderSubservice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

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
                    'warehouse' => $data['warehouse'],
                    'tech_id' => $data['tech_id'],
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
            $qrName = str_replace(' ', '_', $product->full_name) . "_" . time() . '.png';
            $qrUrl = env("APP_URL") . "/images/QR/$qrName";

            $renderer = new ImageRenderer(
                new RendererStyle(80),
                new ImagickImageBackEnd()
            );
            $writer = new Writer($renderer);
            $writer->writeFile(env("APP_URL") . "/app/repairs/order_details/$product->id?id=$product->id", public_path("images/QR/$qrName"));

            RepairOrder::query()
                ->where('id', $product->id)
                ->update(['qr_url' => $qrUrl]);

            if (!empty($data['images'])) {
                foreach ($data['images'] as $image) {
//                    $filePath =  UploadFile::upload($image, '/repair/order/');
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
                    $service_id = RepairOrderService::query()->updateOrCreate(
                        ['id' => (int)$service['id']],
                        [
                            'order_id' => $product->id,
                            'service_id' => $service['id'],
                            'service_name' => $service['name'],
                            'status' => isset($id)
                                ? $ServiceDB->where('id', (int)$service['id'])->first()->status
                                : RepairOrderService::status()[0],
                        ]
                    );
                    foreach ($service['subService'] as $subService) {
                        RepairOrderSubservice::query()->updateOrCreate(
                            ['id' => $subService['id']],
                            [
                                'service_table_id' => $service_id['id'],
                                'service_id' => $subService['service_id'],
                                'subservice_id' => $subService['id'],
                                'subservice_name' => $subService['name'],
                                'status' => RepairOrderSubservice::status()[0],
                            ]
                        );
                    }
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
