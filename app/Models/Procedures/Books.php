<?php

namespace App\Models\Procedures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use  HasFactory;

    protected $table="books";
    const FILLABLE = ['received_date','book_name','is_delivered',
    'student_signature','student_id','class_id'];
    protected $fillable = self::FILLABLE;
    protected $casts = 
    [
        'id'=>'integer',
        'student_id'=>'integer',
        'class_id'=>'integer',

    ];
    
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
                $q->whereDate('received_date', '=', $key);           
        }
        return $q;
    }

}