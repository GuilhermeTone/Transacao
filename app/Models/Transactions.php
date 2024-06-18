<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $fillable = ['email_payer', 'email_payee', 'value', 'status', 'message', 'fail_code', 'email_date'];
}
