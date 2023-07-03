<?php

namespace App\Http\Resources;

use App\Http\Resources\User\GetUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $path = [];
        if (!empty($this->images()->pluck('path'))){
            foreach ($this->images()->get() as $key => $image){
                $path[$key]['id'] = $image->id;
                $path[$key]['path'] = asset($image->path);
            }
        }

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'sales_man' => new GetUserResource($this->user),
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'model' => $this->model,
            'price' => $this->price,
            'bar_code' => asset($this->bar_code),
            'serial_number' => $this->serial_number,
            'information' => $this->information,
            'payment_comment' => $this->payment_comment,
            'payment_option' => $this->payment_option,
            'payment_warranty' => json_decode($this->payment_warranty),
            'payment_status' => $this->payment_status,
            'status' => $this->status,
            'images' => $path,
            'service' => $this->service,
            'custom_service' => $this->customService,

            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
    }
}
