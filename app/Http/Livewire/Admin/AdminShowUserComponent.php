<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class AdminShowUserComponent extends Component
{
    public $user_id;
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
        abort_unless(in_array(auth()->user()->utype, ['ADM','OPT']), 403);
        $this->user_id = $user_id;
        $user = User::where('id',$user_id)->first();
        abort_unless($user, 404);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->utype = $user->utype;
        $this->status = $user->status;
        $this->image = optional($user->profile)->image ?? 'default.jpg';
        $this->facebook = optional($user->profile)->facebook ?? '';
        $this->instagram = optional($user->profile)->instagram ?? '';
        $this->mobile = optional($user->profile)->mobile ?? '';
        $this->city = optional($user->profile)->city ?? '';
        $this->province = optional($user->profile)->province ?? '';
        $this->country = optional($user->profile)->country ?? '';
        $this->zipcode = optional($user->profile)->zipcode ?? '';
    }
    public function render()
    {
        return view('livewire.admin.admin-show-user-component')->layout('layouts.base');
    }
}
