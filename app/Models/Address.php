<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    protected $table = "addresses";
    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $timestamp = true;
    protected $incrementing = true;
}
