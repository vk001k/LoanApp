<?php

namespace App\Http\Controllers;

use App\Http\Requests\loanRequest;
use App\Models\UserLoanRepayments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserLoan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $loans = UserLoan::where('user_id',auth()->id())->latest()->get();
        return view('loan-request-lists',compact('loans'));
    }

    public function adminHome()
    {
        $loans = UserLoan::with('repayments')->latest()->get();
        return view('admin.loan-request-lists',compact('loans'));
    }

    public function loanRequest()
    {
        return view('loan-request');
    }

    public function loanRequestProcess(loanRequest $request)
    {
       $formData = $request->except('_token');
       $formData['user_id'] = auth()->id();
       $per_term_cost = $formData['total_amount']/$formData['term'];
       $add_date = $formData['added_on'];
       DB::beginTransaction();
       try{
           $loan = UserLoan::create($formData);
           for ($i=0; $i<=$formData['term'] - 1; $i++){
               $add_date = Carbon::parse($add_date)->addDay(7)->format('Y-m-d');
               UserLoanRepayments::create([
                   'user_loan_id' => $loan->id,
                   'user_id' =>auth()->id(),
                   'amount' => $per_term_cost,
                   'term' =>1,
                   'added_on' =>$add_date,
                   'status'=>'pending'
               ]);

           }
           DB::commit();
           return redirect()->route('home')->with('success','Form submitted successfully');
       }catch (\Exception $exception){
           DB::rollBack();
           Log::error($exception->getMessage());
           return redirect()->back()->with('error','Something went wrong');
       }
    }

    public function loanRequestLists()
    {
        $loans = UserLoan::where('user_id',auth()->id())->latest()->get();
        return view('loan-request-lists',compact('loans'));

    }

    public function loanDetails($loan_id)
    {

        $loan_details = UserLoan::with('repayments')->where([['user_id',auth()->id()],['id',$loan_id]])->first();
        if(!$loan_details){
            return redirect()->back()->with('error','Record not found.');
        }
        return view('loan-details',compact('loan_details'));

    }

    public function repaymentProcess($repay_id,Request $request)
    {
        $repay = UserLoanRepayments::with('loan_details')->where([['user_id',auth()->id()]])->find($repay_id);
        if(!$repay){
          return redirect()->back()->with('error','Not found');
        }

        $repay->update([
           'status'=>'paid',
            'amount' => $request->total_amount
        ]);
        $paid_count = UserLoanRepayments::where([['status','paid'],['user_loan_id',$repay->user_loan_id]])->count();
        if($paid_count === $repay->loan_details->term){
            UserLoan::find($repay->user_loan_id)->update([
               'status' =>'paid'
            ]);
        }
        return redirect()->back()->with('success','Record updated successfully');
    }

}
