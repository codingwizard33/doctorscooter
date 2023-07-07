<?php


namespace App\Services;


use App\Helper\MessageHellper;
use App\Http\Resources\Service\GetServiceResource;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ServiceService
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
                $service = Service::query()->updateOrCreate(
                    ['id' => $id],
                    [
                        'name' => $request['name'],
                        'status' => $request['status'] ?? null
                    ]
                );
            DB::commit();

            return [
                'message' => $this->MessageUpdateCreate($id),
                'service' => new GetServiceResource($service),
                'code' => 200,
            ];
        }catch (\Exception $error){
            DB::rollBack();
            return [
                'message' => 'oops',
                'service' => [],
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
