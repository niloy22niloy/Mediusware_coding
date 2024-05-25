<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithdrawRequest;
use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\WithdrawService;

class AccountController extends Controller
{
    //
    protected $withdrawServices;
    public function __construct(WithdrawService $withdrawServices){
        $this->withdrawServices = $withdrawServices;
    }


    public function withdraw(WithdrawRequest $request)
    {
        $user = Auth::user();
        $amount = $request->withdraw;

        //used dependency injection for better code organization
        try {
            $result = $this->withdrawServices->processWithdraw($user, $amount);
            if ($result['success']) {
                return back()->with('success', "Successfully withdrawn " . $amount);
            }
        } catch (\Exception $e) {
            return back()->with('error', "An unexpected error occurred: " . $e->getMessage());
        }
    }

    public function deposit()
    {

        $deposit_list = Transactions::where('user_id', Auth::user()->id)->where('transaction_type','deposit')->get();
        return view('profile.partials.deposit_list', [
            'deposit_list' => $deposit_list,
        ]);
    }


    public function deposit_post(Request $request)
    {
         
        $request->validate([
            'deposit' => 'required|numeric|min:500',
        ]);





        $totals = 0;

        if ($request->deposit) {
            $user = $request->user();

            $total_deposit_calculation = Transactions::where('user_id', $user->id)
                ->where('transaction_type', 'deposit')
                ->get();

           

            $tt = $request->deposit + Auth::user()->balance;

            // Update the user's balance with the updated total
            $user->balance = $tt;

            // Save the updated user balance
            $user->save();

            $currentDateTime = Carbon::now();

            // Set the timezone to 'Asia/Dhaka'
            $currentDateTime->setTimezone('Asia/Dhaka');
            // Insert transaction record
            Transactions::create([
                'user_id' => $user->id,
                'transaction_type' => 'deposit',
                'amount' => $request->deposit,
                'fee' => 0,
                'date' => $currentDateTime, // Get current date and time
            ]);
        }

        $request->user()->save();
        return back()->with('success','Successfully Inserted '. $request->deposit);

        // return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    public function withdraw_list()
    {
        $withdraw_list =  Transactions::where('user_id', Auth::user()->id)->where('transaction_type', 'withdraw')->get();
        return view('profile.partials.withdraw_list', [
            'withdraw_list' => $withdraw_list,
        ]);
    }
}
