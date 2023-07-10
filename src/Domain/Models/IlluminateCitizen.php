<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class IlluminateCitizen extends Model
{
    protected $table = 'citizens';
    protected $fillable = ['name', 'nis'];
}
