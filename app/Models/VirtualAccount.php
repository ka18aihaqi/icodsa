<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class VirtualAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'virtual_accounts'; // Nama tabel

    protected $fillable = [
        'virtual_account_number',
        'account_holder_name',
        'bank_name',
        'bank_branch'
    ];

    // Relasi ke Invoice
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'virtual_account_id');
    }
}
