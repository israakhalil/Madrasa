<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this['id'],
            'name'=> $this['name'],
            'class_id'=> $this['class_id'],
            'date_of_birth'=> $this['date_of_birth'],
            'phone_1'=> $this['phone_1'],
            'phone_2'=> $this['phone_2'],
            'phone_3'=> $this['phone_3'],
            'attached_id'=> $this['attached_id'],
            
            ];
    }
}