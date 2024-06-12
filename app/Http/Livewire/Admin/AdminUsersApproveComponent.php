<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class AdminUsersApproveComponent extends Component
{
    public $utype;
    public $status;

    public function mount($user_id){
        $user = User::where('id', $user_id)->first();
        $this->utype = $user->utype;
        $this->status = $user->status;
        $this->user_id = $user->id;

    }
    public function ApproveUser($user_id){   
        $user= User::find($this->user_id);
        $user->status = 1;

        $user->save();
        session()->flash('approve', 'User diterima');
    }
    public function render()
    {
        return view('livewire.admin.admin-users-approve-component')->layout('layouts.base');
    }
}
