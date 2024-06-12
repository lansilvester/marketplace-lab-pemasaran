<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\HomeSlider;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;

class AdminAddHomeSliderComponent extends Component
{
    use WithFileUploads;
    public $title;
    public $subtitle;
    public $link;
    public $image;
    public $status;

    public function mount(){
        $this->status = 0;
    }
    public function addSlide(){
        $slider = new HomeSlider();
         $slider->title = $this->title;
         $slider->subtitle = $this->subtitle;
         $slider->link = $this->link;
         $imagename = Carbon::now()->timestamp. '.'. $this->image->extension();
         $this->image->storeAs('sliders', $imagename);
         $slider->image = $imagename;
         $slider->status = $this->status;
        $slider->save();
        session()->flash('message', 'Slide has been created!');

    }

    public function render()
    {
        return view('livewire.admin.admin-add-home-slider-component')->layout('layouts.base');
    }
}
