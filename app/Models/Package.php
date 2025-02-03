<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Package extends Model {

    use HasFactory, Notifiable;

    public $timestamps = false;

    public function drink() {

        return $this->hasMany( Drink::class );
    }
}
