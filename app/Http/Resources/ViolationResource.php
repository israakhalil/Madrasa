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
            'violation_procedure_name'=> @$this->violationProcedure->name,
            'violation_degree_id'=> $this['violation_degree_id'],
            'violation_degree_name'=> @$this->violationDegree->name,
            'student_id'=> $this['student_id'],
            'student_name'=>@$this->student->name,
            'supervisor_signature'=> $this['supervisor_signature'],
            'student_signature'=> $this['student_signature'],
            'hijri_date'=>$this['hijri_date'],
            ];
    }
}