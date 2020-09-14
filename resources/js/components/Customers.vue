<template>
    <div>
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Customers</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customers</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_customer"><i class="fa fa-plus"></i> Add </a>
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
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Register Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="customer in customers" :key="customer.id">
                                <td>{{customer.id}}</td>
                                <td>{{customer.name}}</td>
                                <td>{{customer.phone}}</td>
                                <td>{{customer.address}}</td>
                                <td>{{customer.created_at | dates}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Edit Employee Modal -->
        <div id="add_customer" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Custmoer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="create_customer">
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
                                        <label class="col-form-label">Phone </label>
                                        <input v-model="form.phone" type="text" name="phone"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                                        <has-error :form="form" field="phone"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Address</label>
                                        <input v-model="form.address" type="text" name="address"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                                        <has-error :form="form" field="address"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Save</button>
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
        data() {
            return {
                customers: {},
                form: new form({
                    name:   '',
                    phone:  '',
                })
            }
        },
        methods: {
            //this method goes to customer.store and store customer data
            create_customer() {
                this.form.post('/customer')
                .then(()=>{
                    this.$Progress.start();
                    Fire.$emit('AfterCreate');
                    $('#add_customer').modal('hide');

                    toast.fire({
                        icon: 'success',
                        title: 'Customer created successfully'
                    });

                    this.$Progress.finish();
                })
                .catch(()=>{

                });
                
            },
            // this function goes to customer.index and returns data and then we save it into customers object
            load_customers() {
                axios.get('customer').then(({data}) => (this.customers = data.data));
            }
        },
        created() {
            this.load_customers();
            Fire.$on('AfterCreate',() => {
                this.load_customers();
            });
        }
    }
</script>
