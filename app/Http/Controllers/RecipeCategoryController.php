<?php

namespace App\Http\Controllers;

use App\Entities\RecipeCategory;
use App\Repositories\Contracts\RecipeCategoryRepository;
use Illuminate\Http\Request;

class RecipeCategoryController extends Controller
{
    private $repository;

    public function __construct(RecipeCategoryRepository $recipeCategoryRepository)
    {
        $this->repository = $recipeCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->repository->getAll();

        \JavaScript::put(['recipe_categories' => $categories]);

        return view('recipe_categories.index');
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
        $data = $request->only(['name', 'user_id']);

        $data['user_id'] = \Auth::user()->getKey();

        $this->repository->store($data);

        return response(
            $this->repository->getAll()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  RecipeCategory $recipecategory
     * @return \Illuminate\Http\Response
     */
    public function show(RecipeCategory $recipecategory)
    {
        if(\Auth::user()->getKey() !== $recipecategory->user->getKey() ){
            return back();
        }

        $category = $recipecategory;

        return view('recipe_categories.show', compact('category'));
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
     * @param  RecipeCategory $recipecategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RecipeCategory $recipecategory)
    {
        $this->repository->update($recipecategory, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   RecipeCategory $recipecategory
     * @param   Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecipeCategory $recipecategory, Request $request)
    {
        $recipecategory->delete();

        return response(
            $this->repository->getAll()
        );
    }
}
