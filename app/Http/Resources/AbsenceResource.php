<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenceResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'student_id'=> $this['student_id'],
            'absence_date'=> $this['absence_date'],
            'absence_reason'=> $this['absence_reason'],
            'teacher_signature'=> $this['teacher_signature'],
            'absence_type_id'=> $this['absence_type_id'],
            ];
    }
}