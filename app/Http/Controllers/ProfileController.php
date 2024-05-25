<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {

        $total_deposit_calculation = Transactions::where('user_id', Auth::user()->id)
            ->where('transaction_type', 'deposit')
            ->get();
        $deposit_list = Transactions::where('user_id', Auth::user()->id)
            ->where('transaction_type', 'deposit')
            ->get();

        return view('profile.edit', [
            'user' => $request->user(),
            'total_deposit_calculation' => $total_deposit_calculation,
            'deposit_list' => $deposit_list,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {


        $request->user()->fill($request->validated());



        if ($request->email) {

            $request->user()->email =  $request->email;
        }
        if ($request->account_type) {


            $request->user()->account_type = $request->account_type;
        }
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

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
