<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'slug', 'name', 'main_image', 'description', 'product_code', 'quantity', 'price', 'status', 'desktop_id', 'label_id', 'product_for', 'per_box_quantity'];

    protected $guarded = ['id'];

    public function getCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getProductImages() {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
