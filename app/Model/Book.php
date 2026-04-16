<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;
    protected $table = 'books';
    protected $primaryKey = 'id_book';

    protected $fillable = [
        'id_author',
        'id_status_book',
        'title',
        'publication_year',
        'price',
        'summary',
        'is_new'
    ];
}