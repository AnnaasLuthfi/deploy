<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Categories extends Model
{
    use HasFactory,HasUuids;

    protected $table="categories";

    protected $fillable =[
        'name'
    ];

    public function list_books() {
        return $this->hasMany(Books::class, 'category_id');
    }

}
