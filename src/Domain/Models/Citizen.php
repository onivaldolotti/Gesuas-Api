<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    protected $table = 'citizens';
    protected $fillable = ['name', 'nis'];
}
