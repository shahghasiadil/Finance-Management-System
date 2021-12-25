<template>
    <div class="row">
        <div class="col-sm-12">
            <form @submit.prevent="create_voucher()">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="table-responsive">
							<div>{{items}}</div>
                            <table class="table table-hover table-white">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">#</th>
                                        <th class="col-md-6">Project</th>
                                        <th style="width: 20px">Number</th>
                                        <th class="col-md-6">Location Code</th>
                                        <th class="col-md-6">BGT.Ctg.Code</th>
                                        <th class="col-md-6">Expense Code</th>
                                        <th class="col-md-6">Description</th>
                                        <th style="width:100px;">
                                            Transaction Type
                                        </th>
                                        <th>Date</th>
                                        <th style="width:100px;">Type</th>
                                        <th>Amount</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item, index) in items"
                                        :key="index"
                                    >
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <div class="form-group">
                                                <select
                                                    class="form-control "
                                                    name="project"
                                                    v-model="item.project_id"
                                                    id="project_id"
                                                    title="Select Project"
                                                    data-live-search="true"
                                                    @change="load_budgetcodes"
                                                >
                                                    <option
                                                        v-for="(project,
                                                        id) in projects"
                                                        :key="id"
                                                        :value="id"
                                                    >
                                                        {{ project }}
                                                    </option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input
                                                class="form-control"
                                                style="width:80px"
                                                type="text"
                                                v-model="item.number"
                                            />
                                        </td>

                                        <td>
                                            <div
                                                class="form-group"
                                                style="width:120px"
                                            >
                                                <!-- <label>budgetcode<span class="text-danger">*</span></label> -->
                                                <select
                                                    class="form-control"
                                                    v-model="
                                                        item.budget_code_id
                                                    "
                                                    name="budgetcode"
                                                    title="budgetcode"
                                                    data-live-search="true"
                                                    @change="
                                                        load_budgetcatcodes
                                                    "
                                                >
                                                    <option
                                                        v-for="(budgetcode,
                                                        id) in budgetcodes"
                                                        :key="id"
                                                        :value="id"
                                                    >
                                                        {{ budgetcode}}
                                                    </option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="form-group"
                                                style="width:120px"
                                            >
                                                <select
                                                    class="form-control "
                                                    v-model="
                                                        item.budget_cat_code_id
                                                    "
                                                    name="budgetcatcode"
                                                    title="budgetcatcode"
                                                    data-live-search="true"
                                                    @change="load_expensecodes"
                                                >
                                                    <option
                                                        v-for="(budgetcatcode,
                                                        id) in budgetcatcodes"
                                                        :key="id"
                                                        :value="id"
                                                    >
                                                        {{ budgetcatcode }}
                                                    </option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="form-group"
                                                style="width:120px"
                                            >
                                                <!-- <label>Expense Code<span class="text-danger">*</span></label> -->
                                                <select
                                                    class="form-control"
                                                    v-model="
                                                        item.expense_code_id
                                                    "
                                                    name="expensecode"
                                                    title="expensecode"
                                                    data-live-search="true"
                                                >
                                                    <option
                                                        v-for="(expensecode,
                                                        id) in expensecodes"
                                                        :key="id"
                                                        :value="id"
                                                    >
                                                        {{ expensecode }}
                                                    </option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input
                                                class="form-control"
                                                style="width:120px"
                                                type="text"
                                                v-model="item.description"
                                            />
                                        </td>
                                        <td>
                                            <div
                                                class="form-controll"
                                                style="width:110px"
                                            >
                                                <select
                                                    class="form-control select"
                                                    v-model="
                                                        item.type_of_transaction
                                                    "
                                                    name="expensecode"
                                                    title="expensecode"
                                                    data-live-search="false"
                                                >
                                                    <option value="credit"
                                                        >Credit</option
                                                    >
                                                    <option value="debit"
                                                        >Debit</option
                                                    >
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <!-- <label class="col-form-label">Date <span class="text-danger">*</span></label> -->
                                                <date-picker
                                                    display-format="MM"
                                                    format="YYYY-MM-DD"
                                                    locale="en"
                                                    v-model="item.date"
                                                ></date-picker>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="form-group"
                                                style="width:110px"
                                            >
                                                <select
                                                    class="form-control select"
                                                    v-model="item.type"
                                                    name="expensecode"
                                                    title="expensecode"
                                                    data-live-search="false"
                                                >
                                                    <option
                                                        value="Cash Payment Voucher"
                                                        >Cash Payment
                                                        Voucher</option
                                                    >
                                                    <option
                                                        value="Cash Receipt Voucher"
                                                        >Cash Receipt Voucher
                                                    </option>
                                                    <option
                                                        value="Bank Payment Voucher"
                                                        >Bank Payment Voucher
                                                    </option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <input
                                                class="form-control"
                                                style="width:80px"
                                                type="text"
                                                v-model="item.amount"
                                            />
                                        </td>
                                        <td>
                                            <a
                                                href="javascript:void(0)"
                                                class="text-success font-18"
                                                title="Add"
                                                @click="addRow"
                                                ><i class="fa fa-plus"></i
                                            ></a>
                                        </td>
                                        <td>
                                            <a
                                                href="javascript:void(0)"
                                                class="text-danger font-18"
                                                title="Remove"
                                                @click="removeRow(index)"
                                                ><i class="fa fa-trash-o"></i
                                            ></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-white">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">
                                            Tax
                                        </td>
                                        <td
                                            style="text-align: right; padding-right: 30px;width: 230px"
                                        >
                                            <input
                                                class="form-control text-right"
                                                value="0"
                                                readonly
                                                type="text"
                                            />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td
                                            colspan="5"
                                            style="text-align: right; font-weight: bold"
                                        >
                                            Grand Total
                                        </td>
                                        <td
                                            style="text-align: right; padding-right: 30px; font-weight: bold; font-size: 16px;width: 230px"
                                        >
                                            {{ decimalDigits(total) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn m-r-10">
                        Save & Send
                    </button>
                    <button class="btn btn-primary submit-btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            invoiceCurrency: {
                symbol: "AFN",
                name: "Afghani",
                symbol_native: "AFN",
                decimal_digits: 2,
                rounding: 0,
                code: "AFN",
                name_plural: "AFNS"
            },
            budgetcodes: {},
            budgetcatcodes: {},
            expensecodes: {},
            projects: {},
            project_id: "",
            items: [
                {
                    id: "",
                    number: "",
                    project_id: "",
					budgetcode_id:'',
                    budget_cat_code_id: "",
                    expense_code_id: "",
                    type: "",
                    description: "",
                    type_of_transaction: "",
                    date: "",
                    amount: ""
                }
            ]
        };
    },
    methods: {
        decimalDigits: function(value) {
            return (
                this.invoiceCurrency.symbol +
                " " +
                Number(value).toFixed(this.invoiceCurrency.decimal_digits)
            );
        },
        load_budgetcodes() {
            axios
                .get("budgetcodes")
                .then(({ data }) => (this.budgetcodes = data))
                .catch(err => console.log(err));
        },
        load_budgetcatcodes() {
            axios
                .get("budgetcatcodes")
                .then(({ data }) => (this.budgetcatcodes = data))
                .catch(err => console.log(err));
        },
        load_expensecodes() {
            axios
                .get("expensecodes")
                .then(({ data }) => (this.expensecodes = data))
                .catch(err => console.log(err));
        },
        load_projects() {
            axios
                .get("get_projects")
                .then(({ data }) => (this.projects = data))
                .catch(err => console.log(err));
        },
        addRow() {
            this.items.push({
                id: "",
                number: "",
                project_id: "",
                budget_cat_code_id: "",
				budgetcode_id:"",
                expense_code_id: "",
                type: "",
                description: "",
                type_of_transaction: "",
                date: "",
                amount: ""
            });
        },
        removeRow(index) {
            this.items.splice(index, 1);
        },
        create_voucher() {
            let json = JSON.stringify(this.items);
            let vouchers = { json_data: json };
            axios
                .post("/voucher", vouchers)
                .then(res => {
                    $("#add_project").modal("hide");

                    this.$Progress.start();

                    if (this.locale == "en") {
                        toast.fire({
                            icon: "success",
                            title: "Voucher created successfully"
                        });
                    } else if (this.locale == "fa") {
                        toast.fire({
                            icon: "success",
                            position: "top-left",
                            title: "پروژه موفقانه ثبت گردید "
                        });
                    }

                    Fire.$emit("AfterEvent");

                    this.$Progress.finish();
                    this.$router.push({ path: "/voucher" });
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    created() {
        this.load_projects();
    },
    computed: {
        total() {
            return this.items.reduce(
                (acc, item) => acc + Number(item.amount),
                0
            );
        }
    }
};
</script>
