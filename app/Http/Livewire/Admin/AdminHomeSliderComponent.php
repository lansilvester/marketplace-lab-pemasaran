<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\HomeSlider;

class AdminHomeSliderComponent extends Component
{

    public function deleteSlide($slide_id){
        $slider = HomeSlider::find($slide_id);
        abort_unless($slider, 404);
        if($slider->image && $slider->image !== 'slider-1.jpg'){
            $path = public_path('assets/images/sliders/'.$slider->image);
            if(file_exists($path)){
                unlink($path);
            }
        }
        $slider->delete();
        session()->flash('message', 'Slider has been deleted');
    }

    public function render()
    {
        $sliders = HomeSlider::all();
        return view('livewire.admin.admin-home-slider-component',[
            'sliders'=>$sliders
        ])->layout('layouts.base');
    }
}
