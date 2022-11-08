<?php

namespace App\Models\Auth;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";


    const FILLABLE = ['name'];

    protected $fillable = self::FILLABLE;

    public function scopeFilter($q)
    {

        $filter = request('filter');

        if (isset($filter) && !empty($filter)) {
            $filter = json_decode($filter, true);
            if (isset($filter['name']) && !empty($filter['name'])) {
                $key = trim($filter['name']);
                $q->where('name', 'like', "%$key%");
            }

        }


        return $q;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission', 'role_id', 'permission_id');
    }





}