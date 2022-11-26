<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoanRepayments extends Model
{
    use HasFactory;

    protected $fillable = ['user_loan_id','user_id','amount','term','added_on','status'];

    public function loan_details()
    {
        return $this->belongsTo(UserLoan::class,'user_loan_id','id');

    }
}
