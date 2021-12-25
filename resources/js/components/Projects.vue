<template>
    <div>
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                
                    <h3 class="page-title">{{ 'Projects' | translateIn(this.locale)}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">{{ 'dashboard' | translateIn(this.locale) }}</a></li>
                        <li class="breadcrumb-item active">{{ 'Project' | translateIn(this.locale) }}</li>
                        
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
                                <th>{{ 'donor' | translateIn(this.locale) }}</th>
                                <th>{{ 'location' | translateIn(this.locale) }}</th>
                                <th>{{ 'start date' | translateIn(this.locale) }}</th>
                                <th>{{ 'end date' | translateIn(this.locale) }}</th>
                                <th>{{ 'no of months' | translateIn(this.locale) }}</th>
                                <th>{{ 'total budget' | translateIn(this.locale) }}</th>
                                <th>{{ 'status' | translateIn(this.locale) }}</th>
                                <th>{{ 'action' | translateIn(this.locale) }}</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <tr v-for="project in projects.data" :key="project.id">
                                <td>{{project.id}}</td>
                                <td><router-link :to="{path: '/allocation', query: {id: project.id}}" >{{project.name}}</router-link></td>
                                <td>{{project.code}}</td>
                                <td>{{project.donor}}</td>
                                <td>{{project.location}}</td>
                                <td>{{project.start_date}}</td>
                                <td>{{project.end_date}}</td>
                                <td>{{project.number_of_months}}</td>
                                <td>{{project.total_budget}}</td>
                                <td>{{project.status}}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" @click="edit_modal(project)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="#" @click="delete_project(project.id)"><i class="fa fa-trash m-r-5"></i> Delete</a>                                                
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="projects" @pagination-change-page="getResults">
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
                        <h5 v-show="edit_mode" class="modal-title">Edit Project</h5>
                        <h5 v-show="!edit_mode" class="modal-title">Add Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="edit_mode ? update_project() : create_project()" >
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
                                        <label class="col-form-label">Donor</label>
                                        <input v-model="form.donor" type="text" name="donor"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('donor') }">
                                        <has-error :form="form" field="donor"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">location</label>
                                        <input v-model="form.location" type="text" name="location"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('location') }">
                                        <has-error :form="form" field="location"></has-error>
                                    </div>
                                </div>
                            <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Start Date <span class="text-danger">*</span></label>
                                        <date-picker display-format="MM" format="YYYY-MM-DD" locale="en" v-model="form.start_date" ></date-picker>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">End Date <span class="text-danger">*</span></label>
                                        <date-picker display-format="MM" format="YYYY-MM-DD" locale="en" v-model="form.end_date" ></date-picker>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">No of Months</label>
                                        <input v-model="form.number_of_months" type="text" name="number_of_months"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('number_of_months') }">
                                        <has-error :form="form" field="number_of_months"></has-error>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Total Budget</label>
                                        <input v-model="form.total_budget" type="text" name="total_budget"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('total_budget') }">
                                        <has-error :form="form" field="total_budget"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="form.status" name="status" title="Status" data-live-search="false" >
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
                projects: {},
                search_input: '',
                statuses:['Active','Deactive'],

                form: new form({
                    id:'',
                    name:'',
                    code:'',
                    donor:'',
                    location: '',
                    start_date:'',
                    end_date:'',
                    number_of_months: '',// Number of Months,
                    total_budget:'',
                    status:''
                })
            }
        },
        methods: {
            //Search methds
            search_it() {
                let query = this.search_input;
                axios.get('search_project?q=' + query)
                .then((data) => {
                    this.projects = data.data
                })
                .catch(e => console.log('404'))

            },
            //pagination
            getResults(page = 1) {

                axios.get('get_project/?page=' + page)
                    .then(response => {
                        this.$Progress.start();

                        this.projects = response.data;

                        this.$Progress.finish();

                    });
            },
            // this method we open a modal for both edit and adding new customer
            new_modal() {
                this.edit_mode = false;
                this.form.reset();
                $('#add_project').modal('show');
            },

            edit_modal(project) {
                this.edit_mode = true;
                this.form.reset();
                $('#add_project').modal('show');
                this.form.fill(project);
            },

            //this method goes to customer.store and store customer data
            create_project() {
                 this.form.submit('post', '/project')
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
            update_project() 
            {
                this.form.put('project/'+this.form.id)
                .then((res)=>{

                    $('#add_project').modal('hide');

                    this.$Progress.start();

                    Fire.$emit('AfterEvent');
                    
                    if(this.locale == "en")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'Project updated successfully'
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
                axios.get('get_project').then(({data}) => (this.projects = data));
              
            },

            delete_project(id) {
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

                            this.form.delete('project/'+id).then(()=>{
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

                            this.form.delete('project/'+id).then(()=>{
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
            Fire.$on('AfterEvent',() => {
                this.load_projects();
            });
        }
    }
</script>
