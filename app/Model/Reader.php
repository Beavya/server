<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    public $timestamps = false;
    protected $table = 'readers';
    protected $primaryKey = 'card_number';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'address',
        'phone_number'
    ];

    public function isActive(): bool
    {
        return Loan::where('card_number', $this->card_number)
            ->where('id_status_loan', 1)
            ->exists();
    }
}