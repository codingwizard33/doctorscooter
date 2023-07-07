<?php


namespace App\Http\Resources\RepairOrder;


use Illuminate\Http\Resources\Json\JsonResource;

class GetServiceNameInRepairOrder  extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' =>$this->subService->name ?? '', // DB name table sub_services
            'status' => $this->status,
        ];
    }
}
