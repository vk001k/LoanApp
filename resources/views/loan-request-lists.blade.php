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
                    <div class="card-header">
                        Loan Lists
                        <a href="{{route('loan-request')}}" class="btn btn-primary float-end">New Loan Request</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Loan Amount</th>
                                    <th>Term</th>
                                    <th>Added on</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($loans)>0)
                                    @foreach($loans as $loan)
                                    <tr>
                                        <td>${{$loan->total_amount}}</td>
                                        <td>{{$loan->term}}</td>
                                        <td>{{\Carbon\Carbon::parse($loan->added_on)->format('d-m-Y')}}</td>
                                        <td>{{$loan->total_amount}}</td>
                                        <td>{{$loan->status}}</td>
                                        <td><a href="{{route('loan-details',$loan->id)}}" class="btn btn-warning">View </a></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" style="text-align: center;">No Records Found!</td>
                                    </tr>

                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection