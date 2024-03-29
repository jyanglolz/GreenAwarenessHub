@extends('user_template.layouts.user_profile_template')

@section('profilecontent')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Top-up Balance</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('wallet.topup.post') }}"> <!-- Corrected route name -->
                        @csrf
                        <div class="form-group">
                            <label for="amount">Enter Top-up Amount:</label>
                            <input type="number" name="amount" id="amount" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Top-up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
