<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Redirect;

class AdminUsersComponent extends Component
{
    use WithPagination;
    public function deleteUser($id){
        $profile = User::findOrFail($id);
        if($profile->profile->image !== 'default.jpg'){
            unlink('assets/images/profile/'. $this->image);
        }
        $profile->delete();
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
