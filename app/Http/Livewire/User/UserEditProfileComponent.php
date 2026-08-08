<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
    public $map;
    public $city;
    public $province;
    public $country;
    public $zipcode;
    public $newimage;
    public $latitude;
    public $longitude;
    public $latlong;

    public function mount(){
        $user = User::find(Auth::user()->id);
        if(!$user->profile){
            $profile = new \App\Models\Profile();
            $profile->user_id = $user->id;
            $profile->image = "default.jpg";
            $profile->save();
            $user->load('profile');
        }
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile = $user->profile->mobile;
        $this->image = $user->profile->image;
        $this->facebook = $user->profile->facebook;
        $this->instagram = $user->profile->instagram;
        $this->map = $user->profile->map;
        $this->city = $user->profile->city;
        $this->province = $user->profile->province;
        $this->country = $user->profile->country;
        $this->zipcode = $user->profile->zipcode;
        $this->latitude = $user->profile->latitude;
        $this->longitude = $user->profile->longitude;
        $this->latlong = ($this->latitude && $this->longitude) ? $this->latitude.', '.$this->longitude : '';
        // $this->newimage = $user->profile->newimage;

    }
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'newimage' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'latlong' => 'required',
        ], $this->messages());
    }
    public function deleteImage()
    {
        $user = Auth::user();
        if ($this->image && $this->image !== 'default.jpg') {
            $path = public_path('assets/images/profile/'.$this->image);
            if(file_exists($path)){
                unlink($path);
            }
            $this->image = null;
            $user->profile->image = null;
            $user->profile->save();
            session()->flash('message', 'Profile image has been deleted successfully.');
        }
    }

    protected function messages()
    {
        return [
            'newimage.mimes' => 'Foto profil harus berformat jpg, jpeg, atau png.',
            'newimage.max' => 'Ukuran foto profil maksimal 2MB.',
        ];
    }

    public function updateProfile(){
        $this->validate([
            'newimage' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'latlong' => 'required',
        ], $this->messages());

        // Split latlong into latitude and longitude
        $latlongArray = explode(',', $this->latlong);
        if (count($latlongArray) == 2) {
            $lat = trim($latlongArray[0]);
            $lng = trim($latlongArray[1]);
            if ($lat === '' && $lng === '') {
                session()->flash('error_message', 'Latitude dan Longitude wajib diisi.');
                return;
            }
            if (($lat !== '' && !is_numeric($lat)) || ($lng !== '' && !is_numeric($lng))) {
                session()->flash('error_message', 'Format Latitude dan Longitude tidak valid.');
                return;
            }
            $this->latitude = $lat !== '' ? $lat : null;
            $this->longitude = $lng !== '' ? $lng : null;
            $user = User::find(Auth::user()->id);
            $user->name = $this->name;
            $user->save();
            if($this->newimage){
                if($this->image && $this->image !== 'default.jpg'){
                    $path = public_path('assets/images/profile/'. $this->image);
                    if(file_exists($path)){
                        unlink($path);
                    }
                }
                $imageName = $user->email.'_'.Carbon::now()->timestamp. '.'.$this->newimage->extension();
                $this->newimage->storeAs('profile', $imageName);
                $user->profile->image = $imageName;
            }
            $user->profile->mobile = $this->mobile;
            $user->profile->facebook = $this->facebook;
            $user->profile->instagram = $this->instagram;
            $user->profile->map = $this->map;
            $user->profile->city = $this->city;
            $user->profile->province = $this->province;
            $user->profile->country = $this->country;
            $user->profile->zipcode = $this->zipcode;
            $user->profile->latitude = $this->latitude;
            $user->profile->longitude = $this->longitude;
            $user->profile->save();
            session()->flash('message','Profile telah diupdate');
        }else{
            session()->flash('error_message', 'Invalid Latitude and Longitude format.');
        }
    }
    public function render()
    {
        return view('livewire.user.user-edit-profile-component')->layout('layouts.base');
    }
}
