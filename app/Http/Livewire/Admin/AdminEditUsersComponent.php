<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminEditUsersComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $email;
    public $utype;
    public $status;
    public $image;
    public $user_id;
    public $mobile;
    public $instagram;
    public $facebook;
    public $city;
    public $province;
    public $country;
    public $zipcode;
    public $newimage;

    public function mount($user_id){
        $user = User::where('id',$user_id)->first();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->utype = $user->utype;
        $this->status = $user->status;
        $this->image = $user->profile->image;
        $this->mobile = $user->profile->mobile;
        $this->user_id = $user->id;
        $this->instagram = $user->profile->instagram;
        $this->facebook = $user->profile->facebook;
        $this->city = $user->profile->city;
        $this->province = $user->profile->province;
        $this->country = $user->profile->country;
        $this->zipcode = $user->profile->zipcode;
    }
    
    public function updated($fields){
        $this->validateOnly($fields, [
            'name'  => 'required',
            'email' => 'required',
            'utype' => 'required',
            'status' => 'required',
            'mobile'=>'max:255',
            'instagram' =>'max:255',
            'facebook'=>'max:255',
            'city'=>'max:255',
            'province'=>'max:255',
            'country'=>'max:255',
            'zipcode'=>'max:255',
            'image'=>'file|image'
        ]);
    }

    public function updateUser(){
        $this->validate([
            'name'  => 'required',
            'email' => 'required',
            'utype' => 'required',
            'status' => 'required',
            'mobile'=> 'numeric|max:255',
            'instagram' =>'max:255',
            'facebook'=>'max:255',
            'city'=>'max:255',
            'province'=>'max:255',
            'country'=>'max:255',
            'zipcode'=>'max:255',
        ]);

        $user = User::find($this->user_id);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->utype = $this->utype;
        $user->status = $this->status;
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
        session()->flash('message', 'User has been updated');

    }
    public function render()
    {
        return view('livewire.admin.admin-edit-users-component')->layout('layouts.base');
    }
}
