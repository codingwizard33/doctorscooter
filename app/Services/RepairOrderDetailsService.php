<?php


namespace App\Services;


use App\Helper\MessageHellper;
use App\Helper\UploadFile;
use App\Models\RepairOrder;
use App\Models\RepairOrderCustomService;
use App\Models\RepairOrderDetails;
use App\Models\RepairOrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RepairOrderDetailsService
{
    use MessageHellper;

    /**
     * @param $data
     * @param null $id
     * @return array
     */
    public function repairOrderDetails($data, $id)
    {
        try {
            DB::beginTransaction();
                $details = RepairOrderDetails::query()->updateOrCreate(
                    ['order_id' => $id], //, 'user_id' => Auth::user()->id
                    [
                        'user_id' => Auth::user()->id, //Auth::user()->id
                        'order_id' => $data['order_id'],
                        'text' => $data['text'],
                    ]
                );
                if (!empty($data['images'])){
                    foreach ($data['images'] as $image){
//                        $filePath =  UploadFile::upload($image, '/repair/order/');
                        $filePath =  UploadFile::base64($image, 'image');
                        $details->images()->create(
                            [
                                'path' => $filePath,
                            ]
                        );
                    }
                }

            DB::commit();
            return [
                'message' => $this->MessageUpdateCreate('data'),
                'details' => $details,
                'code' => 200,
            ];
        }catch (\Exception $error){
            DB::rollBack();
            return [
                'message' => 'oops',
                'details' => [],
                'error'=> [
                    'error'=> $error->getMessage(),
                    'errorCode'=> $error->getCode(),
                    'errorFile'=> $error->getFile(),
                    'errorLine'=> $error->getLine(),
                ],
                'code' => 500,
            ];
        }
    }
}
