<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Books extends Model
{
    use HasFactory, HasUuids;

    protected $table = "books";

    protected $fillable = [
        'title',
        'summary',
        'image',
        'stok',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    // public function list_borrows()
    // {
    //     return $this->belongsToMany(User::class, 'borrows',  'book_id', 'user_id');
    // }
    public function list_borrows()
    {
        return $this->hasMany(Borrows::class, 'book_id');
    }
}
