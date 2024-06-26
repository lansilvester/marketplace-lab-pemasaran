<?php

namespace App\Http\Livewire\Admin;

use App\Models\Contact;
use Livewire\Component;

class AdminContactComponent extends Component
{
    public function deleteMessage($id){
        $contact = Contact::find($id);
        $contact->delete();
        session()->flash('message', 'Message has been deleted');

    }
    public function render()
    {
        $contacts = Contact::paginate(10);
        return view('livewire.admin.admin-contact-component',[
            'contacts' => $contacts
        ])->layout('layouts.base');
    }
}
