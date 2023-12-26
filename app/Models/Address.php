<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model {
    protected $table = "addresses";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamp = true;
    public $incrementing = true;

    protected $fillable = ['street', 'city', 'province', 'country', 'postal_code',];

    public function contact(): BelongsTo {
        return $this->belongsTo(Contact::class, "user_id", "id");
    }
}
