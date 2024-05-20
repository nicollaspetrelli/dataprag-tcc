<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'services';
    protected $dates = ['deleted_at', 'dateExecution', 'dateValidity'];

    protected $casts = [
        'expired' => 'integer',
        'documents_id' => 'integer',
        'clients_id' => 'integer',
        'payments_id' => 'integer',
    ];

    protected $fillable = [
        'name',
        'description',
        'value',
        'dateExecution',
        'dateValidity',
        'clients_id',
        'documents_id',
        'details',
        'expired',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function hasProducts(): bool
    {
        return $this->products ? true : false;
    }

    public function products()
    {
        $productsArray = json_decode($this->products);
        $products = [];

        foreach ($productsArray as $product) {
            $products[] = Products::find($product);
        }

        return $products;
    }

    public function hasProduct(string $productId): bool
    {
        $products = $this->products();

        foreach ($products as $product) {
            if ($product->id == $productId) {
                return true;
            }
        }

        return false;
    }

    public function productsNames(): string
    {
        $productsArray = json_decode($this->products);
        $products = [];

        foreach ($productsArray as $product) {
            $products[] = Products::find($product)->name;
        }

        return implode(' - ', $products);
    }

    public function clients()
    {
        return $this->belongsTo(Clients::class);
    }

    public function documents()
    {
        return $this->belongsTo(Document::class);
    }

    public function payments()
    {
        return $this->belongsTo(Payment::class);
    }

    public function payStatus()
    {
        return $this->payments_id;
    }
}
