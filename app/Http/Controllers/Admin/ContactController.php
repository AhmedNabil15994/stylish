<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $rows = Contact::latest()->paginate(20);
        return view('admin.pages.contact.index',compact('rows'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back();
    }
}
