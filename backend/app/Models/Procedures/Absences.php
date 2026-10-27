<?php

namespace App\Models\Procedures;

use App\Models\Constants\AbsenceTypes;
use App\Models\School\Students;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
    use  HasFactory;


    protected $table="absences";
    const FILLABLE = ['student_id','absence_date','absence_reason','teacher_signature',
    'absence_type_id','class_id','hijri_date','attached'
    ,'time', 'respondent','contact_number'];
    protected $fillable = self::FILLABLE;
    protected $casts = 
    [
        'id'=>'integer',
    'student_id'=>'integer',
    'absence_type_id'=>'integer',
    'class_id'=>'integer',
];
// protected  $timestamps = false;

public function student(){
    return $this->belongsTo(Students::class, 'student_id' , 'id');
}

public function absenceType(){
    return $this->belongsTo(AbsenceTypes::class, 'absence_type_id' , 'id');
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
                $q->whereDate('absence_date', '=', $key);           
        }
        if (request()->filled('hijri_date') && !empty(request('hijri_date'))) {
            $key = trim(request()['hijri_date']);
                $q->where('hijri_date', '=', $key);           
        }
        return $q;
    }
}