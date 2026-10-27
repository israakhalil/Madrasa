<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Levels extends Model
{
    use  HasFactory;

    protected $table="levels";

    const FILLABLE = [
        'name',
        'school_id',
    ];

    protected $fillable = self::FILLABLE;

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
        if (request()->filled('name') && !empty(request('name'))) {
            $key = trim(request()['name']);
            $q->where('name', 'like', "%$key%");
        }
        return $q;
    }

}
