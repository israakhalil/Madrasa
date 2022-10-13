<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Classes extends Model
{
    use  HasFactory;

    protected $table="classes";
    protected $primaryKey = 'id';
    public $timestamps = false;
    const FILLABLE = [
       
        'name',
        'level_id',
        'attached_file',
        'school_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $fillable = self::FILLABLE;
    protected $casts = [
        'id'=>'integer',
        'level_id' => 'integer',
        'user_id' => 'integer',
        'school_id'=> 'integer',
    ];
    
    
    public function level(){
        return $this->belongsTo(Levels::class, 'level_id' , 'id');
    }

    public function user(){
        // return $this->belongsTo(Levels::class, 'id' , 'level_id');
    }
    public function scopeFilter($q)
    {
        // request()->school_id=1;
        if (request()->filled('school_id') && !empty(request('school_id'))) {
            $key = trim(request()['school_id']);
            $q->where('school_id', '=', $key);
        }    
        if (request()->filled('level_id') && !empty(request('level_id'))) {
            $key = trim(request()['level_id']);
            $q->where('level_id', '=', $key);
        }    
       
        return $q;
    }

}
