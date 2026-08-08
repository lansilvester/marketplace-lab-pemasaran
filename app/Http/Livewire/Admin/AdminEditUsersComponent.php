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
        abort_unless(in_array(Auth::user()->utype, ['ADM','OPT']), 403);
        $user = User::where('id',$user_id)->first();
        abort_unless($user, 404);
        if(!$user->profile){
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->image = "default.jpg";
            $profile->save();
            $user->load('profile');
        }
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
            'mobile'=>'nullable|digits_between:9,15',
            'instagram' =>'nullable|max:255',
            'facebook'=>'nullable|max:255',
            'city'=>'nullable|max:255',
            'province'=>'nullable|max:255',
            'country'=>'nullable|max:255',
            'zipcode'=>'nullable|max:255',
            'newimage'=>'nullable|mimes:jpeg,jpg,png|max:2048'
        ]);
    }

    public function updateUser(){
        $this->validate([
            'name'  => 'required',
            'email' => 'required',
            'utype' => 'required',
            'status' => 'required',
            'mobile'=> 'nullable|digits_between:9,15',
            'instagram' =>'nullable|max:255',
            'facebook'=>'nullable|max:255',
            'city'=>'nullable|max:255',
            'province'=>'nullable|max:255',
            'country'=>'nullable|max:255',
            'zipcode'=>'nullable|max:255',
        ]);
        abort_unless(in_array(Auth::user()->utype, ['ADM','OPT']), 403);

        if($this->newimage){
            $this->validate([
                'newimage' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            ]);
        }

        $user = User::find($this->user_id);
        abort_unless($user, 404);

        $user->name = $this->name;
        $user->email = $this->email;
        if (Auth::user()->utype === 'ADM') {
            $user->utype = $this->utype;
        }
        $user->status = $this->status;
        $user->save();
        if($this->newimage){
            if($this->image && $this->image !== 'default.jpg'){
                $path = public_path('assets/images/profile/'.$this->image);
                if(file_exists($path)){
                    unlink($path);
                }
            }
            $imageName = $user->email.'_'.Carbon::now()->timestamp.uniqid().'.'.$this->newimage->extension();
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
