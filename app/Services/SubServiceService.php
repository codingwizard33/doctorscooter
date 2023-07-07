<?php


namespace App\Services;


use App\Helper\MessageHellper;
use App\Http\Resources\SubService\GetSubServiceResource;
use App\Models\SubService;
use Illuminate\Support\Facades\DB;

class SubServiceService
{
    use MessageHellper;

    /**
     * @param $request
     * @param null $id
     * @return array
     */
    public function createUpdate($request, $id = null)
    {
        try {
            DB::beginTransaction();
            $subService = SubService::query()->updateOrCreate(
                ['id' => $id],
                [
                    'service_id' => $request['service_id'],
                    'name' => $request['name'],
                    'price' => $request['price'],
                    'status' => $request['status'] ?? null,
                ]
            );
            DB::commit();
            return [
                'message' => $this->MessageUpdateCreate($id),
                'subService' => new GetSubServiceResource($subService),
                'code' => 200,
            ];
        }catch (\Exception $error){
            DB::rollBack();
            return [
                'message' => 'oops',
                'subService' => [],
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
