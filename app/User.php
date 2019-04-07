<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $rememberTokenName = false;
    protected $fillable = ['first_name', 'last_name', 'sex'];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_roles');
    }

    public function vacation()
    {
        return $this->hasOne('App\VacationDate', 'user_id', 'id');
    }

    public function userRoles()
    {
        $userRoles = [];
        foreach($this->roles as $role):
            $userRoles[] = $role->name;
        endforeach;

        return $userRoles;
    }
    
    public function hasRole($roleItem)
    {
        return in_array($roleItem, $this->userRoles()) ? true : false;
    }

    public function printRoles()
    {
        return implode(', ', $this->userRoles());
    }

    public function printName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function printIcon()
    {
        return 'us-' . ($this->hasRole('Руководитель') ? 'main' : $this->sex);
    }
}
