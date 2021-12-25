<?php

namespace App\Http\Controllers;

use App\Allocation;
use App\BudgetCatCode;
use App\BudgetCode;
use App\ExpenseCode;
use App\Journal;
use App\Voucher;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function get_journal()
    {
        return Journal::with('voucher', 'budgetcode', 'budgetcatcode', 'expensecode')->latest()->paginate(10);
    }

    public function search_journal()
    {
        if ($search = request()->get('q')) {
            return Journal::with('voucher', 'budgetcode', 'budgetcatcode', 'expensecode')->whereHas('voucher', function ($query) use ($search) {
                $query->where('number', 'Like', "%$search%");
            })->orWhereHas('budgetcode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })->orWhereHas('budgetcatcode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })->orWhereHas('expensecode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })->orWhere('location', 'LIKE', "%$search%")
                ->orWhere('remarks', 'LIKE', "%$search%")
                ->orWhere('total_expense', 'LIKE', "%$search%")->paginate(10);
        } else {
            return Journal::with('voucher', 'budgetcode', 'budgetcatcode', 'expensecode')->latest()->paginate(10);
        }
    }
    public function store(Request $request)
    {

        $this->validate($request, [
            'date' => 'required|date',
            'location' => 'required',
            'voucher_id' => 'required',
            'budget_code_id' => 'required',
            'budget_cat_code_id' => 'required',
            'expense_code_id' => 'required',
            'remarks' => 'required',
            'total_expense' => 'required|max:255'
        ]);

        if (gettype($request->total_expense == "integer")) {

            Allocation::where('budget_code_id', $request->budget_code_id)->where('budget_cat_code_id', $request->budget_cat_code_id)->where('expense_code_id', $request->expense_code_id)->decrement('unit_cost', $request->total_expense);
        }
        Journal::create([
            'date' => $request->date,
            'location' => $request->location,
            'voucher_id' => $request->voucher_id,
            'budget_code_id' => $request->budget_code_id,
            'budget_cat_code_id' => $request->budget_cat_code_id,
            'expense_code_id' => $request->expense_code_id,
            'remarks' => $request->remarks,
            'total_expense' => $request->total_expense
        ]);
    }


    public function get_vouchers()
    {
        $collection = Voucher::get(['id', 'number']);
        foreach ($collection as $item) {
            $voucher[$item->id]  = $item->number;
        }
        return response()->json($voucher, 200);
    }
    public function get_budget_codes()
    {
        $collection = BudgetCode::get(['id', 'code']);
        foreach ($collection as $item) {
            $budgetcode[$item->id]  = $item->code;
        }
        return response()->json($budgetcode, 200);
    }
    public function get_budget_cat_codes()
    {
        $collection = BudgetCatCode::get(['id', 'code']);
        foreach ($collection as $item) {
            $budgetcatcode[$item->id]  = $item->code;
        }
        return response()->json($budgetcatcode, 200);
    }
    public function get_expense_codes()
    {
        $collection = ExpenseCode::get(['id', 'code']);
        foreach ($collection as $item) {
            $expensecode[$item->id]  = $item->code;
        }
        return response()->json($expensecode, 200);
    }
    public function index()
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $journals = Journal::findOrFail($id);
        $this->validate($request, [
            'date' => 'required|date',
            'location' => 'required',
            'voucher_id' => 'required',
            'budget_code_id' => 'required',
            'budget_cat_code_id' => 'required',
            'expense_code_id' => 'required',
            'remarks' => 'required',
            'total_expense' => 'required|max:255'
        ]);
        $input = $request->all();
        $journals->update($input);
    }

    public function destroy($id)
    {
        $journals = Journal::findOrFail($id);
        $journals->delete();
    }
}
