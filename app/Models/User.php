<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements Authenticatable {
    protected $table = "users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $timestamp = true;
    public $incrementing = true;

    protected $fillable = [
        'name',
        'username',
        'password'
    ];

    public function getAuthIdentifierName() {
        return 'username';
    }

    public function getAuthIdentifier() {
        return $this->username;
    }

    public function getAuthPassword() {
        return $this->password;
    }

    public function getRememberToken() {
        return $this->token;
    }

    public function setRememberToken($value) {
        $this->token = $value;
    }

    public function getRememberTokenName() {
        return 'token';
    }

    public function contact(): HasMany {
        return $this->hasMany(Contact::class, 'user_id', 'id');
    }
}
