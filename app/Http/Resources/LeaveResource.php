<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'student_id'=> $this['student_id'],
            'leave_date'=> $this['leave_date'],
            'leave_time'=> $this['leave_time'],
            'student_signature'=> $this['student_signature'],
            'leave_reason'=> $this['leave_reason'],
            ];
    }
}