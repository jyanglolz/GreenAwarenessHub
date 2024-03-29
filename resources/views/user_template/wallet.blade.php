@extends('user_template.layouts.user_profile_template')

@section('profilecontent')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Wallet</div>

                <div class="card-body">
                    <p>Balance: MYR{{ auth()->user()->wallet_balance }}</p>
                    <a href="{{ route('topup') }}" class="btn btn-primary">Top-up</a>
                </div>
            </div>
        </div>
@endsection
