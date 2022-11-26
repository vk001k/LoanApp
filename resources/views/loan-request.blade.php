@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session()->get('success')}}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session()->get('error')}}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Apply for loan</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('loan-request.process') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Loan amount</label>

                                <div class="col-md-6">
                                    <input id="loan_amount" type="number" min="0.00" max="10000.00" step="0.01" class="form-control @error('loan_amount') is-invalid @enderror" name="total_amount" value="{{ old('loan_amount') }}" required autocomplete="loan_amount" autofocus>

                                    @error('loan_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="term" class="col-md-4 col-form-label text-md-end">Term</label>

                                <div class="col-md-6">
                                    <input id="term" type="number" class="form-control @error('term') is-invalid @enderror" min="1" step="1" name="term" value="{{ old('term') }}" required autocomplete="term">

                                    @error('term')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="date" class="col-md-4 col-form-label text-md-end">date</label>

                                <div class="col-md-6">
                                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="added_on" required autocomplete="date">

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a href="{{route('home')}}" type="submit" class="btn btn-dark">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection