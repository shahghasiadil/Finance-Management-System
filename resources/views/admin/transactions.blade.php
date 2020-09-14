@extends('layouts.admin')

@section('content')

<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Transactions</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active"> Transactions</li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table" id="receipt_transactions">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Transaction Date</th>
                        <th>Description</th>
                        <th>Account</th>
                        <th>To/From Account</th>
                        <th>Activity Code</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
$('#receipt_transactions').DataTable( {
    "processing": true,
    "serverSide": true,

    "ajax":{
            "url": "{{route('getdata')}}",
            "dataType": "json",
            "type": "GET",
            "data":{ _token: "{{csrf_token()}}"}
        },
        columns: [
                {data: 'id', name: 'id'},
                {data: 'transaction_date', name: 'transaction_date'},
                {data: 'description', name: 'description'},
                {data: 'first_account.account_name', name: 'first_account_id', "defaultContent": "<i>Not set</i>"},
                {data: 'second_account.account_name', name: 'second_account_id',  "defaultContent": "<i>Not set</i>"},
                {data: 'activity_code.name', name: 'activity_code_id', "defaultContent": "<i>Not set</i>"},
                {data: 'debit', name: 'debit'},
                {data: 'credit', name: 'credit'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
    dom: 'Bfrtip',
    searching: true,
    paging: true,
    info: true,

    buttons: [
        {
            extend: 'excel',
            title: 'Receipt Transaction Report.',   
            text : '<i class="fa fa-file-excel-o"> Excel</i>',
            exportOptions: {
                stripHtml: true,
                columns:':visible'
            }
        },
        {
            extend: 'pdf',
            title: 'Agency for Assisstance and Development of Afghanistan',
            message: 'transactions report',
            text: '<i class="fa fa-file-pdf-o"> PDF</i>',
            pageSize: 'A4',
            download: 'open',
            orientation: 'landscape',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8]
            },
            customize : function(doc) {
                doc.content[2].table.widths = [ '3%', '6%', '25%', '20%', '15%', '7%', '8%','8%', '8%'];
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