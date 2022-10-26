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
            'id_number'=> $this['id_number'],
            'date_of_birth'=> $this['date_of_birth'],
            'phone_1'=> $this['phone_1'],
            'phone_2'=> $this['phone_2'],
            'phone_3'=> $this['phone_3'],
            'attached_id'=> $this['attached_id'],
            'absence_count'=>Count($this->AbesenceCount),
            'delay_count'=>Count($this->DelayCount),
            'violation_count'=>Count($this->ViolationCount),
            'leave_count'=>Count($this->LeaveCount),
            'book_count'=>Count($this->BookCount),

            
            ];
    }
}