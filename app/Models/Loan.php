<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable = [
        'book_id',
        'user_id',
        'loan_date',
        'expected_return_date',
        'returned_date',

    ];
}
