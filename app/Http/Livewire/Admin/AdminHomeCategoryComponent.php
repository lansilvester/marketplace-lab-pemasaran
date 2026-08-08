<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\HomeCategory;

class AdminHomeCategoryComponent extends Component
{
    public $selected_categories = [];
    public $numberofproducts;

    public function mount(){
        $category = HomeCategory::find(1);
        $this->selected_categories = $category ? array_filter(explode(',', $category->sel_categories)) : [];
        $this->numberofproducts = $category ? $category->no_of_products : 0;
    }

    public function updateHomeCategory(){
        $this->validate([
            'selected_categories' => 'required|array|min:1',
            'numberofproducts' => 'required|numeric|min:1',
        ]);

        $category = HomeCategory::find(1);
        if (!$category) {
            $category = new HomeCategory();
            $category->id = 1;
        }
        $category->sel_categories = implode(',', $this->selected_categories);
        $category->no_of_products = $this->numberofproducts;
        $category->save();
        session()->flash('message', 'Home Category has been updated');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.admin-home-category-component',[
            'categories'=> $categories
        ])->layout('layouts.base');
    }
}
