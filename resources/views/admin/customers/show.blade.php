<x-admin.layout>
    @php
        $activeDocuments = $user->documents()->where('status', '!=', 'replaced')->get();

        $hasAnyDocument = $activeDocuments->isNotEmpty();
        $hasPendingDocument = $activeDocuments->where('status', 'pending')->isNotEmpty();
        $hasRejectedDocument = $activeDocuments->where('status', 'rejected')->isNotEmpty();

        $hasApprovedDriverLicense = $user->hasApprovedDriverLicense();
        $hasApprovedIdentityDocument = $user->hasApprovedIdentityDocument();

        if ($user->isKycApproved()) {
            $kycLabel = 'Approved';
            $kycClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300';
            $kycDescription = 'Driver License and identity document are approved.';
        } elseif (!$hasAnyDocument) {
            $kycLabel = 'Not Started';
            $kycClass = 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300';
            $kycDescription = 'The customer has not uploaded any document yet.';
        } elseif ($hasPendingDocument) {
            $kycLabel = 'Pending';
            $kycClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300';
            $kycDescription = 'At least one document is waiting for review.';
        } elseif ($hasRejectedDocument) {
            $kycLabel = 'Action Required';
            $kycClass = 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300';
            $kycDescription = 'One or more required documents were rejected.';
        } else {
            $kycLabel = 'Incomplete';
            $kycClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300';
            $kycDescription =
                'The customer still needs an approved Driver License and an approved ID Card or Passport.';
        }

        $types = [
            'id_card' => '🪪 ID Card',
            'driver_license' => '🚗 Driver License',
            'passport' => '🛂 Passport',
        ];

        $statusClasses = [
            'approved' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300',
            'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
            'replaced' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
        ];

        $statusLabels = [
            'approved' => 'Approved',
            'pending' => 'Pending',
            'rejected' => 'Rejected',
            'replaced' => 'Replaced',
        ];
    @endphp

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">
                    Customer verification
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                    #{{ $user->id }} - {{ $user->name }}
                </h1>

                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Review customer documents and verification status before allowing rentals.
                </p>
            </div>

            <a href="{{ route('admin.customers.index') }}"
                class="inline-flex items-center justify-center rounded-xl bg-gray-700 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800 dark:bg-gray-800 dark:hover:bg-gray-700">
                ← Back to customers
            </a>
        </div>

        {{-- KYC Summary --}}
        <div
            class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            KYC Status
                        </h2>

                        <span class="inline-flex rounded-full px-4 py-1.5 text-sm font-bold {{ $kycClass }}">
                            {{ $kycLabel }}
                        </span>
                    </div>

                    <p class="mt-3 text-sm leading-6 text-gray-600 dark:text-gray-400">
                        {{ $kycDescription }}
                    </p>
                </div>

                <div class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2 lg:max-w-xl">
                    <div
                        class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-950">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                    Driver License
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Required for rentals
                                </p>
                            </div>

                            @if ($hasApprovedDriverLicense)
                                <span
                                    class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700 dark:bg-green-900/40 dark:text-green-300">
                                    Approved
                                </span>
                            @else
                                <span
                                    class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700 dark:bg-red-900/40 dark:text-red-300">
                                    Missing
                                </span>
                            @endif
                        </div>
                    </div>

                    <div
                        class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-950">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                    Identity Document
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    ID Card or Passport
                                </p>
                            </div>

                            @if ($hasApprovedIdentityDocument)
                                <span
                                    class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700 dark:bg-green-900/40 dark:text-green-300">
                                    Approved
                                </span>
                            @else
                                <span
                                    class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700 dark:bg-red-900/40 dark:text-red-300">
                                    Missing
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Customer information --}}
        <div
            class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                Customer Information
            </h2>

            <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                        Name
                    </label>

                    <div
                        class="mt-2 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 dark:border-gray-800 dark:bg-gray-950 dark:text-gray-100">
                        {{ $user->name }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                        Email
                    </label>

                    <div
                        class="mt-2 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 dark:border-gray-800 dark:bg-gray-950 dark:text-gray-100">
                        {{ $user->email }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                        Created at
                    </label>

                    <div
                        class="mt-2 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 dark:border-gray-800 dark:bg-gray-950 dark:text-gray-100">
                        {{ $user->created_at->format('d-m-Y - H:i:s') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Documents --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div
                class="flex flex-col gap-3 border-b border-gray-200 p-6 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Uploaded Documents
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Approve or reject the documents uploaded by this customer.
                    </p>
                </div>

                <span
                    class="inline-flex w-fit rounded-full bg-gray-100 px-4 py-1.5 text-sm font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    {{ $documents->count() }} {{ \Illuminate\Support\Str::plural('document', $documents->count()) }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-950">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Document
                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Type
                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Status
                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Uploaded
                            </th>

                            <th
                                class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($documents as $document)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-950/60">
                                <td class="px-6 py-4">
                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                                        class="inline-flex items-center rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50 dark:border-gray-800 dark:text-blue-400 dark:hover:bg-blue-950/30">
                                        View Document
                                    </a>
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                                        {{ $types[$document->document_type] ?? ucfirst(str_replace('_', ' ', $document->document_type)) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $statusClass =
                                            $statusClasses[$document->status] ??
                                            'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300';
                                        $statusLabel = $statusLabels[$document->status] ?? ucfirst($document->status);
                                    @endphp

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-sm font-bold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $document->created_at->format('d-m-Y - H:i:s') }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        @if ($document->status !== 'approved' && $document->status !== 'replaced')
                                            <form
                                                action="{{ route('admin.customer.documents.approve', $document->id) }}"
                                                method="POST">
                                                @csrf

                                                <button type="submit"
                                                    class="rounded-lg bg-green-600 px-3 py-2 text-sm font-semibold text-white hover:bg-green-700">
                                                    Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if ($document->status === 'approved')
                                            <form
                                                action="{{ route('admin.customer.documents.reject', $document->id) }}"
                                                method="POST">
                                                @csrf

                                                <button type="submit"
                                                    class="rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                                    Reject
                                                </button>
                                            </form>
                                        @endif

                                        @if ($document->status !== 'replaced')
                                            <form
                                                action="{{ route('admin.customer.documents.destroy', $document->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" onclick="return confirm('Delete document?')"
                                                    class="rounded-lg bg-gray-600 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                    No documents uploaded.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin.layout>
