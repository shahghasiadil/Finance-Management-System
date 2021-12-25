<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_project()
    {
        return Project::latest()->paginate(10);
    }
    public function search_project()
    {
        if ($search = request()->get('q')) {
            return Project::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('code', 'LIKE', "%$search%")
                    ->orWhere('location', 'LIKE', "%$search%")
                    ->orWhere('donor', 'LIKE', "%$search%")
                    ->orWhere('status', 'LIKE', "%$search%");
            })->paginate(10);
        } else {
            return Project::latest()->paginate(10);
        }
    }
    public function index()
    {
        //
        return view('admin.Projects');
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
            'name' => 'required|string|max:255',
            'code' => 'required',
            'donor' => 'required|string',
            'location' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',
            'number_of_months' => 'required',
            'total_budget' => 'required',
            'status' => 'required'
        ]);

        Project::create([
            'name' => $request->name,
            'code' => $request->code,
            'donor' => $request->donor,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'number_of_months' => $request->number_of_months,
            'total_budget' => $request->total_budget,
            'status' => $request->status
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
        $project = Project::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'code' => 'required',
            'donor' => 'required|string',
            'location' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',
            'number_of_months' => 'required',
            'total_budget' => 'required',
            'status' => 'required'
        ]);
        $input = $request->all();
        $project->update($input);
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
        $project = Project::findOrFail($id);
        $project->delete();
    }
}
