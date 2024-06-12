<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class AdminShowUserComponent extends Component
{
    public $user_id;
    public function mount($user_id){
        $user = User::where('id',$user_id)->first();
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->utype = $user->utype;
        $this->status = $user->status;
        $this->user_id = $user->id;
        $this->image = $user->profile->image;
        $this->facebook = $user->profile->facebook;
        $this->instagram = $user->profile->instagram;
        $this->mobile = $user->profile->mobile;
        $this->city = $user->profile->city;
        $this->province = $user->profile->province;
        $this->country = $user->profile->country;
        $this->zipcode = $user->profile->zipcode;
    }
    public function render()
    {
        return view('livewire.admin.admin-show-user-component')->layout('layouts.base');
    }
}
