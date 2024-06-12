<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
class UserEditProfileComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $mobile;
    public $image;
    public $facebook;
    public $instagram;
    public $city;
    public $province;
    public $country;
    public $zipcode;
    public $newimage;

    public function mount(){
        $user = User::find(Auth::user()->id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile = $user->profile->mobile;
        $this->image = $user->profile->image;
        $this->facebook = $user->profile->facebook;
        $this->instagram = $user->profile->instagram;
        $this->city = $user->profile->city;
        $this->province = $user->profile->province;
        $this->country = $user->profile->country;
        $this->zipcode = $user->profile->zipcode;
        // $this->newimage = $user->profile->newimage;
    }
    public function updateProfile(){
        $user = User::find(Auth::user()->id);
        $user->name = $this->name;
        $user->save();
        if($this->newimage){
            if($this->image){
                if($this->image !== 'default.jpg'){
                    unlink('assets/images/profile/'. $this->image);
                }
            }
            $imageName = $user->email.'_'.Carbon::now()->timestamp. '.'.$this->newimage->extension();
            $this->newimage->storeAs('profile', $imageName);
            $user->profile->image = $imageName;
        }
        $user->profile->mobile = $this->mobile;
        $user->profile->facebook = $this->facebook;
        $user->profile->instagram = $this->instagram;
        $user->profile->city = $this->city;
        $user->profile->province = $this->province;
        $user->profile->country = $this->country;
        $user->profile->zipcode = $this->zipcode;
        $user->profile->save();
        session()->flash('message','Profile telah diupdate');
    }
    public function render()
    {
        return view('livewire.user.user-edit-profile-component')->layout('layouts.base');
    }
}
