<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments';
    protected $dates = ['deleted_at', 'paymentDate'];

    protected $fillable = [
        'clients_id',
        'description',
        'paymentMethod',
        'paymentDate',
        'totalValue',
    ];

    public function clients()
    {
        return $this->belongsTo(Clients::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'payments_id')->withTrashed();
    }

    public const METHOD_LABELS = [
        'money' => 'Á vista (dinheiro)',
        'pix' => 'Pix',
        'ted' => 'Transferencia Bancaria',
        'credit' => 'Cartão de Crédito',
        'debit' => 'Cartão de Débito',
        'credit' => 'Cartão de Crédito',
        'boleto' => 'Boleto',
        'other' => 'Outros',
    ];

    public function label()
    {
        return self::METHOD_LABELS[$this->paymentMethod] ?? 'N/A';
    }
}
