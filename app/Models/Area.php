<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function clients(){
        return $this->hasMany(Client::class);
    }

    public function getTotalClients()
    {
        return $this->hasMany(Client::class)->whereAreaId($this->id)->count();

    }

    public function cities(){
        return $this->hasMany(Area::class);
    }
}
