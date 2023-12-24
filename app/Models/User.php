<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model {
    protected $table = "users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $timestamp = true;
    protected $incrementing = true;

    public function contactd(): HasMany {
        return $this->hasMany(Contact::class, 'user_id', 'id');
    }
}
