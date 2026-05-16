<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDocumentController extends Controller
{

    public function create()
    {
        $user = Auth::user();

        $documents = $user->documents()
            ->where('status', '!=', 'replaced')
            ->latest()
            ->get()
            ->unique('document_type')
            ->keyBy('document_type');

        $hasApprovedDriverLicense = $user->hasApprovedDriverLicense();
        $hasApprovedIdentityDocument = $user->hasApprovedIdentityDocument();
        $isKycApproved = $user->isKycApproved();

        return view('customer.documents.upload', compact(
            'documents',
            'hasApprovedDriverLicense',
            'hasApprovedIdentityDocument',
            'isKycApproved'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'document_type' => 'required|string'
        ]);

        $user = auth()->user();

        // verificăm dacă există deja document de acest tip
        $existingDocument = CustomerDocument::where('user_id', $user->id)
            ->where('document_type', $request->document_type)
            ->where('status', '!=', 'replaced')
            ->exists();

        // marcăm documentele vechi ca replaced
        CustomerDocument::where('user_id', $user->id)
            ->where('document_type', $request->document_type)
            ->where('status', '!=', 'replaced')
            ->update([
                'status' => 'replaced'
            ]);

        // upload document nou
        $path = $request->file('document')->store('documents', 'public');

        CustomerDocument::create([
            'user_id' => $user->id,
            'document_type' => $request->document_type,
            'file_path' => $path,
            'file_type' => $request->file('document')->extension(),
            'status' => 'pending'
        ]);

        if ($existingDocument) {
            return back()->with('info', 'New document uploaded successfully');
        }

        return back()->with('success', 'Document uploaded successfully');
    }
}
