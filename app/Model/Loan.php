<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public $timestamps = false;
    protected $table = 'books_loans';
    protected $primaryKey = 'id_loan';

    protected $fillable = [
        'id_book',
        'card_number',
        'loan_date',
        'return_date',
        'actual_return_date',
        'id_status_loan'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_book', 'id_book');
    }

    public function reader()
    {
        return $this->belongsTo(Reader::class, 'card_number', 'card_number');
    }

    public function isOverdue(): bool
    {
        if ($this->actual_return_date && $this->return_date) {
            return $this->actual_return_date > $this->return_date;
        }

        return false;
    }
}