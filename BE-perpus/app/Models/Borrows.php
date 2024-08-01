<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Borrows extends Model
{
    use HasFactory, HasUuids;

    protected $table="borrows";

    protected $fillable =[
        'load_date',
        'borrow_date',
        'book_id',
        'user_id',
    ];

    public function books() {
        return $this->belongsTo(Books::class, 'book_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
