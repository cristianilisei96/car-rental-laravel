<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;

class CustomerController extends Controller
{
    public function index()
    {
        // $customers = User::where('is_admin', 0)->paginate(20);


        $customers = User::where('is_admin', 0)
            ->with('document')->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        $documents = $user->documents()->orderBy('id', 'desc')->get();
        return view('admin.customers.show', compact('user', 'documents'));
    }

    public function approve($id)
    {
        $document = CustomerDocument::findOrFail($id);
        $document->status = 'approved';
        $document->approved_at = now();
        $document->approved_by = auth()->id();
        $document->save();

        return redirect()->back()->with('success', 'Document approved successfully.');
    }

    public function reject($id)
    {
        $document = CustomerDocument::findOrFail($id);
        $document->status = 'rejected';
        $document->approved_at = null;
        $document->approved_by = null;
        $document->save();

        return redirect()->back()->with('success', 'Document rejected!');
    }

    public function destroyDocument(CustomerDocument $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted successfully');
    }
}
