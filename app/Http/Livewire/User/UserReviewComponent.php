<?php

namespace App\Http\Livewire\User;

use App\Models\Review;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserReviewComponent extends Component
{
    public $item_id;
    public $rating;
    public $comment;

    public function mount($item_id){
        $this->item_id = $item_id;
    }
    public function update($fields){
        $this->validateOnly($fields, [
            'rating'=>'required',
            'comment'=>'required'

        ]);
    }
    public function addReview(){
        $this->validate([
            'rating'=>'required',
            'comment'=>'required'
        ]);

        $review = new Review();
        $review->product_id = $this->item_id;
        $review->user_id = Auth::user()->id;
        $review->rating = $this->rating;
        $review->comment = $this->comment;
        $review->save();
        
        $productItem = Product::find($this->item_id);
       if( $productItem->rstatus == false){
        $productItem->rstatus = true;
       }
        $productItem->save();
        session()->flash('message','Review telah diberikan');
    }
    public function render()
    {
        $item = Product::find($this->item_id);
        return view('livewire.user.user-review-component',[
            'item'=>$item
        ])->layout('layouts.base');
    }
}
