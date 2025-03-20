<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankTransfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bank_transfers'; // Nama tabel

    protected $fillable = [
        'bank_name',
        'swift_code',
        'recipient_name',
        'beneficiary_account_number',
        'bank_branch',
        'bank_address',
        'city',
        'country'
    ];

    // Relasi ke Invoice
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'bank_transfer_id');
    }
}
