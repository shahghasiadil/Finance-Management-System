<template>
    <div>
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                
                    <h3 class="page-title">{{ 'Budget Expense Codes' | translateIn(this.locale)}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">{{ 'dashboard' | translateIn(this.locale) }}</a></li>
                        <li class="breadcrumb-item active">{{ 'budget expense category codes' | translateIn(this.locale) }}</li>
                        
                    </ul>
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
                                <th>{{ 'name' | translateIn(this.locale) }}</th>
                                <th>{{ 'code' | translateIn(this.locale) }}</th>
                                <th>{{ 'description' | translateIn(this.locale) }}</th>
                                <th>{{ 'budget category code' | translateIn(this.locale) }}</th>
                                <th>{{ 'type' | translateIn(this.locale) }}</th>
                                <th>{{ 'action' | translateIn(this.locale) }}</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <tr v-for="expensecode in expensecodes.data" :key="expensecode.id">
                                <td>{{expensecode.id}}</td>
                                <td>{{expensecode.name}}</td>
                                <td>{{expensecode.code}}</td>
                                <td>{{expensecode.description}}</td>
                                <td>{{expensecode.budget_cat_code.code}}</td>
                                <td>{{expensecode.type}}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" @click="edit_modal(expensecode)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="#" @click="delete_expensecodes(expensecode.id)"><i class="fa fa-trash m-r-5"></i> Delete</a>                                                
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="expensecodes" @pagination-change-page="getResults">
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
                        <h5 v-show="edit_mode" class="modal-title">Edit Expense Code</h5>
                        <h5 v-show="!edit_mode" class="modal-title">Add Expense Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="edit_mode ? update_expensecode() : create_expensecode()" >
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <input v-model="form.name" type="text" name="name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Code <span class="text-danger">*</span></label>
                                        <input v-model="form.code" type="text" name="code"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                                        <has-error :form="form" field="code"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">description</label>
                                        <input v-model="form.description" type="text" name="description"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                        <has-error :form="form" field="description"></has-error>
                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>budget cat code<span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="form.budget_cat_code_id" name="budgetcatcode" title="budgetcatcode" data-live-search="false" >
                                            <option  v-for="(budgetcatcode,id) in budgetcatcodes" :key="id" :value="id">
                                                {{ budgetcatcode}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Type <span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="form.type" name="type" title="Status" data-live-search="false" >
                                            <option  v-for="(status,id) in statuses" :key="id" :value="status">
                                                {{ status}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                         
                                 </div>
                            <div class="submit-section">
                                <button v-show="edit_mode" class="btn btn-primary submit-btn">Update</button>
                                <button v-show="!edit_mode" class="btn btn-primary submit-btn">Save</button>
                            </div>
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
        
        props:['locale'],
        data() {
            return {
                edit_mode: false,
                budgetcatcodes:{},
                expensecodes: {},
                search_input: '',
                statuses:['Credit','Debit'],

                form: new form({
                    id:'',
                    name:'',
                    code:'',
                    description:'',
                    budget_cat_code_id:'',
                    type: '',
                })
            }
        },
        methods: {
            //Search methds
            search_it() {
                let query = this.search_input;
                axios.get('search_expensecode?q=' + query)
                .then((data) => {
                    this.expensecodes = data.data
                })
                .catch(e => console.log('404'))

            },
            //pagination
            getResults(page = 1) {

                axios.get('get_expensecode/?page=' + page)
                    .then(response => {
                        this.$Progress.start();

                        this.expensecodes = response.data;

                        this.$Progress.finish();

                    });
            },
            // this method we open a modal for both edit and adding new customer
            new_modal() {
                this.edit_mode = false;
                this.form.reset();
                $('#add_project').modal('show');
            },

            edit_modal(expensecode) {
                this.edit_mode = true;
                this.form.reset();
                $('#add_project').modal('show');
                this.form.fill(expensecode);
            },

            //this method goes to customer.store and store customer data
            create_expensecode() {
                 this.form.post('expensecode')
                .then((res)=>{
                    $('#add_project').modal('hide');

                    this.$Progress.start();

                    
                    if(this.locale == "en")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'Expense Code created successfully'
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
            update_expensecode() 
            {
                this.form.put('expensecode/'+this.form.id)
                .then((res)=>{

                    $('#add_project').modal('hide');

                    this.$Progress.start();

                    Fire.$emit('AfterEvent');
                    
                    if(this.locale == "en")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'Expense Code updated successfully'
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
            load_expensecodes() {
                axios.get('get_expensecode').then(({data}) => (this.expensecodes = data));
              
            },
            load_budgetcatcodes() {
                axios.get('get_budgetcatcodes').then(({data}) => (this.budgetcatcodes = data));
              
            },

            delete_expensecodes(id) {
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

                            this.form.delete('expensecode/'+id).then(()=>{
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

                            this.form.delete('expensecode/'+id).then(()=>{
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
            this.load_expensecodes();
            this.load_budgetcatcodes();
            Fire.$on('AfterEvent',() => {
               this.load_expensecodes();
            });
        }
    }
</script>
