<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminAddUsersComponent extends Component
{
    public function render()
    {
        
        $userProfile = Profile::where('user_id', Auth::user()->id)->first();
        if(!$userProfile){
            $profile = new Profile();
            $profile->user_id = Auth::user()->id;
            $profile->save();
        }

        $user = User::where('id', Auth::user()->id)->get();

        return view('livewire.admin.admin-add-users-component', [
            'user'=>$user
        ])->layout('layouts.base');
    }
}
