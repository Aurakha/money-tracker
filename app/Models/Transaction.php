<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Allow mass-assignment for the fields that come from the form.
     */
    protected $fillable = [
        'description',
        'amount',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
