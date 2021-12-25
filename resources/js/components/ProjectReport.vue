 <template>
  <div class="row">
        <div class="col-md-12">
            <div class="row">
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Projects <span class="text-danger">*</span></label>
                        <select class="form-control" name="project" v-model="form.project_id"  id="project_id" title="Select Project" data-live-search="true" @change="load_budgetcodes" >
                             <option  v-for="(project,id) in projects" :key="id" :value="id">
                                                {{ project}}
                             </option>
                        </select>
                    </div>
                </div> 
                <!-- <pre class="language-json"><code>{{ allocations }}</code></pre> -->
                <div class="col-md-3">
                 <div>
                    <label class="typo__label">Select Budgetcodes</label>
                    <multiselect  v-model="value"  :options="options" :multiple="true" :close-on-select="false" :clear-on-select="true" :preserve-search="true" @input="load_budgetcatcodes" placeholder="Pick some" label="name" track-by="name" :preselect-first="true" :value="value">
                        <template slot="selection" slot-scope="{ values, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                    </multiselect>
                    <!-- {{ value }} -->
                </div>
                </div>
                 <div class="col-md-3">
                 <div>
                    <label class="typo__label">Select Budget Category Codes</label>
                    <multiselect v-model="catcodesval" :options="catcodes" :multiple="true" @input="load_expensecodes" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
                        <template slot="selection" slot-scope="{ values, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                    </multiselect>
                    <!-- {{ value }} -->
                </div>
                </div>

                 <div class="col-md-3">
                 <div>
                    <label class="typo__label">Select Expensecode Category Codes</label>
                    <multiselect v-model="expenseval" :options="expensecodes" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
                        <template slot="selection" slot-scope="{ values, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                    </multiselect>
                </div>
                </div>
            </div>
            <div class="submit-section">
                <button class="btn btn-info  btn-block" @click="load_allocation">Generate</button>
            </div>
        </div>
  
                <div class="col-md-12 mt-5">
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
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="8"></th>
                                            <th  style="text-align:right">Total: &nbsp; </th>
                                            <th width="15%"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                    </div>


 </template>
<script>
import $ from "jquery"
import DataTable from 'datatables.net-dt'

export default {
 
    data(){
        selected:null
        return{
            
            id: '',
            project: '',
            projects:{},
            budget_code_id:[2,3],
            allocations:[],
            value:[],
            options:[],
            catcodes:[],
            expenseval:[],
            expensecodes:[],
            catcodesval:[],
            form:new form({
                project_id:''
            }),
            dataTable:null,
            
        }
    
    },
    methods:{
        load_budgetcatcodes(){
            Vue.set(this, 'catcodesval', [])
            let catcodes = [];
             for(let i=0 ;i<this.value.length; i++ ){
                catcodes.push(this.value[i].id)
            }
            axios.get('get_selected_catcodes',{ params: { id:catcodes + '' }}).then((response)=>{
                this.catcodes.length = 0; // reset values on changing selector
                for(let data of response.data){
                    this.catcodes.push({id:data.id , name:data.code})
                }
            })
               

        },
        load_expensecodes(){
            Vue.set(this, 'expenseval', [])
            let expensecode = [];
             for(let i=0 ;i<this.catcodesval.length; i++ ){
                expensecode.push(this.catcodesval[i].id)
            }
            axios.get('get_selected_expensecode',{ params: { id:expensecode + '' }}).then((response)=>{
                this.expensecodes.length = 0; // reset values on changing selector
                for(let data of response.data){
                    this.expensecodes.push({id:data.id , name:data.code})
                }
            })
               
        },
        load_projects(){
             axios.get('get_projects').then(({data}) => (this.projects = data));
        },
        load_budgetcodes(){
            Vue.set(this, 'value', [])  // resets  selected values multi select on change
            Vue.set(this, 'catcodesval', [])
            Vue.set(this, 'expenseval', [])
            axios.get('get_allocated_budgetcode?id='+this.form.project_id).then((response)=>{
                this.options.length = 0; // reset values on changing selector
                for(let data of response.data){
                    this.options.push({id:data.id , name:data.code})
                }
            });
            
            
        },
        load_allocation(){
            this.dataTable.clear();
            let budgets =[];
            for(let i=0 ;i<this.value.length; i++ ){
                budgets.push(this.value[i].id)
            }
             
            let catcodes = [];
             for(let i=0 ;i<this.catcodesval.length; i++ ){
                catcodes.push(this.catcodesval[i].id)
            }
             let expensecode = [];
             for(let i=0 ;i<this.expenseval.length; i++ ){
                expensecode.push(this.expenseval[i].id)
            }
            axios.get('get_selected_allocation',{ params: { id: budgets + '',cat_id: catcodes + '', exp_id:expensecode + '' ,project_id:this.form.project_id}}).then((response) => {
                
                response.data.data.forEach(allocation =>{
                    this.dataTable.row.add([
                                allocation.id,
                                allocation.project.name,
                                allocation.budgetcode.code,
                                allocation.budgetcatcode.code,
                                allocation.expensecode.code,
                                allocation.unit,
                                allocation.number_of_activities,
                                allocation.unit_cost,
                                allocation.quantity,
                                allocation.unit_cost * allocation.quantity,
        ]).draw(false);
       
    })
            
            }).catch(err => console.log(err));
        
        }
,
InitDataTable(){
   this.dataTable =  $('#report').DataTable( {
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
 
               var total = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
 
                var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, ).display;
                  $( api.column( 9).footer() ).html(
                    numFormat( total )
            );
        },
    buttons: [
        {
            extend: 'excel',
            title: 'Agency for Assisstance and Development of Afghanistan',
            message: ' ',
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
            message: ' ',
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
       
    ]
    
} );
    }
    },
    created(){
        this.load_projects();
    },

    mounted(){
        this.InitDataTable();
      
    }
  
    
}
</script>