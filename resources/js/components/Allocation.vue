<template>
    <div>
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                
                    <h3 class="page-title">{{'Allocations' | translateIn(this.locale)}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">{{ 'dashboard' | translateIn(this.locale) }}</a></li>
                        <li class="breadcrumb-item active">{{ 'Budget Allocations' | translateIn(this.locale) }}</li>
                        
                    </ul>
                    <br>
                    <router-link to="/budgetallocation" style="font: size 1.2em;">All Allocation</router-link>
                </div>
                <div class="form-group">
                    
                </div>

               
                <div class="col-auto float-right ml-auto">
                    <a href="javascript:void(0);" class="btn add-btn" @click="new_modal"><i class="fa fa-plus"></i> {{ 'Add' | translateIn(this.locale) }} </a>
                </div>
            </div>
        </div>
        <div class="row">
            
        <div class="col-auto float-right ml-auto mb-3">
            <input type="text" :placeholder="'search' | translateIn(this.locale)" v-model="search_input" @keyup="search_it"  class="form-control" name="" id="">    
        </div> 
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table" id="receipt_transactions">
                        <thead>
                            <tr>
                                <th>{{ 'id' | translateIn(this.locale) }}</th>
                                <th>{{ 'project' | translateIn(this.locale) }}</th>
                                <th>{{ 'budget code' | translateIn(this.locale) }}</th>
                                <th>{{ 'budget category code' | translateIn(this.locale) }}</th>
                                <th>{{ 'budget expense code' | translateIn(this.locale) }}</th>
                                <th>{{ 'unit' | translateIn(this.locale) }}</th>
                                <th>{{ '# of activities' | translateIn(this.locale) }}</th>
                                <th>{{ 'unit cost' | translateIn(this.locale) }}</th>
                                <th>{{ 'quantity' | translateIn(this.locale) }}</th>
                                <th>{{ 'total' | translateIn(this.locale) }}</th>
                                <th>{{ 'action' | translateIn(this.locale) }}</th>
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
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" @click="edit_modal(allocation)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="#" @click="delete_allocation(allocation.id)"><i class="fa fa-trash m-r-5"></i> Delete</a>                                                
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="allocations" @pagination-change-page="getResults">
                        <span slot="prev-nav">&lt; {{ 'previous' | translateIn(this.locale) }}</span>
	                    <span slot="next-nav"> {{ 'next' | translateIn(this.locale) }} &gt;</span>
                    </pagination>
                </div>
            </div>
        </div>
        <!-- Edit Employee Modal -->
        <div id="add_project" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="edit_mode" class="modal-title">Edit Budget Allocation</h5>
                        <h5 v-show="!edit_mode" class="modal-title">Add Budget Allocation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="edit_mode ? update_allocation() : create_allocation()" >
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>budgetcode<span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="form.budget_code_id" name="budgetcode" title="budgetcode" data-live-search="false" @change="load_budgetcatcodes">
                                            <option  v-for="(budgetcode,id) in budgetcodes" :key="id" :value="id">
                                                {{ budgetcode}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>budget cat code<span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="form.budget_cat_code_id" name="budgetcatcode" title="budgetcatcode" data-live-search="false" @change="load_expensecodes">
                                            <option  v-for="(budgetcatcode,id) in budgetcatcodes" :key="id" :value="id">
                                                {{ budgetcatcode}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Expense code<span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="form.expense_code_id" name="expensecode" title="expensecode" data-live-search="false" >
                                            <option  v-for="(expensecode,id) in expensecodes" :key="id" :value="id">
                                                {{ expensecode}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Unit <span class="text-danger">*</span></label>
                                        <input v-model="form.unit" type="text" name="unit"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('unit') }">
                                        <has-error :form="form" field="unit"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label"># of Activities<span class="text-danger">*</span></label>
                                        <input v-model="form.number_of_activities" type="text" name="number_of_activities"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('number_of_activities') }">
                                        <has-error :form="form" field="number_of_activities"></has-error>
                                    </div>
                                </div>
                                  <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Unit Cost<span class="text-danger">*</span></label>
                                        <input v-model="form.unit_cost" type="text" name="unit_cost"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('unit_cost') }">
                                        <has-error :form="form" field="unit_cost"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Quantity<span class="text-danger">*</span></label>
                                        <input v-model="form.quantity" type="text" name="quantity"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                                        <has-error :form="form" field="quantity"></has-error>
                                    </div>
                                </div>
                                 </div>
                            <div class="submit-section">
                                <button v-show="edit_mode" class="btn btn-primary submit-btn">Update</button>
                                <button v-show="!edit_mode" class="btn btn-primary submit-btn">Save</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Employee Modal -->
    </div>
</template>

<script>

    export default {
        
        props:['locale','id'],
        data() {
            return {
                edit_mode: false,
                allocations:{},
                projects: {},
                budgetcodes:{},
                expensecodes:{},
                budgetcatcodes:{},
                search_input: '',
                form: new form({
                    id:'',
                    project_id:this.$props.id,
                    budget_code_id:'',
                    budget_cat_code_id:'',
                    expense_code_id: '',
                    unit:'',
                    number_of_activities:'',
                    unit_cost:'',
                    quantity:''
                })
            }
        },
        methods: {
            //Search methds
            search_it() {
                let query = this.search_input;
                axios.get('search_allocation?q=' + query)
                .then((data) => {
                    this.allocations = data.data
                })
                .catch(e => console.log('404'))

            },
            //pagination
            getResults(page = 1) {

                axios.get('get_allocation/?page=' + page)
                    .then(response => {
                        this.$Progress.start();

                        this.allocations = response.data;

                        this.$Progress.finish();

                    });
            },
            // this method we open a modal for both edit and adding new customer
            new_modal() {
                this.edit_mode = false;
                // this.form.reset();
                this.form.unit="";
                this.form.unit_cost="";
                this.form.number_of_activities="";
                this.form.quantity="";
                $('#add_project').modal('show');
            },

            edit_modal(allocation) {
                this.edit_mode = true;
                this.form.reset();
                $('#add_project').modal('show');
                this.form.fill(allocation);
            },

            //this method goes to customer.store and store customer data
            create_allocation() {
                 this.form.submit('post', '/allocation')
                .then((res)=>{
                    $('#add_project').modal('hide');

                    this.$Progress.start();

                    
                    if(this.locale == "en")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'Alloction created successfully'
                        });
                    }
                    else if(this.locale == "fa")
                    {
                        toast.fire({
                        icon: 'success',
                        position: 'top-left',
                        title: 'پروژه موفقانه ثبت گردید '
                        });

                    }
                    
                    Fire.$emit('AfterEvent');

                    this.$Progress.finish();
                    console.log(res)
                })
                .catch(( err)=>{
                        console.log(err)
                });
                
            },

            // update project
            update_allocation() 
            {
                this.form.put('allocation/'+this.form.id)
                .then((res)=>{

                    $('#add_project').modal('hide');

                    this.$Progress.start();

                    Fire.$emit('AfterEvent');
                    
                    if(this.locale == "en")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'Allocation updated successfully'
                        });
                    }
                    else if(this.locale == "fa")
                    {
                        toast.fire({
                        icon: 'success',
                        position: 'top-left',
                        title: 'پروژه موفقانه بروز گردید '
                        });

                    }
                    
                    this.$Progress.finish();
                    console.log(res)
                })
                .catch(()=>{

                });
            },
            // this function goes to customer.index and returns data and then we save it into customers object
            load_projects() {
                axios.get('get_projects').then(({data}) => (this.projects = data));
            },
            load_budgetcodes(){
                 axios.get('budgetcodes').then(({data}) => (this.budgetcodes = data));
            },
            load_budgetcatcodes(){
                 axios.get('budgetcatcodes').then(({data}) => (this.budgetcatcodes = data));
            },
            load_expensecodes(){
                 axios.get('expensecodes').then(({data}) => (this.expensecodes = data));
           
            },load_allocations(){
            axios.get('get_proj_alloc?id='+this.$props.id).then(({data}) => (this.allocations = data))
        },

            delete_allocation(id) {
                if(this.locale == "en")
                {
                    swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        if (result.isConfirmed) {

                            this.form.delete('allocation/'+id).then(()=>{
                                swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                            Fire.$emit('AfterEvent');

                            }).catch(()=>{
                                swal.fire(
                                    'Failed!',
                                    'There was something wrong.',
                                    'warning'
                                    )
                            })
                        }
                    })
                }
                else if(this.locale == "fa")
                {
                    swal.fire({
                    title: 'مطمین استید ؟',
                    text: "شما قادر به برگشتاندن نخواهید بود",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بلی، حذفش کن !'
                    }).then((result) => {

                        if (result.isConfirmed) {

                            this.form.delete('allocation/'+id).then(()=>{
                                swal.fire(
                                'حذف شد !',
                                'فایل مورد نظر شما حذف گردید .',
                                'success'
                                )
                            Fire.$emit('AfterEvent');

                            }).catch(()=>{
                                swal.fire(
                                    '!ناکام شد',
                                    'مشکل وجود دارد',
                                    'warning'
                                    )
                            })
                        }
                    })
                }
            }
        },
        
        created() {
            this.load_projects();
            this.load_budgetcodes();
            this.load_allocations();
            Fire.$on('AfterEvent',() => {
                this.load_allocations();
            });
        }
    }
</script>
