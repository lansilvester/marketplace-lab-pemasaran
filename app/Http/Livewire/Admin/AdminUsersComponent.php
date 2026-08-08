<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AdminUsersComponent extends Component
{
    use WithPagination;
    public function deleteUser($id){
        $user = User::findOrFail($id);
        if ($id === Auth::id() || in_array($user->utype, ['ADM'])) {
            session()->flash('error_message', 'Akun admin tidak dapat dihapus.');
            return;
        }
        if ($user->profile && $user->profile->image && $user->profile->image !== 'default.jpg') {
            $path = public_path('assets/images/profile/'. $user->profile->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $user->delete();
        session()->flash('message', 'User has been deleted');
    }

    public function activateUser($id){
        $user = User::findOrFail($id);
        $user->status = true;
        $user->save();
        session()->flash('message', 'Akun '.$user->name.' telah diaktifkan');
    }

    public function deactivateUser($id){
        $user = User::findOrFail($id);
        $user->status = false;
        $user->save();
        session()->flash('message', 'Akun '.$user->name.' telah dinonaktifkan');
    }

    public function mount()
    {
        abort_unless(in_array(Auth::user()->utype, ['ADM','OPT']), 403);
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
