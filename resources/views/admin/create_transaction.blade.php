@extends('layouts.admin')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Create Transaction</h3>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-sm-12">
        <form class="needs-validation" method="post" action="{{route('transactions.store')}}"  novalidate>
            @csrf
            <div class="row">
                
                <div class="col-md-4 mb-3">
                    <label for="validationCustom02"><font style="color:red;">*</font> Transaction Date</label>
                    <div class="cal-icon">
                        <input class="form-control datetimepicker" name="transaction_date" type="text" required>
                        <div class="invalid-feedback">Select Date</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="sub_department_id"><font style="color:red;">*</font> Description </label>
                    <input type="text" class="form-control" name="description">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Activity Code <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" name="activity_code_id" title="Select Activity Code" data-live-search="true" >
                            @foreach($activity_code as $ac)
                                <option  value="{{$ac->id}}" >{{$ac->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Account <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" name="first_account_id" id="first_account" title="Select Account" data-live-search="true" >
                            @foreach($accounts as $a)
                                <option value="{{$a->id}}" >{{$a->account_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="sub_department_id"> Current Balance </label>
                    <input type="text" readonly class="form-control" id="current_balance" name="">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>From/To Account <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" name="second_account_id" title="Select To/From Account" data-live-search="true" >
                            <option value="">Select Account</option>
                            @foreach($accounts as $a)
                                <option value="{{$a->id}}" >{{$a->account_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>          
                <div class="col-md-4">
                    <label for="sub_department_id"><font style="color:red;">*</font> Amount </label>
                    <input type="text" class="form-control" name="amount" id="amount">
                </div>
            </div>
            <div class="submit-section">
                <button class="btn btn-info  btn-block" id="savebtn">Save</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
$('input[type="text"]').attr("required", "required");

$(document).ready(function(){
// Dynamic select of staffs
    $('#first_account').on('change', function (e) {
        var first_account_id = e.target.value;
        $.get('/json-account?first_account_id=' + first_account_id, function (data) {
            console.log(data);
            $.each(data, function (index, accountObj) {
                $('#current_balance').val(accountObj.balance);
            });
        });
    });

});

$('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD',
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa fa-angle-down",
                    next: 'fa fa-angle-right',
                    previous: 'fa fa-angle-left'
                }
            });

// $('#amount').on('input', function(){

// var balance = $('#current_balance').val();

// var amount = $('#amount').val();

// var integer_gross_balance = parseInt(balance);

// var integer_gross_amount = parseInt(amount);


// if(integer_gross_amount > integer_gross_balance)
// {
//     alert('Out of balance');

//     $('#savebtn').attr('disabled', 'disabled');
// }
// else
// {
//     $('#savebtn').attr('disabled', false);

// }


// });

</script>
@endsection