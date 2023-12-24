<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model {
    protected $table = "contacts";
    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $timestamp = true;
    protected $incrementing = true;

    public function User(): BelongsTo {
        return $this->belongsTo(Contact::class, "user_id", "id");
    }
}
