<?php

namespace App\Services;

use App\Models\Transactions;
use Carbon\Carbon;

class WithdrawService
{
    public function processWithdraw($user, $amount)
    {
        $fee = 0;
        $user_rest_money = $user->balance - $amount;

        if ($user->account_type == 'individual') {
           
            if (Carbon::now()->dayOfWeek == Carbon::FRIDAY) {
                $fee = 0;
            } elseif ($amount == 5000 && !$this->match_with_5000($user->id)) {
                $fee = 0;
            }  elseif($amount >1000){
                
                $rate = 0.015;
                 $rate_normal = (0.015 / 100);
                 
                 

                 $restt = $amount - 1000;
               
                 
                 
                $fee = $restt * $rate_normal;
                
               
                
                 $user_rest_money = $user->balance - $amount - $fee;
                 
                
            }
            elseif ($amount != 1000) {
                $fee = $this->calculateFee($amount, 0.015);
                $user_rest_money -= $fee;
            }
           
        } elseif ($user->account_type == 'business') {
            
            $feeRate = $this->getBusinessFeeRate($user->id);
            $fee = $this->calculateFee($amount, $feeRate);
            
            $user_rest_money -= $fee;
          
            
        }

        $user->update([
            'balance' => $user_rest_money
        ]);
        Transactions::create([
            'user_id' => $user->id,
            'transaction_type' => 'withdraw',
            'amount' => $amount,
            'fee' => $fee,
            'date' => Carbon::now(),
        ]);

        return ['success' => true, 'fee' => $fee];
    }

    private function calculateFee($amount, $rate)
    {
        return $amount * ($rate / 100);
    }

    private function match_with_5000($userId)
    {
        $start_of_the_month = Carbon::now()->startOfMonth();
        $end_of_the_month = Carbon::now()->endOfMonth();

        return Transactions::where('user_id', $userId)
            ->where('transaction_type', 'withdraw')
            ->where('amount', 5000)
            ->whereBetween('created_at', [$start_of_the_month, $end_of_the_month])
            ->exists();
    }

    private function getBusinessFeeRate($userId)
    {
        $transaction_withdraw_limit = Transactions::where('user_id', $userId)
            ->where('transaction_type', 'withdraw')
            ->sum('amount');

        $limit = 50000;

        return $transaction_withdraw_limit >= $limit ? 0.015 : 0.025;
    }
}
