<?php

namespace App\Http\Controllers;

use App\Allocation;
use App\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{

    public function get_voucher()
    {
        return Voucher::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->latest()->paginate(10);
    }

    public function search_voucher()
    {
        if ($search = request()->get('q')) {
            return Voucher::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->whereHas('project', function ($query) use ($search) {
                $query->where('name', 'Like', "%$search%");
            })->orWhereHas('budgetcode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })->orWhereHas('budgetcatcode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })->orWhereHas('expensecode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })->orWhere('amount', 'LIKE', "%$search%")
                ->orWhere('date', 'LIKE', "%$search%")
                ->orWhere('type', 'LIKE', "%$search%")
                ->orWhere('type_of_transaction', 'LIKE', "%$search%")
                ->orWhere('number', 'LIKE', "%$search%")->paginate(10);
        } else {
            return Voucher::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->latest()->paginate(10);
        }
    }
    public function store(Request $request)
    {
        $array = json_decode($request->json_data);
        if (is_array($array) || is_object($array)) {
            foreach ($array as $voucher) {
                // $this->validate($voucher, [
                //     'number' => 'required|integer',
                //     'date' => 'required|date',
                //     'type' => 'required|string',
                //     'description' => 'required',
                //     'type_of_transaction' => 'required',
                //     'project_id' => 'required',
                //     'budget_code_id' => 'required',
                //     'budget_cat_code_id' => 'required',
                //     'expense_code_id' => 'required',
                //     'amount' => 'required|integer',
                // ]);
                if ($voucher->type == "credit") {
                    Allocation::where('budget_code_id', $voucher->budget_code_id)->where('budget_cat_code_id', $voucher->budget_cat_code_id)->where('expense_code_id', $voucher->expense_code_id)->decrement('unit_cost', $voucher->amount);
                } else {
                    Allocation::where('budget_code_id', $voucher->budget_code_id)->where('budget_cat_code_id', $voucher->budget_cat_code_id)->where('expense_code_id', $voucher->expense_code_id)->increment('unit_cost', $voucher->amount);
                }
                $vouchers =  new Voucher();
                $vouchers->number = $voucher->number;
                $vouchers->date = $voucher->date;
                $vouchers->type = $voucher->type;
                $vouchers->description = $voucher->description;
                $vouchers->type_of_transaction = $voucher->type_of_transaction;
                $vouchers->project_id = $voucher->project_id;
                $vouchers->budget_code_id = $voucher->budget_code_id;
                $vouchers->budget_cat_code_id = $voucher->budget_cat_code_id;
                $vouchers->expense_code_id = $voucher->expense_code_id;
                $vouchers->amount = $voucher->amount;
                $vouchers->save();
            }
        }

        // $this->validate($request, [

        // ]);
        // Voucher::create([
        //     'number' => $request->number,
        //     'date' => $request->date,

        //     'type' => $request->type,
        //     'description' => $request->description,
        //     'type_of_transaction' => $request->description,
        //     'project_id' => $request->project_id,
        //     'budget_code_id' => $request->budget_code_id,
        //     'budget_cat_code_id' => $request->budget_cat_code_id,
        //     'expense_code_id' => $request->expense_code_id
        // ]);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $this->validate($request, [
            'number' => 'required|integer',
            'date' => 'required|date',

            'type' => 'required|string',
            'description' => 'required',
            'type_of_transaction',
            'project_id' => 'required',
            'budget_code_id' => 'required',
            'budget_cat_code_id' => 'required',
            'expense_code_id' => 'required',
        ]);

        $input = $request->all();

        $voucher->update($input);
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();
    }
}
