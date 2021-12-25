<template>
    <div>
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">
                        {{ "Vouchers" | translateIn(this.locale) }}
                    </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">{{
                                "dashboard" | translateIn(this.locale)
                            }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ "Vouchers" | translateIn(this.locale) }}
                        </li>
                    </ul>
                </div>

                <div class="col-auto float-right ml-auto">
                    <router-link class="btn btn-add" to="createvoucher"
                        ><i class="fa fa-plus"></i>
                        {{ "Add" | translateIn(this.locale) }}</router-link
                    >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-auto float-right ml-auto mb-3">
                <input
                    type="text"
                    :placeholder="'search' | translateIn(this.locale)"
                    v-model="search_input"
                    @keyup="search_it"
                    class="form-control"
                    name=""
                    id=""
                />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table
                        class="table table-striped custom-table"
                        id="receipt_transactions"
                    >
                        <thead>
                            <tr>
                                <th>{{ "id" | translateIn(this.locale) }}</th>
                               
                                <th>
                                    {{ "number" | translateIn(this.locale) }}
                                </th>
                                <th>
                                    {{
                                        "project code"
                                            | translateIn(this.locale)
                                    }}
                                </th>
                                <th>
                                    {{
                                        "location code"
                                            | translateIn(this.locale)
                                    }}
                                </th>
                                <th>
                                    {{
                                        "budget category code"
                                            | translateIn(this.locale)
                                    }}
                                </th>
                                <th>
                                    {{
                                        "expense code"
                                            | translateIn(this.locale)
                                    }}
                                </th>
                                <th>
                                    {{
                                        "description" | translateIn(this.locale)
                                    }}
                                </th>
                                <th>{{ "type" | translateIn(this.locale) }}</th>
                                <th>
                                    {{
                                        "type of transaction"
                                            | translateIn(this.locale)
                                    }}
                                </th>
                                <th>{{ "amount" | translateIn(this.locale)}}</th>
                                <th>{{ "date" | translateIn(this.locale)}}</th>
                                <th>
                                    {{ "action" | translateIn(this.locale) }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="voucher in vouchers.data"
                                :key="voucher.id"
                            >
                                <td>{{ voucher.id }}</td>
                               
                                <td>{{ voucher.number }}</td>
                                <td>{{ voucher.project.code }}</td>
                                <td>{{ voucher.budgetcode.code }}</td>
                                <td>{{ voucher.budgetcatcode.code }}</td>
                                <td>{{ voucher.expensecode.code }}</td>
                                <td>{{ voucher.description }}</td>
                                <td>{{ voucher.type }}</td>
                                <td>{{ voucher.type_of_transaction }}</td>
                                <td>{{ voucher.amount}}</td>
                                <td>{{ voucher.date}}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a
                                            href="#"
                                            class="action-icon dropdown-toggle"
                                            data-toggle="dropdown"
                                            aria-expanded="false"
                                            ><i class="material-icons"
                                                >more_vert</i
                                            ></a
                                        >
                                        <div
                                            class="dropdown-menu dropdown-menu-right"
                                        >
                                            <a
                                                class="dropdown-item"
                                                href="#"
                                                @click="edit_modal(voucher)"
                                                ><i
                                                    class="fa fa-pencil m-r-5"
                                                ></i>
                                                Edit</a
                                            >
                                            <a
                                                class="dropdown-item"
                                                href="#"
                                                @click="
                                                    delete_voucher(voucher.id)
                                                "
                                                ><i
                                                    class="fa fa-trash m-r-5"
                                                ></i>
                                                Delete</a
                                            >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination
                        :data="vouchers"
                        @pagination-change-page="getResults"
                    >
                        <span slot="prev-nav"
                            >&lt;
                            {{ "previous" | translateIn(this.locale) }}</span
                        >
                        <span slot="next-nav">
                            {{ "next" | translateIn(this.locale) }} &gt;</span
                        >
                    </pagination>
                </div>
            </div>
        </div>
        <!-- Edit Employee Modal -->

        <!-- /Edit Employee Modal -->
    </div>
</template>

<script>
export default {
    props: ["locale"],
    data() {
        return {
            edit_mode: false,
            projects: {},
            budgetcatcodes: {},
            expensecodes: {},
            vouchers: {},
            search_input: "",

            form: new form({
                id: "",
                number: "",
                project_id: "",
                budget_cat_code_id: "",
                expense_code_id: "",
                description: "",
                type: "",
                type_of_transaction: "",
                date: ""
            }),
            items: [
                { location_code: "", description: "", credit: "", debit: "" }
            ]
        };
    },
    methods: {
        //Search methds

        search_it() {
            let query = this.search_input;
            axios
                .get("search_voucher?q=" + query)
                .then(data => {
                    this.vouchers = data.data;
                })
                .catch(e => console.log("404"));
        },
        //pagination
        getResults(page = 1) {
            axios.get("get_voucher/?page=" + page).then(response => {
                this.$Progress.start();

                this.vouchers = response.data;

                this.$Progress.finish();
            });
        },
        // this method we open a modal for both edit and adding new customer

        edit_modal(voucher) {
            this.edit_mode = true;
            this.form.reset();
            $("#add_project").modal("show");
            this.form.fill(voucher);
        },
        delete_voucher(id) {
            if (this.locale == "en") {
                swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    if (result.isConfirmed) {
                        this.form
                            .delete("voucher/" + id)
                            .then(() => {
                                swal.fire(
                                    "Deleted!",
                                    "Your file has been deleted.",
                                    "success"
                                );
                                Fire.$emit("AfterEvent");
                            })
                            .catch(() => {
                                swal.fire(
                                    "Failed!",
                                    "There was something wrong.",
                                    "warning"
                                );
                            });
                    }
                });
            } else if (this.locale == "fa") {
                swal.fire({
                    title: "مطمین استید ؟",
                    text: "شما قادر به برگشتاندن نخواهید بود",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "بلی، حذفش کن !"
                }).then(result => {
                    if (result.isConfirmed) {
                        this.form
                            .delete("voucher/" + id)
                            .then(() => {
                                swal.fire(
                                    "حذف شد !",
                                    "فایل مورد نظر شما حذف گردید .",
                                    "success"
                                );
                                Fire.$emit("AfterEvent");
                            })
                            .catch(() => {
                                swal.fire(
                                    "!ناکام شد",
                                    "مشکل وجود دارد",
                                    "warning"
                                );
                            });
                    }
                });
            }
        },
        load_vouchers(){
            axios.get('get_voucher').then(({data}) => this.vouchers = data)
        }
    },
    created() {
            this.load_vouchers();
       
        Fire.$on("AfterEvent", () => {
            this.load_vouchers();
        });
    }
};
</script>
