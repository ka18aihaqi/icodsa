<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoices';

    protected $fillable = [
        'invoice_number',
        'loa_id',
        'description',
        'quantity',
        'currency',
        'price',
        'total',
        'status',
        'virtual_account_id',
        'bank_transfer_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($invoice) {
            if ($invoice->isDirty('status') && $invoice->status === 'Paid') {
                if (!$invoice->receipt) {
                    Receipt::create([
                        'invoice_id' => $invoice->id,
                        'received_from' => null,
                        'amount' => $invoice->total,
                        'in_payment_of' => null,
                        'payment_date' => null,
                    ]);
                    Log::info("Receipt automatically created for Invoice #{$invoice->invoice_number}");
                }
            }
        });
    }

    /**
     * Relasi ke model LoA (Many-to-One)
     */
    public function letterofAcceptance()
    {
        return $this->belongsTo(LetterOfAcceptance::class, 'loa_id');
    }

    /**
     * Relasi ke model VirtualAccount (Many-to-One)
     */
    public function virtualAccount()
    {
        return $this->belongsTo(VirtualAccount::class, 'virtual_account_id');
    }

    /**
     * Relasi ke model BankTransfer (Many-to-One)
     */
    public function bankTransfer()
    {
        return $this->belongsTo(BankTransfer::class, 'bank_transfer_id');
    }

    /**
     * Relasi ke model Receipt (One-to-One)
     */
    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }
}

