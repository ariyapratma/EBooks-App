<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',       // Tambahkan atribut 'name'
        'pdf_path',   // Atribut lainnya
    ];
}
