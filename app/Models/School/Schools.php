<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Schools extends Model
{
    use  HasFactory;

    protected $table="schools";
    protected $fillable = [
        
    ];

    protected $casts = [
        'id'=>'integer',
        'is_active' => 'integer',
    ];
        public function scopeFilter($q)
    {
        // request()->school_id=1;
        if (request()->filled('school_id') && !empty(request('school_id'))) {
            $key = trim(request()['school_id']);
            $q->where('id', '=', $key);
        }    
        return $q;
    }
}
