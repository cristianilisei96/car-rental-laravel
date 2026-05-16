<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Documents
        </h2>
    </x-slot>

    @php
        $driverLicense = $documents['driver_license'] ?? null;
        $idCard = $documents['id_card'] ?? null;
        $passport = $documents['passport'] ?? null;

        $identityDocument = $idCard ?? $passport;

        $driverLicenseRejected = $driverLicense && $driverLicense->status === 'rejected';
        $identityDocumentRejected = $identityDocument && $identityDocument->status === 'rejected';

        $rejectionMessage = null;

        if ($driverLicenseRejected && $identityDocumentRejected) {
            $rejectionMessage =
                'Your Driver License and identity document were rejected. Please upload valid documents again.';
        } elseif ($driverLicenseRejected) {
            $rejectionMessage = 'Your Driver License was rejected. Please upload another valid Driver License.';
        } elseif ($identityDocumentRejected) {
            $rejectionMessage = 'Your identity document was rejected. Please upload another valid ID Card or Passport.';
        }

        $driverLicensePending = $driverLicense && $driverLicense->status === 'pending';
        $identityDocumentPending = $identityDocument && $identityDocument->status === 'pending';

        $driverLicenseMissing = !$driverLicense;
        $identityDocumentMissing = !$identityDocument;

        $driverLicenseCardClass = $driverLicenseRejected
            ? 'border-red-200 bg-red-50 dark:border-red-900/60 dark:bg-red-950/30'
            : 'border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900';

        $identityDocumentCardClass = $identityDocumentRejected
            ? 'border-red-200 bg-red-50 dark:border-red-900/60 dark:bg-red-950/30'
            : 'border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900';

        $hasAnyDocument = $documents->isNotEmpty();

        $hasPendingDocument = $documents->where('status', 'pending')->isNotEmpty();

        $hasRejectedDocument = $documents->where('status', 'rejected')->isNotEmpty();

        $hasAnyApprovedDocument = $documents->where('status', 'approved')->isNotEmpty();

        $statusClasses = [
            'approved' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300',
            'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
            'replaced' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
        ];

        $statusLabels = [
            'approved' => 'Approved',
            'pending' => 'Pending review',
            'rejected' => 'Rejected',
            'replaced' => 'Replaced',
        ];

        $documentTypeLabels = [
            'id_card' => 'ID Card',
            'driver_license' => 'Driver License',
            'passport' => 'Passport',
        ];

        if ($isKycApproved) {
            $kycStatus = 'approved';
            $kycTitle = 'Your account is verified';
            $kycDescription = 'Your Driver License and identity document are approved. You can rent cars.';
            $kycBadge = 'KYC Approved';
            $kycBadgeClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300';
        } elseif (!$hasAnyDocument) {
            $kycStatus = 'not_started';
            $kycTitle = 'Verification not started';
            $kycDescription = 'Upload your Driver License and an ID Card or Passport to start verification.';
            $kycBadge = 'Not Started';
            $kycBadgeClass = 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300';
        } elseif ($hasPendingDocument) {
            $kycStatus = 'pending';
            $kycTitle = 'Verification in progress';
            $kycDescription = 'At least one document is waiting for admin review.';
            $kycBadge = 'KYC Pending';
            $kycBadgeClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300';
        } elseif ($hasRejectedDocument && !$isKycApproved) {
            $kycStatus = 'action_required';
            $kycTitle = 'Action required';
            $kycBadge = 'Action Required';
            $kycBadgeClass = 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300';

            if ($driverLicenseRejected && $identityDocumentRejected) {
                $kycDescription =
                    'Your Driver License and identity document were rejected. Please upload valid documents again.';
            } elseif ($driverLicenseRejected) {
                $kycDescription = 'Your Driver License was rejected. Please upload another valid Driver License.';
            } elseif ($identityDocumentRejected) {
                $kycDescription =
                    'Your identity document was rejected. Please upload another valid ID Card or Passport.';
            } else {
                $kycDescription = 'One or more required documents were rejected. Please upload valid documents again.';
            }
        } else {
            $kycStatus = 'incomplete';
            $kycTitle = 'Verification incomplete';
            $kycBadge = 'Incomplete';
            $kycBadgeClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300';

            if (!$hasApprovedDriverLicense && !$hasApprovedIdentityDocument) {
                $kycDescription = 'You still need an approved Driver License and an approved ID Card or Passport.';
            } elseif (!$hasApprovedDriverLicense) {
                $kycDescription = 'Your identity document is approved. You still need an approved Driver License.';
            } elseif (!$hasApprovedIdentityDocument) {
                $kycDescription = 'Your Driver License is approved. You still need an approved ID Card or Passport.';
            } else {
                $kycDescription = 'Your verification is incomplete. Please check the required documents below.';
            }
        }

        function documentStatusBadge($document, $statusClasses, $statusLabels)
        {
            if (!$document) {
                return '<span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-300">Missing</span>';
            }

            $class =
                $statusClasses[$document->status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300';
            $label = $statusLabels[$document->status] ?? ucfirst($document->status);

            return '<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ' .
                $class .
                '">' .
                $label .
                '</span>';
        }
    @endphp

    <div class="py-12 bg-gray-100 dark:bg-gray-950 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash messages --}}
            @if (session('success'))
                <div
                    class="rounded-2xl border border-green-200 bg-green-50 p-4 text-green-800 dark:border-green-900 dark:bg-green-950/40 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div
                    class="rounded-2xl border border-blue-200 bg-blue-50 p-4 text-blue-800 dark:border-blue-900 dark:bg-blue-950/40 dark:text-blue-300">
                    {{ session('info') }}
                </div>
            @endif

            @if (session('warning'))
                <div
                    class="rounded-2xl border border-yellow-200 bg-yellow-50 p-4 text-yellow-800 dark:border-yellow-900 dark:bg-yellow-950/40 dark:text-yellow-300">
                    {{ session('warning') }}
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800 dark:border-red-900 dark:bg-red-950/40 dark:text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($rejectionMessage)
                <div
                    class="rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">
                    <div class="flex items-start gap-3">
                        <div class="text-xl">⚠️</div>

                        <div>
                            <p class="font-semibold">
                                Document rejected
                            </p>

                            <p class="mt-1 text-sm">
                                {{ $rejectionMessage }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- KYC status card --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">
                            Account verification
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $kycTitle }}
                        </h3>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600 dark:text-gray-400">
                            {{ $kycDescription }}
                        </p>
                    </div>

                    <span class="inline-flex rounded-full px-4 py-2 text-sm font-bold {{ $kycBadgeClass }}">
                        {{ $kycBadge }}
                    </span>
                </div>
            </div>

            {{-- Requirements checklist --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Driver License --}}
                <div class="rounded-2xl border p-6 shadow-sm {{ $driverLicenseCardClass }}">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                Driver License
                            </h3>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Required for every rental.
                            </p>
                        </div>

                        {!! documentStatusBadge($driverLicense, $statusClasses, $statusLabels) !!}
                    </div>

                    @if ($driverLicense)
                        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            Uploaded on {{ $driverLicense->created_at->format('d.m.Y H:i') }}
                        </div>

                        <a href="{{ Storage::url($driverLicense->file_path) }}" target="_blank"
                            class="mt-4 inline-flex text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            View document →
                        </a>

                        @if ($driverLicenseRejected)
                            <p class="mt-3 text-sm font-semibold text-red-700 dark:text-red-300">
                                Please upload another valid Driver License.
                            </p>
                        @endif
                    @else
                        <p class="mt-4 text-sm text-red-600 dark:text-red-400">
                            You still need to upload your Driver License.
                        </p>
                    @endif
                </div>

                {{-- Identity Document --}}
                <div class="rounded-2xl border p-6 shadow-sm {{ $identityDocumentCardClass }}">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                Identity Document
                            </h3>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Upload an ID Card or Passport.
                            </p>
                        </div>

                        {!! documentStatusBadge($identityDocument, $statusClasses, $statusLabels) !!}
                    </div>

                    @if ($identityDocument)
                        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $documentTypeLabels[$identityDocument->document_type] ?? 'Identity document' }}
                            uploaded on {{ $identityDocument->created_at->format('d.m.Y H:i') }}
                        </div>

                        <a href="{{ Storage::url($identityDocument->file_path) }}" target="_blank"
                            class="mt-4 inline-flex text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            View document →
                        </a>

                        @if ($identityDocumentRejected)
                            <p class="mt-3 text-sm font-semibold text-red-700 dark:text-red-300">
                                Please upload another valid ID Card or Passport.
                            </p>
                        @endif
                    @else
                        <p class="mt-4 text-sm text-red-600 dark:text-red-400">
                            You still need an approved ID Card or Passport.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Upload form --}}
            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    Upload a document
                </h3>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    If you upload a new document of the same type, the previous one will be marked as replaced.
                </p>

                <form method="POST" action="{{ route('customer.document.store') }}" enctype="multipart/form-data"
                    class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Document type
                        </label>

                        <select name="document_type" required
                            class="block w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                            <option value="">Select document</option>
                            <option value="id_card">ID Card</option>
                            <option value="driver_license">Driver License</option>
                            <option value="passport">Passport</option>
                        </select>

                        @error('document_type')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            File
                        </label>

                        <input type="file" name="document" required accept=".jpg,.jpeg,.png,.pdf"
                            class="block w-full cursor-pointer rounded-xl border border-gray-300 bg-white p-3 text-sm text-gray-900 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Accepted formats: JPG, PNG or PDF. Maximum size: 5MB.
                        </p>

                        @error('document')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Upload document
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
