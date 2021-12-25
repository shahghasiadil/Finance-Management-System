<?php

namespace App\Http\Controllers;

use App\Allocation;
use App\BudgetCatCode;
use App\BudgetCode;
use App\ExpenseCode;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllocationController extends Controller
{
    public function get_selected_expensecodes(Request $request)
    {
        $arr = explode(',', $request->id);
        return  DB::table('allocations')
            ->join('budget_expense_codes', 'allocations.expense_code_id', '=', 'budget_expense_codes.id')->whereIn('allocations.budget_cat_code_id', $arr)
            ->select('budget_expense_codes.id', 'budget_expense_codes.code')
            ->get();
    }
    public function get_selected_catcodes(Request $request)
    {
        $arr = explode(',', $request->id);
        // return $allocation = Allocation::with('budgetcode')->whereIn('budget_code_id', $arr)->whereHas('budgetcode', function ($query) {
        //     $query->select(['id', 'code']);
        // })->get(['budgetcode']);

        return DB::table('allocations')
            ->join('budget_cat_codes', 'allocations.budget_cat_code_id', '=', 'budget_cat_codes.id')->whereIn('allocations.budget_code_id', $arr)
            ->select('budget_cat_codes.id', 'budget_cat_codes.code')
            ->get();
        // return Allocation::whereIn('budget_cat_code_id', $arr)->with(['budgetcatcode' => function ($query) {
        //     return $query->select(['id', 'code']);
        // }])->get();
    }
    public function get_budgetcodes()
    {
        $collection = BudgetCode::get(['code', 'id']);
        foreach ($collection as $item) {
            $budgetcode[$item->id]  = $item->code;
        }
        return response()->json($budgetcode, 200);
    }
    public function budgetcatcodes()
    {
        $collection = BudgetCatCode::get(['code', 'id', 'name']);
        foreach ($collection as $item) {
            $budgetcatcode[$item->id]  = $item->code;
        }
        return response()->json($budgetcatcode, 200);
    }

    public function expensecode()
    {
        $collection = ExpenseCode::get(['code', 'id', 'name']);
        foreach ($collection as $item) {
            $expensecode[$item->id]  = $item->code;
        }
        return response()->json($expensecode, 200);
    }

    public function get_projects()
    {
        $collection = Project::get(['id', 'name']);
        foreach ($collection as $item) {
            $project[$item->id]  = $item->name;
        }
        return response()->json($project, 200);
    }
    public function get_allocations()
    {
        return Allocation::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->latest()->paginate(10);
    }

    public function get_proj_alloc(Request $request)
    {
        return Allocation::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->where('project_id', $request->id)->latest()->paginate(10);
    }

    /**
     * Show the form for creaon(ting a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allocated_budgetcode(Request $request)
    {
        $budgetcode = DB::table('allocations')
            ->join('budget_codes', 'allocations.budget_code_id', '=', 'budget_codes.id')->where('allocations.project_id', '=', $request->id)
            ->select('budget_codes.id', 'budget_codes.code')
            ->get();

        return response()->json($budgetcode, 200);
    }
    public function get_selected_allocation(Request $request)
    {
        $budgetcode = explode(',', $request->id);
        $budgetcatcode = explode(',', $request->cat_id);
        $expensecode = explode(',', $request->exp_id);

        if ($request->id !== null &&  $request->cat_id !== null  && $request->exp_id !== null && $request->project_id !== null) {
            return Allocation::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->where('project_id', $request->project_id)->whereIn('budget_code_id', $budgetcode)->whereIn('budget_cat_code_id', $budgetcatcode)->whereIn('expense_code_id', $expensecode)->latest()->paginate(10);
        } else if ($request->id !== null &&  $request->cat_id !== null  && $request->exp_id === null && $request->project_id !== null) {
            return Allocation::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->where('project_id', $request->project_id)->whereIn('budget_code_id', $budgetcode)->whereIn('budget_cat_code_id', $budgetcatcode)->latest()->paginate(10);
        } else if ($request->id !== null &&  $request->cat_id === null  && $request->exp_id === null && $request->project_id !== null) {
            return Allocation::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->where('project_id', $request->project_id)->whereIn('budget_code_id', $budgetcode)->latest()->paginate(10);
        } else if ($request->id === null &&  $request->cat_id === null  && $request->exp_id === null && $request->project_id !== null) {
            return Allocation::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->where('project_id', $request->project_id)->latest()->paginate(10);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'project_id' => 'required',
            'budget_code_id' => 'required',
            'budget_cat_code_id' => 'required',
            'expense_code_id' => 'required',
            'unit' => 'required',
            'number_of_activities' => 'required',
            'unit_cost' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        Allocation::create([
            'project_id' => $request->project_id,
            'budget_code_id' => $request->budget_code_id,
            'budget_cat_code_id' => $request->budget_cat_code_id,
            'expense_code_id' => $request->expense_code_id,
            'unit' => $request->unit,
            'number_of_activities' => $request->number_of_activities,
            'unit_cost' => $request->unit_cost,
            'quantity' => $request->quantity
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $allocations =  Allocation::findOrFail($id);
        $this->validate($request, [
            'project_id' => 'required',
            'budget_code_id' => 'required',
            'budget_cat_code_id' => 'required',
            'expense_code_id' => 'required',
            'unit' => 'required',
            'number_of_activities' => 'required',
            'unit_cost' => 'required|integer',
            'quantity' => 'required|integer',
        ]);
        $input = $request->all();
        $allocations->update($input);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $allocations =  Allocation::findOrFail($id);
        $allocations->delete();
    }

    public function search_allocation()
    {
        if ($search = request()->get('q')) {
            return  Allocation::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->whereHas('project', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })->orWhereHas('budgetcode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })->orWhereHas('budgetcatcode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })->orWhereHas('expensecode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })->orWhere('unit', 'LIKE', "%$search%")
                ->orWhere('unit_cost', 'LIKE', "%$search%")
                ->orWhere('unit_quantity', 'LIKE', "%$search%")
                ->paginate(10);
        } else {
            return Allocation::with('project', 'budgetcode', 'budgetcatcode', 'expensecode')->latest()->paginate(10);
        }
    }
}
