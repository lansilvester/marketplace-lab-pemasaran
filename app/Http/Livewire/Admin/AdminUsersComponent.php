<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Support\Cart;
use Illuminate\Support\Facades\Redirect;

class AdminUsersComponent extends Component
{
    use WithPagination;
    public function deleteUser($id){
        $user = User::findOrFail($id);
        $image = $user->profile->image;
        if($image && $image !== 'default.jpg'){
            Storage::delete('profile/'. $image);
        }
        $user->delete();
        session()->flash('message', 'User has been deleted');
    }
    public function mount()
    {
        if (Auth::user()->utype !== 'ADM') {
            return Redirect::to('/');
        }
    }
    public function render()
    {
        $userProfile = Profile::where('user_id', Auth::user()->id)->first();
        if(!$userProfile){
            $profile = new Profile();
            $profile->user_id = Auth::user()->id;
            $profile->image = "default.jpg";
            $profile->save();
        }

        $users = User::paginate(10);
        $users_unapprove = User::where('status', false)->get();
        return view('livewire.admin.admin-users-component',[
            'users'=> $users,
            'user'=> $userProfile,
            'users_unapprove'=>$users_unapprove,
        ])->layout('layouts.base');
    }
}
