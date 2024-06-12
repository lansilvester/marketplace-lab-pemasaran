<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Review;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminReviewComponent extends Component
{   
  
    public $user_id;

    public function mount($user_id){
        $this->user_id = $user_id;
    }

    public function deleteReview($id){
        $review = Review::find($id);
       
        $review->delete();
        session()->flash('message', 'Review has been deleted');
    }
    public function render()
    {
        $all_reviews = DB::table('reviews')
                ->join('products','reviews.product_id','=','products.id')
                ->join('users','reviews.user_id','=','users.id')
                ->select('reviews.id as reviews_id',
                'reviews.rating as reviews_rating',
                'reviews.comment as reviews_comment',
                'products.name as products_name',
                'users.name as user_name',
                'reviews.created_at as reviews_created_at')
                ->where('products.user_id',Auth::user()->id)
                ->get();
        return view('livewire.admin.admin-review-component',[
            'all_reviews'=>$all_reviews
        ])->layout('layouts.base');
    }
}
