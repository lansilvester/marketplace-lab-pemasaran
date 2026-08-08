<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class AdminAccUserComponent extends Component
{
    public $user_id;
    public $name;
    public $email;
    public $utype;
    public $status;
    public function mount($user_id){
        abort_unless(in_array(auth()->user()->utype, ['ADM','OPT']), 403);
        $user = User::where('id',$user_id)->first();
        abort_unless($user, 404);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->utype = $user->utype;
        $this->status = $user->status;
    }

    public function updated($fields){
        $this->validateOnly($fields, [
            'name'  => 'required',
            'email' => 'required',
            'utype' => 'required',
            'status' => 'required'
        ]);
    }

    public function updateUser(){
        $this->validate([
            'name'  => 'required',
            'email' => 'required',
            'utype' => 'required',
            'status' => 'required'
        ]);
        abort_unless(in_array(auth()->user()->utype, ['ADM','OPT']), 403);
        $user = User::find($this->user_id);
        abort_unless($user, 404);
        $user->name = $this->name;
        $user->email = $this->email;
        if (auth()->user()->utype === 'ADM') {
            $user->utype = $this->utype;
        }
        $user->status = $this->status;
        $user->save();
        session()->flash('message', 'User telah diupdate');
        return redirect('admin/users');
    }
    public function render()
    {
        return view('livewire.admin.admin-acc-user-component')->layout('layouts.base');
    }
}
