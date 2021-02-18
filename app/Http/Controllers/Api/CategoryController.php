<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends BaseController
{

    public $rules = [
        'name' => 'required|max:255',
        'description' => 'nullable',
        'is_active' => 'boolean'
    ];

    public function index()
    {
        $collection = parent::index();
        return CategoryResource::collection($collection);
    }

    public function show($id)
    {
        $obj = parent::show($id);
        return new CategoryResource($obj);
    }

    protected function model()
    {
        return Category::class;
    }

    protected function rulesStore()
    {
        return $this->rules;
    }

    protected function rulesUpdate()
    {
        return $this->rules;
    }
}
