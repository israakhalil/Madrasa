<?php

namespace App\Models\School;

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
        'class_id' => 'integer',
    ]; 

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
