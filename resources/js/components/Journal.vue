<template>
    <div>
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                
                    <h3 class="page-title">{{ 'Journals' | translateIn(this.locale)}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">{{ 'dashboard' | translateIn(this.locale) }}</a></li>
                        <li class="breadcrumb-item active">{{ 'Journals' | translateIn(this.locale) }}</li>
                        
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
                                <th>{{ 'date' | translateIn(this.locale) }}</th>
                                <th>{{ 'voucher No #' | translateIn(this.locale) }}</th>
                                <th>{{ 'location' | translateIn(this.locale) }}</th>
                                <th>{{ 'Bgt.Code' | translateIn(this.locale) }}</th>
                                <th>{{ 'Bgt.Ctg.Code' | translateIn(this.locale) }}</th>
                                <th>{{ 'Expense Code' | translateIn(this.locale) }}</th>
                                <th>{{ 'Remarks' | translateIn(this.locale) }}</th>
                                <th>{{ 'total expenses' | translateIn(this.locale) }}</th>
                                <th>{{ 'action' | translateIn(this.locale) }}</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <tr v-for="journal in journals.data" :key="journal.id">
                                <td>{{journal.id}}</td>
                                <td>{{journal.date}}</td>
                                <td>{{journal.voucher.number}}</td>
                                <td>{{journal.location}}</td>
                                <td>{{journal.budgetcode.code}}</td>
                                <td>{{journal.budgetcatcode.code}}</td>
                                <td>{{journal.expensecode.code}}</td>
                                <td>{{journal.remarks}}</td>
                                <td>{{journal.total_expense}}</td>
                        
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" @click="edit_modal(journal)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="#" @click="delete_journal(journal.id)"><i class="fa fa-trash m-r-5"></i> Delete</a>                                                
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="journals" @pagination-change-page="getResults">
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
                        <h5 v-show="edit_mode" class="modal-title">Edit Journal</h5>
                        <h5 v-show="!edit_mode" class="modal-title">Add Journal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="edit_mode ? update_journal() : create_journal()" >
                            <div class="row">
    
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                        <date-picker display-format="MM" format="YYYY-MM-DD" locale="en" v-model="form.date" ></date-picker>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Vouchers <span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="form.voucher_id" name="status" title="Status" data-live-search="false" >
                                            <option  v-for="(voucher,id) in vouchers" :key="id" :value="id">
                                                {{ voucher}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Location Name</label>
                                        <input v-model="form.location" type="text" name="location"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('location') }">
                                        <has-error :form="form" field="location"></has-error>
                                    </div>
                                </div>
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
                                        <label>budgetcatcode<span class="text-danger">*</span></label>
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
                                        <label class="col-form-label">Remarks</label>
                                        <input v-model="form.remarks" type="text" name="total_expense"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('remarks') }">
                                        <has-error :form="form" field="remarks"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Total Expense</label>
                                        <input v-model="form.total_expense" type="text" name="total_expense"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('total_expense') }">
                                        <has-error :form="form" field="total_expense"></has-error>
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
        
        props:['locale'],
        data() {
            return {
                edit_mode: false,
                journals:{},
                budgetcodes: {},
                budgetcatcodes: {},
                expensecodes: {},
                vouchers:{},
                search_input: '',
                
                form: new form({
                    id:'',
                    date:'',
                    location:'',
                    voucher_id:'',
                    budget_code_id: '',
                    budget_cat_code_id: '',
                    expense_code_id:'',
                    remarks:'',
                    total_expense:'',
                })
            }
        },
        methods: {
            //Search methds
            search_it() {
                let query = this.search_input;
                axios.get('search_journal?q=' + query)
                .then((data) => {
                    this.journals = data.data
                })
                .catch(e => console.log('404'))

            },
            //pagination
            getResults(page = 1) {

                axios.get('get_journal/?page=' + page)
                    .then(response => {
                        this.$Progress.start();

                        this.journals = response.data;

                        this.$Progress.finish();

                    });
            },
            // this method we open a modal for both edit and adding new customer
            new_modal() {
                this.edit_mode = false;
                this.form.reset();
                $('#add_project').modal('show');
            },

            edit_modal(journal) {
                this.edit_mode = true;
                this.form.reset();
                $('#add_project').modal('show');
                this.form.fill(journal);
            },

            //this method goes to customer.store and store customer data
            create_journal() {
                 this.form.submit('post', '/journal')
                .then((res)=>{
                    $('#add_project').modal('hide');

                    this.$Progress.start();

                    
                    if(this.locale == "en")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'Project created successfully'
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
            update_journal() 
            {
                this.form.put('journal/'+this.form.id)
                .then((res)=>{

                    $('#add_project').modal('hide');

                    this.$Progress.start();

                    Fire.$emit('AfterEvent');
                    
                    if(this.locale == "en")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'Journal updated successfully'
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
            delete_journal(id) {
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

                            this.form.delete('journal/'+id).then(()=>{
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

                            this.form.delete('journal/'+id).then(()=>{
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
            },
             load_budgetcodes(){
                 axios.get('get_budget_codes').then(({data}) => (this.budgetcodes = data));
            },
            load_budgetcatcodes(){
                axios.get('get_budget_cat_codes').then(({data}) => (this.budgetcatcodes = data));
            },
            load_expensecodes(){
                 axios.get('get_expense_codes').then(({data}) => (this.expensecodes = data));
            },
            load_journals(){
                axios.get('/get_journal').then(({data}) => (this.journals = data));
            },
            load_vouchers(){
                 axios.get('get_vouchers').then(({data}) => (this.vouchers = data));
            },

        },
        created() {
            this.load_budgetcodes()
            this.load_vouchers()
            this.load_journals();
            Fire.$on('AfterEvent',() => {
                this.load_journals();
            });
        }
    }
</script>
