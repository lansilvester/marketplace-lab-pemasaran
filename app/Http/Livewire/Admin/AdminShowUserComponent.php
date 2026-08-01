<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class AdminShowUserComponent extends Component
{
    public $user_id;
    public $id;
    public $name;
    public $email;
    public $utype;
    public $status;
    public $image;
    public $facebook;
    public $instagram;
    public $mobile;
    public $city;
    public $province;
    public $country;
    public $zipcode;

    public function mount($user_id){
        $user = User::where('id',$user_id)->first();
        $profile = $user->profile ?? null;
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->utype = $user->utype;
        $this->status = $user->status;
        $this->user_id = $user->id;
        $this->image = $profile->image ?? 'default.jpg';
        $this->facebook = $profile->facebook ?? null;
        $this->instagram = $profile->instagram ?? null;
        $this->mobile = $profile->mobile ?? null;
        $this->city = $profile->city ?? null;
        $this->province = $profile->province ?? null;
        $this->country = $profile->country ?? null;
        $this->zipcode = $profile->zipcode ?? null;
    }
    public function render()
    {
        return view('livewire.admin.admin-show-user-component')->layout('layouts.base');
    }
}
