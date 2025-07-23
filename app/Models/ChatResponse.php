<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'trigger',
        'response',
        'keywords',
        'product_ids',
        'category',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'keywords' => 'array',
        'product_ids' => 'array',
        'is_active' => 'boolean',
    ];

    public function products()
    {
        if (!$this->product_ids) {
            return collect();
        }
        
        return Produit::whereIn('id', $this->product_ids)->get();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }
}
