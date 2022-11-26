@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Repayment Details
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
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($loan_details)
                                    @foreach($loan_details->repayments as $loan)
                                        <tr>
                                            <td>${{$loan->amount}}</td>
                                            <td>{{\Carbon\Carbon::parse($loan->added_on)->format('d-m-Y')}}</td>
                                            <td>{{$loan->status}}</td>
                                            <td>
                                                @if($loan->status == 'approved')
                                                <button type="button" class="btn btn-primary"
                                                        onclick="UpdateStatus({{$loan->id.','.$loan->amount}})">
                                                    Pay
                                                </button>
                                                    @else
                                                    -
                                                @endif
                                            </td>
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>

    </script>
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Update status</h4>
                </div>
                <form method="POST" action="#">
                @csrf
                <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Pay Amount</label>

                            <div class="col-md-6">
                                <input id="loan_amount" type="number" min="0.00" step="0.01"
                                       class="form-control @error('loan_amount') is-invalid @enderror"
                                       name="total_amount" value="{{ old('loan_amount') }}" required
                                       autocomplete="loan_amount" autofocus>

                                @error('loan_amount')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>


        </div>
    </div>
    </div>

    <script>
        function UpdateStatus(repayment_id,amount) {
            var url = '{{url('repayment/process/:id')}}';
            var url1 = url.replace(':id',repayment_id);
            $('form').attr('action',url1);
            $('#loan_amount').val(amount).attr("min",amount);
            $('#myModal').modal('show');
        }

        $('.btn-danger').on('click', function () {
            $('#myModal').modal('hide');
        })
    </script>
@endsection