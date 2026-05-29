<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with(['category', 'assignedUser'])
            ->latest()
            ->paginate(10);

        return response()->json($contacts);
    }
}
