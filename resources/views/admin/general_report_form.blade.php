@extends('layouts.admin')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Generate Report</h3>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-sm-12">
        <form class="needs-validation" target="_blank" method="post" action="{{route('generate_report')}}"  novalidate>
            @csrf
            <div class="row">
                
                <div class="col-md-3 mb-3">
                    <label for="validationCustom02"><font style="color:red;">*</font> from</label>
                    <div class="cal-icon">
                        <input class="form-control datetimepicker" name="from" type="text">
                        <div class="valid-feedback">looks good!</div>
                        <div class="invalid-feedback">Select a date</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationCustom02"><font style="color:red;">*</font> to</label>
                    <div class="cal-icon">
                        <input class="form-control datetimepicker" name="to" type="text">
                        <div class="valid-feedback">looks good!</div>
                        <div class="invalid-feedback">Select a date</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Activity Type <span class="text-danger">*</span></label>
                        <select class="form-control  selectalloption" name="activity_code_id[]" multiple="multiple" id="department" title="Select Activity Code" data-live-search="true" >
                            @foreach($activity_code as $a)
                                <option selected value="{{$a->id}}" >{{$a->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div> 
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Account <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" name="account_id" required  title="Select Account" data-live-search="true" >
                            @foreach($accounts as $a)
                                <option value="{{$a->id}}" >{{$a->account_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="submit-section">
                <button class="btn btn-info  btn-block">Generate</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
$('.selectalloption').multipleSelect();

$('input[type="text"]').attr("required", "required");

</script>
@endsection