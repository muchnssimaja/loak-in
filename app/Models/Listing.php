<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Report;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'location',
        'description',
        'image_path',
        'seller_name',
        'seller_contact',
        'category',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'listing_category');
    }

    public function reports()
{
    return $this->hasMany(Report::class);
}

}
