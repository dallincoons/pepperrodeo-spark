<?php

namespace App\Http\Controllers;

use App\Entities\ItemCategory;
use App\Repositories\DepartmentRepository;
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
            ItemCategory::all()
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
     * @param  ItemCategory             $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemCategory $department)
    {
        $this->repository->update($department, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ItemCategory $department
     * @param  Request      $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemCategory $department, Request $request)
    {
        if($request->force == 'false' && $department->items->count()){
            return response(
                $request->force,
                290
            );
        }

        $success = $department->delete();

        if(!$success){
            abort('422');
        }

        return response(
            ItemCategory::all()
        );
    }
}
