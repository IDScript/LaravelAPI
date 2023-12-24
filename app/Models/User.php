<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = "users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $timestamp = true;
    protected $incrementing = true;
}
