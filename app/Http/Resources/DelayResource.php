<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DelayResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=> $this['id'],
            'student_id'=> $this['student_id'],
            'delay_date'=> $this['delay_date'],
            'delay_reason'=> $this['delay_reason'],
            'delay_amount'=> $this['delay_amount'],
            'student_signature'=> $this['student_signature'],
            ];
    }
}