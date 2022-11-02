<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Levels extends Model
{
    use  HasFactory;

    protected $table="levels";
    protected $fillable = [
        'name',
        'school_id',
    ];
    protected $casts = [
        'id'=>'integer',
        'school_id' => 'integer',
    ];

    public function school(){
        return $this->belongsTo(Schools::class, 'school_id' , 'id');
    }

    public function classes(){
        return $this->hasMany(Classes::class,'level_id','id');
    }

    public function scopeFilter($q)
    {
        // request()->school_id=1;
        if (request()->filled('school_id') && !empty(request('school_id'))) {
            $key = trim(request()['school_id']);
            $q->where('school_id', '=', $key);
        }    
        return $q;
    }
    
}
