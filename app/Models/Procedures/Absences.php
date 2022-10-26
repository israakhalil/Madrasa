<?php

namespace App\Models\Procedures;

use App\Models\Constants\AbsenceTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
    use  HasFactory;


    protected $table="absences";
    const FILLABLE = ['student_id','absence_date','absence_reason','teacher_signature','absence_type_id'];
    protected $fillable = self::FILLABLE;
    protected $casts = 
    [
        'id'=>'integer',
    'student_id'=>'integer',
    'absence_type_id'=>'integer'
];

public function absenceType(){
    return $this->belongsTo(AbsenceTypes::class, 'absence_type_id' , 'id');
} 
    public function scopeFilter($q)
    { 
        if (request()->filled('student_id') && !empty(request('student_id'))) {
            $key = trim(request()['student_id']);
            $q->where('student_id', '=', $key);
        }    
    
        return $q;
    }
}