@extends('layouts.admin')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Edit Transaction</h3>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-sm-12">
        <form class="needs-validation" method="post" action="{{route('transactions.update', $transaction->id)}}"  novalidate>
            {{method_field('PUT')}}
            @csrf
            <div class="row">
                
                <div class="col-md-4 mb-3">
                    <label for="validationCustom02"><font style="color:red;">*</font> Transaction Date</label>
                    <div class="cal-icon">
                        <input class="form-control datetimepicker" value="{{old('transaction_date', $transaction->transaction_date)}}" name="transaction_date" type="text" required>
                        <div class="invalid-feedback">Select Date</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="sub_department_id"><font style="color:red;">*</font> Description </label>
                    <input type="text" class="form-control" value="{{old('description', $transaction->description)}}" name="description">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Activity Code <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" name="activity_code_id" title="Select Activity Code" data-live-search="true" >
                            @foreach($activity_code as $ac)
                                <option {{$ac->id == $transaction->activity_code_id ? 'selected' : ''}}  value="{{$ac->id}}" >{{$ac->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Account <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" name="first_account_id" title="Select Account" data-live-search="true" >
                            @foreach($accounts as $a)
                                <option {{$a->id == $transaction->first_account_id ? 'selected' : ''}} value="{{$a->id}}" >{{$a->account_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>From/To Account <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" name="second_account_id" title="Select To/From Account" data-live-search="true" >
                            <option value="">Select Account</option>
                            @foreach($accounts as $a)
                                <option {{$a->id == $transaction->second_account_id ? 'selected' : ''}} value="{{$a->id}}" >{{$a->account_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>          
                <div class="col-md-2">
                    <label for="sub_department_id"><font style="color:red;">*</font> Amount </label>
                    <input type="text" value="{{old('amount', $transaction->amount)}}" class="form-control" name="amount">
                </div>

                <div class="col-md-2">
                    <label for="sub_department_id"><font style="color:red;">*</font> Priority </label>
                    <input type="text" value="{{old('priority', $transaction->priority)}}" class="form-control" name="priority">
                </div>
            </div>
            <div class="submit-section">
                <button class="btn btn-info  btn-block">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
$('input[type="text"]').attr("required", "required");


$('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa fa-angle-down",
                    next: 'fa fa-angle-right',
                    previous: 'fa fa-angle-left'
                }
            });
</script>
@endsection