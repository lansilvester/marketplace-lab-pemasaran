<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAddUsersComponent extends Component
{
    public $name;
    public $email;
    public $password;
    public $utype = 'USR';
    public $status = 1;

    public function mount()
    {
        abort_unless(in_array(Auth::user()->utype, ['ADM','OPT']), 403);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'utype' => 'required|in:ADM,OPT,USR,PNJ,PBN',
            'status' => 'required|in:0,1',
        ]);
    }

    public function addUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'utype' => 'required|in:ADM,OPT,USR,PNJ,PBN',
            'status' => 'required|in:0,1',
        ]);

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);
        $user->utype = $this->utype;
        $user->status = (bool) $this->status;
        $user->save();

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->image = "default.jpg";
        $profile->save();

        session()->flash('message', 'User berhasil ditambahkan');
        return redirect()->route('admin.users');
    }

    public function render()
    {
        return view('livewire.admin.admin-add-users-component')->layout('layouts.base');
    }
}
