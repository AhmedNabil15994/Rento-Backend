<?php

namespace Modules\Category\Repositories\Api;

use Modules\Category\Entities\Category;

class CategoryRepository
{
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAllCategories($request)
    {
        $categories = $this->category->baseFilter($request)
                                    ->active()
                                    ->orderBy("sort", "asc")
                                    ->orderBy('id', 'DESC')
                                    ->get();
        return $categories;
    }

    public function getMainCategory()
    {
        return $this->category
                        ->mainCategories()
                        ->active()
                        ->with([
                            "children"=> function ($query) {
                                $query->active();
                            }
                        ])
                        ->get();
    }

    public function show($request, $id)
    {
        $categories = $this->category->baseFilter($request)
                                    ->active()
                                    ->find($id);
        return $categories;
    }

    public function listSubCategory($request, $id)
    {
        $categories = $this->category->baseFilter($request)
                                    ->active()
                                    ->where("parent_id", $id)->get();
        return $categories;
    }

    public function findById($id, $with=[])
    {
        return $this->category->active()->find($id);
    }

    public function tree()
    {
        return $this->category
                         ->active()
                         ->with([
                             "children"=> function ($query) {
                                 $query->active();
                             }
                         ])
                         ->get()->toTree();
        ;
    }
}
