<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class WithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'withdraw' => 'required|numeric|min:500',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::user();
            $amount = $this->input('withdraw');

            if ($amount <= 0) {
                $validator->errors()->add('withdraw', 'Sorry, invalid number');
            }

            if ($amount == $user->balance) {
                $validator->errors()->add('withdraw', 'Sorry, you cannot withdraw the same amount you have');
            }

            if ($amount > $user->balance) {
                $validator->errors()->add('withdraw', 'Sorry, you have entered more than your balance');
            }

            if (($user->balance - $amount) < 5) {
                $validator->errors()->add('withdraw', 'Sorry, you must leave at least 5 Taka of balance in your account');
            }
        });
    }
}
