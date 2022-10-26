<?php

namespace App\Models\School;

use App\Models\Procedures\Absences;
use App\Models\Procedures\Books;
use App\Models\Procedures\Delays;
use App\Models\Procedures\Leaves;
use App\Models\Procedures\Violations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Students extends Model
{
    use  HasFactory;

    protected $table="students";
    protected $primaryKey = 'id';
    public $timestamps = false;
    const FILLABLE = [      
        'name',
        'id_number',
        'class_id',
        'date_of_birth',
        'phone_1',
        'phone_2',
        'phone_3',
        'attached_id'
    ];

    protected $fillable = self::FILLABLE;
    protected $casts = [
        'id'=>'integer',
        // 'class_id' => 'integer',
    ]; 

    public function AbesenceCount(){
        return $this->hasMany(Absences::class,'student_id','id');
    }
    public function DelayCount(){
        return $this->hasMany(Delays::class,'student_id','id');
    }
    public function ViolationCount(){
        return $this->hasMany(Violations::class,'student_id','id');
    }
    public function LeaveCount(){
        return $this->hasMany(Leaves::class,'student_id','id');
    }
    public function BookCount(){
        return $this->hasMany(Books::class,'student_id','id');
    }


    public function scopeFilter($q)
    {
        if (request()->filled('id') && !empty(request('id'))) {
            $key = trim(request()['id']);
            $q->where('id', '=', $key);
        }  
        if (request()->filled('class_id') && !empty(request('class_id'))) {
            $key = trim(request()['class_id']);
            $q->where('class_id', '=', $key);
        }    
       
        return $q;
    }
}
