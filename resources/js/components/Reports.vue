<template>
    <div class="row">
    <div class="card">
                <div class="card-body">
                    <h4 class="payslip-title">Account Details</h4>
                    <div class="row">
                        <div class="col-sm-6 m-b-20">
                            <!-- <img src="" class="inv-logo" alt="">
                            <ul class="list-unstyled mb-0">
                                <li>Bank Book : </li>
                                <li>Bank Account Number :</li>
                                <li>Opening Balance :</li>
                                <li>Date : </li>
                            </ul> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div>
                                <table class="table table-bordered custom-table" id="report">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Project</th>
                                            <th>Budgetcode</th>
                                            <th>Budget Category Code</th>
                                            <th>Expensecode</th>
                                            <th>Unit</th>
                                            <th># of Activities</th>
                                            <th>Unit Cost</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="allocation in allocations.data" :key="allocation.id">
                                            <td>{{allocation.id}}</td>
                                            <td>{{allocation.project.name}}</td>
                                            <td>{{allocation.budgetcode.code}}</td>
                                            <td>{{allocation.budgetcatcode.code}}</td>
                                            <td>{{allocation.expensecode.code}}</td>
                                            <td>{{allocation.unit}}</td>
                                            <td>{{allocation.number_of_activities}}</td>
                                            <td>{{allocation.unit_cost}}</td>
                                            <td>{{allocation.quantity}}</td>
                                            <td>{{allocation.unit_cost * allocation.quantity}}</td>
                                        </tr>
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
            <div class="card">
                <div class="card-body">
                    <h4 class="payslip-title">Account Details</h4>
                    <div class="row">
                        <div class="col-sm-6 m-b-20">
                            <div>
        <ejs-grid ref='grid' :dataSource="allocations"  :toolbar="['PdfExport', 'ExcelExport']" 
        :allowPdfExport='true' :allowExcelExport='true' :toolbarClick="toolbarClick">
            <e-columns>
                <e-column field='id' headerText='ID' width='120' textAlign='Right'></e-column>
                <e-column field='project.name' headerText='Project Name' width='140'></e-column>
                <e-column field='budgetcode' headerText='Budgetcode' width='170'></e-column>
                <e-column field='budgetcatcode' headerText='Budget Cat code' width='170'></e-column>
                <e-column field='expensecode' headerText='Expensecode' width='120' textAlign='Right'></e-column>
                <e-column field='unit' headerText='Unit' width='120' textAlign='Right'></e-column>
                <e-column field='number_of_activities' headerText='number_of_activities' width='120' textAlign='Right'></e-column>
                <e-column field='unit_cost' headerText='Unit Cost' width='120' textAlign='Right'></e-column>
                <e-column field='quantity' headerText='Quantity' width='120' textAlign='Right'></e-column>
                <e-column field='total' headerText='Total' width='120' textAlign='Right'></e-column>
            </e-columns>
        </ejs-grid>
    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
</template>

<script>
import $ from 'jquery'
export default {
    props:['allocation'],
    data(){
        return{
            allocations:this.$props.allocation
        }
        
    },
    mounted(){
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
           
                var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, ).display;
 
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
            message: 'Bank Book: ',
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

  
    }
}
</script>