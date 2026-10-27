<?php

namespace App\Models\Auth;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = "user_permissions";


    const FILLABLE = ['user_id','permission_id'];

    protected $fillable = self::FILLABLE;

    public function scopeFilter($q)
    {
        if (request()->filled('user_id') && !empty(request('user_id'))) {
            $key = trim(request()['user_id']);
            $q->where('user_id', '=', $key);
        }

        return $q;
    }
}
