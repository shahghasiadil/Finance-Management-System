<?php

namespace App\Http\Controllers;

use App\BudgetCatCode;
use App\ExpenseCode;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function get_expensecode()
    {

        return ExpenseCode::with('budgetCatCode')->latest()->paginate(10);
    }
    public function search_expensecode()
    {
        if ($search = request()->get('q')) {
            return  ExpenseCode::with('budgetCatCode')->whereHas('budgetCatCode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })
                ->Orwhere('name', 'LIKE', "%$search%")
                ->orWhere('code', 'LIKE', "%$search%")
                ->orWhere('type', 'LIKE', "%$search%")

                ->paginate(10);
        } else {
            return ExpenseCode::with('budgetCatCode')->latest()->paginate(10);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|string',
            'code' => 'required',
            'type' => 'required|string',
            'description' => 'required|max:255',
            'budget_cat_code_id' => 'required'
        ]);

        ExpenseCode::create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'description' => $request->description,
            'budget_cat_code_id' => $request->budget_cat_code_id
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
        $expensecodes = ExpenseCode::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
            'code' => 'required',
            'type' => 'required|string',
            'description' => 'required|max:255',
            'budget_cat_code_id' => 'required'
        ]);

        $input = $request->all();

        $expensecodes->update($input);
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
        $expensecodes = ExpenseCode::findOrFail($id);
        $expensecodes->delete();
    }

    public function budgetcatcodes()
    {
        $collection = BudgetCatCode::get(['code', 'id', 'name']);
        foreach ($collection as $item) {
            $budgetcatcode[$item->id]  = $item->code;
        }
        return response()->json($budgetcatcode, 200);
    }
}
