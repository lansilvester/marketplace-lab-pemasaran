<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\HomeSlider;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;

class AdminEditHomeSliderComponent extends Component
{
    use WithFileUploads;
    public $title;
    public $subtitle;
    public $link;
    public $image;
    public $status;
    public $newimage;
    public $slider_id;

    public function mount($slide_id){
        $slider = HomeSlider::find($slide_id);
        abort_unless($slider, 404);
        $this->title = $slider->title;
        $this->subtitle = $slider->subtitle;
        $this->link = $slider->link;
        $this->image = $slider->image;
        $this->status = $slider->status;
        $this->slider_id = $slider->id;
    }

    public function updateSlide(){
        $this->validate([
            'title' => 'required',
            'status' => 'required',
            'newimage' => 'nullable|mimes:jpeg,jpg,png|max:2048',
        ]);

        $slider = HomeSlider::find($this->slider_id);
        abort_unless($slider, 404);
        $slider->title = $this->title;
        $slider->subtitle = $this->subtitle;
        $slider->link = $this->link;

        if($this->newimage){
            if($slider->image && $slider->image !== 'slider-1.jpg'){
                $path = public_path('assets/images/sliders/'.$slider->image);
                if(file_exists($path)){
                    unlink($path);
                }
            }
            $imagename = Carbon::now()->timestamp.uniqid().'.'.$this->newimage->extension();
            $this->newimage->storeAs('sliders', $imagename);
            $slider->image = $imagename;
        }

        $slider->status = $this->status;
        $slider->save();
        session()->flash('message', 'Slide has been updated');

    }

    public function render()
    {
        return view('livewire.admin.admin-edit-home-slider-component')->layout('layouts.base');
    }
}
