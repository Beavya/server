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
        'is_new',
        'cover'
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class, 'id_book', 'id_book');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'id_author', 'id_author');
    }

    public function totalLoansCount(): int
    {
        return $this->loans()->count();
    }
}