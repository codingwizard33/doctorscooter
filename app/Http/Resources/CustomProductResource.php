<?php

namespace App\Http\Resources;

use App\Http\Resources\RepairOrder\GetServiceNameInRepairOrder;
use App\Http\Resources\User\GetUserResource;
use http\Client\Curl\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Picqer\Barcode\BarcodeGeneratorSVG;

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
        // dd($this->images());
        if (!empty($this->images()->pluck('path'))){
            foreach ($this->images()->get() as $key => $image){
                $path[$key]['id'] = $image->id;
                $path[$key]['path'] = asset($image->path);
            }
        }

        $detail = $this->details->first();
//        preg_match('/<svg.*<\/svg>/s', $this->barCode($this->bar_code), $matches);

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'warehouse' => $this->warehouse,
            'sales_man' => new GetUserResource($this->user),
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'model' => $this->model,
            'price' => $this->price,
//            'bar_code' => $matches[0] . "<p style='letter-spacing: 12px;'>$this->bar_code</p>",
            'qr_url' => $this->qr_url,
            'serial_number' => $this->serial_number,
            'information' => $this->information,
            'payment_comment' => $this->payment_comment,
            'payment_option' => $this->payment_option,
            'payment_warranty' => json_decode($this->payment_warranty),
            'payment_status' => $this->payment_status,
            'status' => $this->status,
            'images' => $path,
//            'service' => GetServiceNameInRepairOrder::collection($this->service), // sub_service
            'service' => $this->service, // sub_service
            'custom_service' => $this->customService,
            'technician' => \App\Models\User::find($this->tech_id),
            'details' => [
                'text' => $detail->text ?? '',
                'images' => $detail->images ?? []
            ],

            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
    }

    private function barCode($itemId)
    {
        $generator = new BarcodeGeneratorSVG();

        $barcode = $generator->getBarcode($itemId, $generator::TYPE_CODE_128);

        return $barcode;
    }
}
