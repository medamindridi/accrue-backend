<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Achievement;
use App\Xp;
use App\Stat;
class User extends Model
{
    protected $dateFormat = 'Y-m-d';
    public function achievements(){
        return $this->hasMany(Achievement::class);
    }
    public function xps(){
        return $this->hasMany(Xp::class);
    }
    public function stats(){
        return $this->hasMany(Stat::class);
    }
}
