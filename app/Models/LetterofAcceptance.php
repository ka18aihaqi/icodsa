<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LetterofAcceptance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'letter_of_acceptances';

    protected $fillable = [
        'author_name',
        'institution',
        'email',
        'conference_title',
        'paper_id',
        'paper_title',
        'issued_at',
        'status',
        'signature',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($loa) {
            if ($loa->status === 'Accepted') {
                \App\Models\Invoice::create([
                    'invoice_number' => self::generateInvoiceNumber(),
                    'loa_id' => $loa->id,
                    'description' => null,
                    'quantity' => 1,
                    'currency' => 'IDR',
                    'price' => null,
                    'total' => null,
                    'status' => 'Unpaid',
                    'virtual_account_id' => null,
                    'bank_transfer_id' => null,
                ]);
            }
        });        
    }

    /**
     * Generate unique invoice number
     */
    private static function generateInvoiceNumber()
    {
        $lastInvoice = \App\Models\Invoice::latest()->first();
        $lastNumber = $lastInvoice ? (int)substr($lastInvoice->invoice_number, 0, 3) : 0;
    
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $year = date('Y');
    
        return "{$newNumber}/INV/ICoDSA/{$year}";
    }
    

    /**
     * Relasi ke Invoice (One-to-One)
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
