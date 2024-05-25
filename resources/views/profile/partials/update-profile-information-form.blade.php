<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <div class="p-4">
            <a href="{{route("deposit")}}" class="" style="background:red;padding:10px 20px;color:white;">
                Deposit List
            </a>
            
            <a href="{{route("withdraw")}}" style="background:green;padding:10px 20px;color:white;margin-left:10px;">
                Withdraw List
            </a>
        </div>
       

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <div>
            <x-input-label for="account_type" :value="__('Account Type')" />
            <select id="account_type" name="account_type" class="mt-1 block w-full" required autofocus autocomplete="name" readonly disabled>
                <option value="individual" {{ old('account_type', $user->account_type) == 'individual' ? 'selected' : '' }}>Individual</option>
                <option value="business" {{ old('account_type', $user->account_type) == 'business' ? 'selected' : '' }}>Business</option>
            </select>
            
            <x-input-error class="mt-2" :messages="$errors->get('account_type')" />
        </div>
        
        @if(count($total_deposit_calculation)>0)
        <div>
            <x-input-label for="balance" :value="__('Available Balance')" />
            <x-text-input  readonly disabled  id="balance" name="deposit" type="number" class="mt-1 block w-full" :value="old('balance', $user->balance)" required autofocus autocomplete="balance" />
            <x-input-error class="mt-2" :messages="$errors->get('balance')" />
        </div>
        @else
        @php
        $user = App\Models\User::find(Auth::user()->id);
         $user->update([
            'balance'=>0.00,
        ]);
        @endphp
        <div>
            <x-input-label for="balance" :value="__('Available Balance')" />
            <x-text-input  readonly disabled  id="balance"  type="number" class="mt-1 block w-full" :value="old('balance', $user->balance)" required autofocus autocomplete="balance" />
            <x-input-error class="mt-2" :messages="$errors->get('balance')" />
        </div>
        @endif
       

        <div class="flex items-center gap-4" style="margin-bottom:10px;">
            <x-danger-button>{{ __('Update Data') }}</x-danger-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    <form action="{{route('deposit')}}" method="POST">
        @csrf
    <div>
        <x-input-label for="balance" :value="__('Insert Balance')" />
        <x-text-input   id="balance" name="deposit" type="number" class="mt-1 block w-full"  required autofocus autocomplete="balance" />
        <x-input-error class="mt-2" :messages="$errors->get('balance')" />
    </div>
    <x-primary-button style="margin-top: 20px;margin-bottom:10px;">{{ __('Insert Balance') }}</x-primary-button>

   
</form>
    <form action="{{route('withdraw')}}" method="POST">
        @csrf
        <div style="margin-top: 10px;">
            <x-input-label for="balance" :value="__('Withdraw_ammount')" />
            <x-text-input   id="balance" name="withdraw" type="number" class="mt-1 block w-full" : autofocus autocomplete="balance" />
            <x-input-error class="mt-2" :messages="$errors->get('balance')" />
                
        </div>
      
        <x-danger-button style="margin-top: 10px;">{{ __('Withdraw Balance') }}</x-danger-button>
</form>

@include('profile.partials.script')

</section>
