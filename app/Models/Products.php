<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getDescription(string $data)
    {
        $description = json_decode($this->description);
        return $description->$data ?? '';
    }
}
