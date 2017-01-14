<?php

namespace App\Http\Controllers;

use App\Entities\Department;
use App\Repositories\Contracts\DepartmentRepository;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    private $repository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->repository = $departmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = $this->repository->getAll();

        \JavaScript::put(['departments' => $departments]);

        return view('departments.show', compact('departments'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $data['user_id'] = \Auth::user()->getKey();

        $this->repository->store($data);

        return response(
            Department::all()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Department             $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $this->repository->update($department, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Department $department
     * @param  Request      $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department, Request $request)
    {
        $department->delete();

        return response(
            Department::all()
        );
    }
}
