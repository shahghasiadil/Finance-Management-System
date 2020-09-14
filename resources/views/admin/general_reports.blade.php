@extends('layouts.admin')


@section('content')


	<!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Account</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Account</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="payslip-title">Account Details</h4>
                    <div class="row">
                        <div class="col-sm-6 m-b-20">
                            <img src="{{asset('assets/img/aada.jpg')}}" class="inv-logo" alt="">
                            <ul class="list-unstyled mb-0">
                                <li>Bank Book : {{$account->account_name}}</li>
                                <li>Bank Account Number : {{$account->bank_account_number}}</li>
                                <li>Opening Balance : {{number_format($account->opening_balance, 2, '.', ',')}}</li>
                                <li>Date : {{$from}} - {{$to}}</li>

                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div>
                                <table class="table table-bordered custom-table" id="report">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Type tr./Code</th>
                                            <th>Description</th>
                                            <th>Account Name</th>
                                            <th>Acc Number</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $t)
                                            <tr>
                                                <td>{{$t->id}}</td>
                                                <td>{{$t->transaction_date}}</td>
                                                <td>{{$t->activity_code->name}}</td> 
                                                <td>{{$t->description}}</td>
                                                <td>{{$t->second_account ? $t->second_account->account_name : 'N/A'}}</td>
                                                <td>{{$t->second_account ? $t->second_account->bank_account_number : 'N/A'}}</td>
                                                <td>{{number_format($t->debit, 2, '.', ',')}}</td>
												<td>{{number_format($t->credit, 2, '.', ',')}}</td>
												<td>
                                                    @if($loop->first)
                                                    <?php  $balance = $balance_till_date + $t->debit - $t->credit ?>
                                                    {{number_format($balance, 2, '.', ',')}}
                                                    @else
                                                    {{number_format($balance = $balance + $t->debit - $t->credit, 2, '.', ',')}}
                                                    @endif
                                                 </td>
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5"></th>
                                            <th  style="text-align:right">Total: &nbsp; </th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                            <th width="15%"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script>
$('#report').DataTable( {
    dom: 'Bfrtip',
    searching: true,
    paging: false,
    info: true,
    "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total_debit = api
                .column( 6)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            total_credit = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
 
                var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, ).display;
 
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                numFormat( total_debit )
            );

            $( api.column( 7 ).footer() ).html(
                numFormat( total_credit )
            );
        },
    buttons: [
        {
            extend: 'excel',
            title: 'Agency for Assisstance and Development of Afghanistan',
            message: 'Bank Book: <?php echo $account->account_name ?> \n Account Number: <?php echo $account->bank_account_number ?> \n Opening Balance: <?php echo $account->opening_balance ?> \n Date: <?php echo $from ?> - <?php echo $to ?>  ',
            text : '<i class="fa fa-file-excel-o"> Excel</i>',
            footer:true,
            exportOptions: {
                stripHtml: true,
                columns:':visible'
            }
        },
        {
            extend: 'pdf',
            title: 'Agency for Assisstance and Development of Afghanistan',
            message: 'Bank Book: <?php echo $account->account_name ?> \n Account Number: <?php echo $account->bank_account_number ?> \n Opening Balance: <?php echo $account->opening_balance ?> \n Date: <?php echo $from ?> - <?php echo $to ?>  ',
            text: '<i class="fa fa-file-pdf-o"> PDF</i>',
            pageSize: 'A4',
            download: 'open',
            orientation: 'landscape',
            footer:true,
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8]
            },
            customize : function(doc) {
                doc.content[2].table.widths = [ '5%', '8%', '8%', '20%', '15%', '15%', '9%','10%','10%'];
                doc.defaultStyle.fontSize = 8; //<-- set fontsize to 16 instead of 8 
                doc.styles.tableHeader.fontSize = 8,
                doc.styles.tableHeader.alignment = 'left';
                doc.styles.tableBodyEven.alignment = 'left';
                doc.styles.tableBodyOdd.alignment = 'left'; 
            }
        },
       'colvis'
    ]
    
} );

</script>
@endsection