<?php

namespace App\Http\Controllers;

use App\Models\UserLoan;
use App\Models\UserLoanRepayments;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function loanDetails($loan_id)
    {

        $loan_details = UserLoan::with('repayments')->find($loan_id);
        if(!$loan_details){
            return redirect()->back()->with('error','Record not found.');
        }
        return view('loan-details',compact('loan_details'));

    }

    public function updateLoanStatus($loan_id){
        $loan = UserLoan::find($loan_id);
        if(!$loan){
            return redirect()->back()->with('error','Record not found');
        }

        $loan->update([
           'status'=>'approved'
        ]);
        UserLoanRepayments::where('user_loan_id',$loan_id)->update([
           'status'=>'approved'
        ]);

        return redirect()->back()->with('success','Record updated successfully');
    }
}
