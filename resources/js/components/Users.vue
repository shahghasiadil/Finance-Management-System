<template>
    <div>
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">users</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="javascript:void(0);" class="btn add-btn" @click="new_modal"><i class="fa fa-plus"></i> {{ 'Add' | translateIn(this.locale) }} </a> 

                </div>
            </div>
        </div>
        <div class="row">

        <div class="col-auto float-right ml-auto mb-3">
            <input type="text" placeholder="Search..." v-model="search_input" @keyup="search_it"  class="form-control" name="" id="">    
        </div> 
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table" id="receipt_transactions">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" :key="user.id">
                                <td>{{user.id}}</td>
                                <td>{{user.user_name}}</td>
                                <td>{{user.role.name}}</td>
                                <td>
                                    <span v-show="user.status==1" class="badge badge-success">Active</span>
                                    <span v-show="user.status==0" class="badge badge-danger">Not Active</span>
                                </td>
                                <td>{{user.created_at | dates}}</td>
                                <td>{{user.updated_at | dates}}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" @click="edit_modal(user)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="#" @click="delete_user(user.id)"><i class="fa fa-trash m-r-5"></i> Delete</a>                                                
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="users" @pagination-change-page="getResults">
                        <span slot="prev-nav">&lt; Previous</span>
	                    <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
            </div>
        </div>
        <!-- Edit user Modal -->
        <div id="add_user" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="edit_mode" class="modal-title">Edit user</h5>
                        <h5 v-show="!edit_mode" class="modal-title">Add user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="edit_mode ? update_user() : create_user()">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <input v-model="form.user_name" type="text" name="name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('user_name') }">
                                        <has-error :form="form" field="user_name"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row" >
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Roles <span class="text-danger">*</span></label>
                                        <select class="form-control" :class="{ 'is-invalid': form.errors.has('role_id') }"  v-model="form.role_id" >
                                            <option selected value=""></option>
                                            <option  v-for="(role, id) in roles" :key="id" :value="id">
                                                {{ role }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="role_id"></has-error>

                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="edit_mode">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Roles <span class="text-danger">*</span></label>
                                        <select class="form-control" :class="{ 'is-invalid': form.errors.has('status') }"  v-model="form.status" >
                                            <option selected value=""></option>
                                            <option value="0">Not Active</option>
                                            <option value="1">Active</option>
                                        </select>
                                        <has-error :form="form" field="status"></has-error>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Password <span class="text-danger">*</span></label>
                                        <input v-model="form.password" type="password" name="password"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                        <has-error :form="form" field="password"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <input v-model="form.confirm_password" type="password" name="confirm_password"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('confirm_password') }">
                                        <has-error :form="form" field="confirm_password"></has-error>
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
        <!-- /Edit user Modal -->

    </div>
</template>

<script>
    export default {
        props:['locale'],
        data() {
            return {
                edit_mode: false,
                users: {},
                search_input: '',
                roles: {},

                form: new form({
                    id: '',
                    user_name: '',
                    password: '',
                    confirm_password: '',
                    role_id: '',
                    status: ''
                })
            }
        },
        methods: {

            get_roles() 
            {
                axios.get('api/get_roles').then((res)=>{
                this.roles= res.data
                //  console.log(res.data)
                }).catch((err) => {
                console.log(err)
                });
            },
            //Search methds
            search_it() {
                let query = this.search_input;
                axios.get('api/search_users?q=' + query)
                .then((data) => {
                    this.users = data.data
                })
                .catch()

            },
            //pagination
            getResults(page = 1) {

                axios.get('api/get_user/?page=' + page)
                    .then(response => {
                        this.$Progress.start();

                        this.users = response.data;

                        this.$Progress.finish();

                    });
            },
            // this method we open a modal for both edit and adding new user
            new_modal() {
                this.edit_mode = false;
                this.form.reset();
                $('#add_user').modal('show');
            },

            generate_one_employee_modal() {
                this.form.reset();
                $('#generate_one_employee_modal').modal('show');
            },

            edit_modal(user) {
                this.edit_mode = true;
                this.form.reset();
                $('#add_user').modal('show');
                this.form.fill(user);
            },

            //this method goes to user.store and store user data
            create_user() {
                this.form.post('api/system_users')
                .then(()=>{
                    $('#add_user').modal('hide');

                    this.$Progress.start();

                    
                    if(this.locale == "en")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'user created successfully'
                        });
                    }
                    else if(this.locale == "fa")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'معاش موفقانه درج سیستم گردید '
                        });

                    }
                    
                    Fire.$emit('AfterEvent');

                    this.$Progress.finish();
                })
                .catch(()=>{

                });
                
            },

            // update users
            update_user() 
            {
                this.form.put('api/system_users/'+this.form.id)
                .then(()=>{

                    $('#add_user').modal('hide');

                    this.$Progress.start();

                    Fire.$emit('AfterEvent');

                    if(this.locale == "en")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'user Updated successfully'
                        });
                    }
                    else if(this.locale == "fa")
                    {
                        toast.fire({
                        icon: 'success',
                        title: 'معاش کارمند موفقانه بروز رسانی شد'
                        });
                    }
                    

                    this.$Progress.finish();
                })
                .catch(()=>{

                });
            },
            // this function goes to user.index and returns data and then we save it into users object
            load_users() {
                axios.get('api/get_users').then(({data}) => (this.users = data));
            },

            delete_user(id) {
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

                        this.form.delete('api/system_users/'+id).then(()=>{
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
        },
        created() {
            this.load_users();

            this.get_roles();


            Fire.$on('AfterEvent',() => {
                this.load_users();
            });
        }
    }
</script>
