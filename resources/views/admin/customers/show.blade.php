<x-admin.layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                #{{ $user->id }} - {{ $user->name }}'s Documents
            </h1>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">
                            Document</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">
                            Document type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">
                            Uploaded At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">
                            Actions</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($documents as $document)
                        <tr>
                            <td class="px-6 py-4">
                                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                                    class="text-blue-600 underline">
                                    View Document
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $types = [
                                        'id_card' => '🪪 ID Card',
                                        'driver_license' => '🚗 Driver License',
                                        'passport' => '🛂 Passport',
                                    ];
                                @endphp

                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                                    {{ $types[$document->document_type] ?? ucfirst($document->document_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($document->status === 'approved')
                                    <span class="font-bold text-green-500">Approved</span>
                                @elseif($document->status === 'pending')
                                    <span class="font-bold text-yellow-500">Pending</span>
                                @elseif($document->status === 'replaced')
                                    <span class="font-bold text-blue-500">Replaced</span>
                                @elseif($document->status === 'rejected')
                                    <span class="font-bold text-red-500">Rejected</span>
                                @else
                                    <span class="font-bold text-gray-500">Unknown</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-300">
                                {{ $document->created_at->format('d-m-Y - H:i:s') }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($document->status !== 'approved')
                                    @if ($document->status !== 'replaced')
                                        <form action="{{ route('admin.customer.documents.approve', $document->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Approve</button>
                                        </form>
                                    @endif
                                    {{-- <form action="{{ route('admin.customers.documents.reject', $document->id) }}" method="POST" style="display:inline; margin-left: 5px;">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Reject</button>
                                    </form> --}}
                                @else
                                    <form action="{{ route('admin.customer.documents.reject', $document->id) }}"
                                        method="POST" style="display:inline; margin-left: 5px;">
                                        @csrf
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Reject</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.customer.documents.destroy', $document->id) }}"
                                    method="POST" style="display:inline; margin-left:5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete document?')"
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-gray-500 dark:text-gray-300">No documents uploaded.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                #{{ $user->id }} - {{ $user->name }}'s Profile
            </h1>

            <a href="{{ route('admin.customers.index') }}"
                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md">
                Back to customers
            </a>
        </div>

        <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg mb-8">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Customer Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                        Name
                    </label>
                    <input type="text" value="{{ $user->name }}" disabled
                        class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                        Email
                    </label>
                    <input type="email" value="{{ $user->email }}" disabled
                        class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                        Created at
                    </label>
                    <input type="text" value="{{ $user->created_at->format('d-m-Y - H:i:s') }}" disabled
                        class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                        KYC Status
                    </label>

                    <div class="mt-2">
                        @if (!$user->document)
                            <span class="px-3 py-1 bg-gray-400 text-white rounded">No document</span>
                        @elseif($user->document->status == 'pending')
                            <span class="px-3 py-1 bg-yellow-400 text-black rounded">Pending</span>
                        @elseif($user->document->status == 'approved')
                            <span class="px-3 py-1 bg-green-500 text-white rounded">Approved</span>
                        @elseif($user->document->status == 'rejected')
                            <span class="px-3 py-1 bg-red-500 text-white rounded">Rejected</span>
                        @else
                            <span class="px-3 py-1 bg-gray-500 text-white rounded">Unknown</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
