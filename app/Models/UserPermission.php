<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'route_name',
    ];

    public static function routeNameList(): array
    {
        return [
            'dashboard',
            'pages',
            'navigation-menus',
            'users',
            'user-permissions',
        ];
    }

    public static function isRoleHasRightAccess($userRole, $routeName): bool
    {
        try {
            $model = static::where('role', $userRole)
                ->where('route_name', $routeName)
                ->first();
            return $model ? true : false;
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }
}
