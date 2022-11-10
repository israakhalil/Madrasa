<?php

namespace App\Models\Auth;

use App\Models\School\Schools;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = "users";
    protected $primaryKey = 'id';
    const FILLABLE = [
        'username',
        'name',
        'email',
        'password',
        'school_id',
        'id_number',
        'role_id'
    ];

    protected $fillable = self::FILLABLE;
    public $timestamps=false;

    protected $hidden = [
        'password',
    ];

    public function school(){
        return $this->belongsTo(Schools::class, 'school_id' , 'id');
    }

    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class, 'access_control_user_role', 'user_id', 'role_id');
    // }

    // public function permissions(): BelongsToMany
    // {
    //     return $this->belongsToMany(Permission::class, 'access_control_user_permission', 'user_id', 'permission_id');
    // }



    // public function getAllPermissions()
    // {
    //     $per = Permission::query()
    //         ->whereHas('roles', function ($q) {
    //             $q->whereIn('id', $this->roles()->pluck('id')->toArray());
    //         })
    //         ->pluck('code')->toArray();

    //     $permissions = $this->permissions()->pluck('code')->toArray();

    //     $permissions = array_merge($permissions, $per);
    //     $permissions = array_unique($permissions);
    //     return $permissions;
    // }



    public function scopeFilter($q)
    {

        if (request()->filled('name') && !empty(request('name'))) {
            $key = trim(request()['name']);
            $q->where('username', 'like', "%$key%")
                ->orWhere('id_number', 'like', "%$key%")
                ->orWhere('name', 'like', "%$key%")
                ->orWhere('email', 'like', "%$key%");
        }   

        return $q;
    }
    
//     public function scopePermission($query, $permissions)
//     {

//         return $query
//             ->whereHas('permissions', function ($q) use ($permissions) {
//                 $q->whereIn('code', $permissions);
//             })
//             ->orWhereHas('roles', function ($q) use ($permissions) {
//                 $q->whereHas('permissions', function ($q) use ($permissions) {
//                     $q->whereIn('code', $permissions);
//                 });
//             });



// }



}