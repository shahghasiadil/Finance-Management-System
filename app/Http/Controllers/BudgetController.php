<?php

namespace App\Http\Controllers;

use App\BudgetCatCode;
use App\BudgetCode;
use Illuminate\Http\Request;
use Psy\CodeCleaner\ReturnTypePass;

class BudgetController extends Controller
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
    public function get_budgetcode()
    {
        return BudgetCode::latest()->paginate(10);
    }

    public function search_budgetcode()
    {
        if ($search = request()->get('q')) {
            return BudgetCode::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('code', 'LIKE', "%$search%")
                    ->orWhere('type', 'LIKE', "%$search%");
            })->paginate(10);
        } else {
            return BudgetCode::latest()->paginate(10);
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

        BudgetCode::create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'description' => $request->description
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
        $budgetcode = BudgetCode::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
            'code' => 'required',
            'type' => 'required|string',
            'description' => 'required|max:255',
        ]);
        $input = $request->all();
        $budgetcode->update($input);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $budgetcode = BudgetCode::findOrFail($id);
        $budgetcode->delete();
    }
}
