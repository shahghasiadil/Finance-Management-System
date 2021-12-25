<?php

namespace App\Http\Controllers;

use App\BudgetCatCode;
use App\BudgetCode;
use Illuminate\Http\Request;

class BudgetCatController extends Controller
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
    public function get_budgetcatcode()
    {
        return BudgetCatCode::with('budgetcode')->latest()->paginate(10);
    }

    public function search_budgetcatcode()
    {
        if ($search = request()->get('q')) {
            return  BudgetCatCode::with('budgetcode')->whereHas('budgetcode', function ($query) use ($search) {
                $query->where('code', 'LIKE', "%$search%");
            })
                ->Orwhere('name', 'LIKE', "%$search%")
                ->orWhere('code', 'LIKE', "%$search%")
                ->orWhere('type', 'LIKE', "%$search%")

                ->paginate(10);
        } else {
            return BudgetCatCode::with('budgetcode')->latest()->paginate(10);
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
        ]);

        BudgetCatCode::create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'description' => $request->description,
            'budget_code_id' => $request->budget_code_id
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
        $budgetcatcodes = BudgetCatCode::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
            'code' => 'required',
            'type' => 'required|string',
            'description' => 'required|max:255',
        ]);

        $input = $request->all();
        $budgetcatcodes->update($input);
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
        $budgetcatcodes = BudgetCatCode::findOrFail($id);
        $budgetcatcodes->delete();
    }

    public function get_budgetcodes()
    {
        $collection = BudgetCode::get(['code', 'id', 'name']);
        foreach ($collection as $item) {
            $budgetcode[$item->id]  = $item->code;
        }
        return response()->json($budgetcode, 200);
    }
}
