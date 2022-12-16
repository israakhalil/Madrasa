<?php

namespace App\Models\Procedures;
use App\Models\School\Students;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    use  HasFactory;


    protected $table="leaves";
    const FILLABLE = ['student_id','leave_date','leave_time',
    'student_signature','leave_reason','class_id','hijri_date'];
    protected $fillable = self::FILLABLE;
    protected $casts =
     ['id'=>'integer',
    'student_id'=>'integer',
    'class_id'=>'integer',];

    public function student(){
        return $this->belongsTo(Students::class, 'student_id' , 'id');
    }

    public function scopeFilter($q)
    { 
        if (request()->filled('student_id') && !empty(request('student_id'))) {
            $key = trim(request()['student_id']);
            $q->where('student_id', '=', $key);
        }    
        if (request()->filled('class_id') && !empty(request('class_id'))) {
            $key = trim(request()['class_id']);
            $q->where('class_id', '=', $key);
        }
        if (request()->filled('date') && !empty(request('date'))) {
            $key = trim(request()['date']);
                $q->whereDate('leave_date', '=', $key);           
        }
        return $q;
    }
}