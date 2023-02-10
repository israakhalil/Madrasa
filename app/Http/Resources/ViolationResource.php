<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViolationResource extends JsonResource
{

    public function toArray($request)
    {
        $type=mb_split('&', $this['violation_procedure_type']);
        $myType = collect( $type);
        $myType = $myType->reverse()->slice(1)->reverse();


        $action=mb_split('&', $this['action_performed']);
        $myAction = collect( $action);
        $myAction = $myAction->reverse()->slice(1)->reverse();

        return [
            'id'=> $this['id'],
            'violation_date'=> $this['violation_date'],
            'action_performed'=>  $myAction,
            'violation_procedure_id'=> $this['violation_procedure_id'],
            'violation_procedure_name'=> @$this->violationProcedure->name,
            'violation_degree_id'=> $this['violation_degree_id'],
            'violation_degree_name'=> @$this->violationDegree->name,
            'student_id'=> $this['student_id'],
            'student_name'=>@$this->student->name,
            'supervisor_signature'=> $this['supervisor_signature'],
            'student_signature'=> $this['student_signature'],
            'hijri_date'=>$this['hijri_date'],
            'attached'=>$this['attached'],
            'file'=>asset('storage/'.$this['attached']),
            'violation_procedure_type'=>$myType,
            
            ];
    }
}