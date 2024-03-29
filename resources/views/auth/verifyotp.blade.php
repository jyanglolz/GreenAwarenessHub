<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Phone Number') }}</div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        Please enter the OTP sent to your number {{ session('phone_number') }}
                        <form action="{{ route('verifyotp') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="verification_code"
                                       class="col-md-4 col-form-label text-md-right">{{ __('OTP:') }}</label>
                                <div class="col-md-6">
                                    <input type="hidden" name="phone_number" value="{{ session('phone_number') }}">
                                    <input id="verification_code" type="tel"
                                           class="form-control @error('verification_code') is-invalid @enderror"
                                           name="verification_code" value="{{ old('verification_code') }}" required>
                                    @error('verification_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <x-primary-button class="ms-3">
                                        {{ __('Verify Phone Number') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
