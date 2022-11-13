<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViolationResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=> $this['id'],
            'violation_date'=> $this['violation_date'],
            'action_performed'=> $this['action_performed'],
            'violation_procedure_id'=> $this['violation_procedure_id'],
            'violation_degree_id'=> $this['violation_degree_id'],
            'student_id'=> $this['student_id'],
            'supervisor_signature'=> $this['supervisor_signature'],
            'student_signature'=> $this['student_signature'],
            ];
    }
}