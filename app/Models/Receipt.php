<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'full_name',
        'email', 'phone',
        'receipt', 'receipt_id',
        'status'
    ];

    public function getCreatedAtAttribute($value)
    {
        $newDate = date("F j, Y g:i A", strtotime($value));
        return $newDate;
    }

    public function getUpdatedAtAttribute($value)
    {
        $newDate = date("F j, Y g:i A", strtotime($value));
        return $newDate;
    }
}
