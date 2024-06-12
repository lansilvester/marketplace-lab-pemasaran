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
        $user = User::where('id',$user_id)->first();
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
        $user = User::find($this->user_id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->utype = $this->utype;
        $user->status = $this->status;
        if($user->status == '1'){
            session()->flash('active','User sudah aktif!');
        }
        $user->save();
        return redirect('admin/users');
    }
    public function render()
    {
        return view('livewire.admin.admin-acc-user-component')->layout('layouts.base');
    }
}
