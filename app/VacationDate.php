<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VacationDate extends Model
{
    protected $fillable = ['user_id', 'leave', 'back', 'accepted'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function dates()
    {
        return $this->belongsTo('App\User');
    }

    public function printLeave()
    {
        return Carbon::parse($this->leave)->format('d.m.Y') . ' - ' . Carbon::parse($this->back)->format('d.m.Y');
    }

    public function getStatusAttribute()
    {
        $status = [
            1 => 'согласовано',
            2 => 'отказано'
        ];

        return (in_array($this->accepted, array_keys($status))) ? $status[$this->accepted] : 'ожидание';
    }
}
