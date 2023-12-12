<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    public function images() 
    {
        return $this->hasMany(Image::class);
    }

    public function audits()
    {
        return $this->hasMany(Audit::class, 'affected_product_id');
    }

    public function recordAudit($type)
    {
        $this->audits()->create([
            'user_id'=> auth()->id(),
            'action_type'=> $type,
        ]);
    }
}
