<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $timestamps = false;
    protected $table = 'authors';
    protected $primaryKey = 'id_author';

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name'
    ];
}