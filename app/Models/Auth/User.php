<?php

namespace App\Models\Auth;

use App\Models\School\Classes;
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
        'name',
        'email',
        'password',
        'school_id',
        'role_id'
    ];

    protected $casts=[
        'role_id'=> 'integer',
        'school_id'=> 'integer',
    ];
    protected $fillable = self::FILLABLE;
    public $timestamps=false;

    protected $hidden = [
        'password',
    ];

    public function school(){
        return $this->belongsTo(Schools::class, 'school_id' , 'id');
    }
     public function classes()
     {
         return $this->belongsToMany(Classes::class, 'user_classes', 'user_id', 'class_id');
     }

    public function permissions()
    {
        return $this->belongsToMany(RolePermission::class, 'role_permissions', 'role_id ', 'permission_id');

    }
    public function getAllPermissions(){
        $data = User::join('role_permissions', 'role_permissions.role_id', '=', 'users.role_id')
            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
            ->where('users.role_id','=',$this->role_id)
            ->get(['permissions.name', 'permissions.code', 'permissions.id']);
        return $data;
    }
    public function getAllPermissions1()
    {
        $per = Permission::query()
            ->whereHas('roles', function ($q) {
                $q->whereIn('id', $this->roles()->pluck('id')->toArray());
            })
            ->pluck('code')->toArray();

        $permissions = $this->permissions()->pluck('code')->toArray();

        $permissions = array_merge($permissions, $per);
        $permissions = array_unique($permissions);
        return $permissions;
    }

    public function scopePermission($query, $permissions)
    {

        return $query
            ->whereHas('permissions', function ($q) use ($permissions) {
                $q->whereIn('code', $permissions);
            })
            ->orWhereHas('roles', function ($q) use ($permissions) {
                $q->whereHas('permissions', function ($q) use ($permissions) {
                    $q->whereIn('code', $permissions);
                });
            });



    }

    public function scopeFilter($q)
    {
        if (request()->filled('role_id') && !empty(request('role_id'))) {
            $key = trim(request()['role_id']);
            $q->where('role_id', '=', $key);
        }
        if (request()->filled('school_id') && !empty(request('school_id'))) {
            $key = trim(request()['school_id']);
            $q->where('school_id', '=', $key);
        }
        if (request()->filled('name') && !empty(request('name'))) {
            $key = trim(request()['name']);
            $q->where('name', 'like', "%$key%")
                ->orWhere('email', 'like', "%$key%");
        }


        return $q;
    }

//     public function roles()
//     {
//         return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
//     }

    // public function permissions(): BelongsToMany
    // {
    //     return $this->belongsToMany(Permission::class, 'access_control_user_permission', 'user_id', 'permission_id');
    // }





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
