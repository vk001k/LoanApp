<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoan extends Model
{
    use HasFactory;

    protected $table = 'user_loan';

    protected $fillable = ['user_id','total_amount','term','added_on','status'];

    public function repayments(){
        return $this->hasMany(UserLoanRepayments::class,'user_loan_id','id');
    }
}
