<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=> $this['id'],
            'student_id'=> $this['student_id'],
            'student_name'=>@$this->student->name,
            'leave_date'=> $this['leave_date'],
            'leave_time'=> $this['leave_time'],
            'student_signature'=> $this['student_signature'],
            'leave_reason'=> $this['leave_reason'],
            'hijri_date'=>$this['hijri_date'],
            'attached'=>$this['attached'],
            'guardian_name'=>$this['guardian_name'],
            'guardian_id'=>$this['guardian_id'],
            'file'=>asset('storage/'.$this['attached'])
            ];
    }
}