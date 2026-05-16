<x-customer.layout title="Customer Dashboard | Car Rental Laravel">
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Customer Dashboard
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Overview of your verification status, documents, favorites and future rentals.
            </p>
        </div>
    </x-slot>

    @php
        $user = Auth::user();

        $activeDocuments = $user
            ->documents()
            ->where('status', '!=', 'replaced')
            ->latest()
            ->get()
            ->unique('document_type')
            ->keyBy('document_type');

        $driverLicense = $activeDocuments['driver_license'] ?? null;
        $idCard = $activeDocuments['id_card'] ?? null;
        $passport = $activeDocuments['passport'] ?? null;
        $identityDocument = $idCard ?? $passport;

        $hasApprovedDriverLicense = $user->hasApprovedDriverLicense();
        $hasApprovedIdentityDocument = $user->hasApprovedIdentityDocument();
        $isKycApproved = $user->isKycApproved();
        $hasCompleteCustomerProfile = $user->hasCompleteCustomerProfile();

        $hasAnyDocument = $activeDocuments->isNotEmpty();
        $hasPendingDocument = $activeDocuments->where('status', 'pending')->isNotEmpty();
        $hasRejectedDocument = $activeDocuments->where('status', 'rejected')->isNotEmpty();

        $uploadedDocumentsCount = $activeDocuments->count();
        $favoriteCarsCount = $user->favoriteCars()->count();

        $totalRentals = $user->rentals()->count();

        $pendingRentals = $user
            ->rentals()
            ->whereHas('status', function ($query) {
                $query->where('slug', 'pending');
            })
            ->count();

        $totalSpent = $user->rentals()->where('payment_status', 'paid')->sum('total_price');

        $driverLicenseRejected = $driverLicense && $driverLicense->status === 'rejected';
        $identityDocumentRejected = $identityDocument && $identityDocument->status === 'rejected';

        $driverLicenseIsMissing = !$driverLicense;
        $identityDocumentIsMissing = !$identityDocument;

        $driverLicenseIsClickable = $driverLicenseIsMissing || $driverLicenseRejected;
        $identityDocumentIsClickable = $identityDocumentIsMissing || $identityDocumentRejected;

        if ($isKycApproved) {
            $kycLabel = 'Approved';
            $kycTitle = 'Your account is verified';
            $kycDescription = 'Your Driver License and identity document are approved. You can rent cars.';
            $kycBadgeClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300';
        } elseif (!$hasAnyDocument) {
            $kycLabel = 'Not Started';
            $kycTitle = 'Verification not started';
            $kycDescription = 'Upload your Driver License and an ID Card or Passport to start verification.';
            $kycBadgeClass = 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300';
        } elseif ($hasPendingDocument) {
            $kycLabel = 'Pending';
            $kycTitle = 'Verification in progress';
            $kycDescription = 'At least one document is waiting for admin review.';
            $kycBadgeClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300';
        } elseif ($hasRejectedDocument) {
            $kycLabel = 'Action Required';
            $kycTitle = 'Action required';
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
            $kycLabel = 'Incomplete';
            $kycTitle = 'Verification incomplete';
            $kycBadgeClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300';

            if (!$hasApprovedDriverLicense && !$hasApprovedIdentityDocument) {
                $kycDescription = 'You still need an approved Driver License and an approved ID Card or Passport.';
            } elseif (!$hasApprovedDriverLicense) {
                $kycDescription = 'Your identity document is approved. You still need an approved Driver License.';
            } elseif (!$hasApprovedIdentityDocument) {
                $kycDescription = 'Your Driver License is approved. You still need an approved ID Card or Passport.';
            } else {
                $kycDescription = 'Your verification is incomplete. Please check your documents.';
            }
        }

        $documentStatusClasses = [
            'approved' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300',
            'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
            'replaced' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
        ];

        $documentStatusLabels = [
            'approved' => 'Approved',
            'pending' => 'Pending review',
            'rejected' => 'Rejected',
            'replaced' => 'Replaced',
        ];

        $getDocumentBadge = function ($document) use ($documentStatusClasses, $documentStatusLabels) {
            if (!$document) {
                return [
                    'label' => 'Missing',
                    'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                ];
            }

            return [
                'label' => $documentStatusLabels[$document->status] ?? ucfirst($document->status),
                'class' =>
                    $documentStatusClasses[$document->status] ??
                    'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
            ];
        };

        $driverLicenseBadge = $getDocumentBadge($driverLicense);
        $identityDocumentBadge = $getDocumentBadge($identityDocument);

        $driverLicenseCardClass = $driverLicenseRejected
            ? 'border-red-200 bg-red-50 transition hover:border-red-300 hover:bg-red-100 dark:border-red-900/60 dark:bg-red-950/30 dark:hover:bg-red-950/50'
            : 'border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-950';

        $identityDocumentCardClass = $identityDocumentRejected
            ? 'border-red-200 bg-red-50 transition hover:border-red-300 hover:bg-red-100 dark:border-red-900/60 dark:bg-red-950/30 dark:hover:bg-red-950/50'
            : 'border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-950';
    @endphp

    <div class="py-10 bg-gray-100 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome --}}
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">
                        Welcome back
                    </p>

                    <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $user->name }}
                    </h1>

                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Manage your verification, favorite cars and future reservations from one place.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('cars.index') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Browse cars
                    </a>

                    <a href="{{ route('customer.document.create') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-800 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800">
                        My documents
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Verification
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $kycLabel }}
                            </p>
                        </div>

                        <span class="text-3xl">🪪</span>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Favorite cars
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $favoriteCarsCount }}
                            </p>
                        </div>

                        <span class="text-3xl">❤️</span>
                    </div>
                </div>

                <a href="{{ route('customer.account-details.edit') }}"
                    class="block rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-500 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Account details
                            </p>

                            <p
                                class="mt-2 text-2xl font-bold {{ $hasCompleteCustomerProfile ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                {{ $hasCompleteCustomerProfile ? 'Complete' : 'Incomplete' }}
                            </p>
                        </div>

                        <span class="text-3xl">👤</span>
                    </div>
                </a>

                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Total spent
                            </p>

                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                €{{ number_format($totalSpent, 2) }}
                            </p>
                        </div>

                        <span class="text-3xl">💶</span>
                    </div>
                </div>
            </div>

            {{-- KYC + quick actions --}}
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- KYC Status --}}
                <div
                    class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">
                                Account verification
                            </p>

                            <h2 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $kycTitle }}
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                                {{ $kycDescription }}
                            </p>
                        </div>

                        <span class="inline-flex w-fit rounded-full px-4 py-2 text-sm font-bold {{ $kycBadgeClass }}">
                            {{ $kycLabel }}
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">

                        {{-- Driver License card --}}
                        @if ($driverLicenseIsClickable)
                            <a href="{{ route('customer.document.create') }}"
                                class="block rounded-2xl border p-5 {{ $driverLicenseCardClass }}">
                            @else
                                <div class="rounded-2xl border p-5 {{ $driverLicenseCardClass }}">
                        @endif

                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white">
                                    Driver License
                                </h3>

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Required for every rental.
                                </p>
                            </div>

                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $driverLicenseBadge['class'] }}">
                                {{ $driverLicenseBadge['label'] }}
                            </span>
                        </div>

                        @if ($driverLicense)
                            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                Uploaded on {{ $driverLicense->created_at->format('d.m.Y H:i') }}
                            </p>

                            @if ($driverLicenseRejected)
                                <p class="mt-3 text-sm font-semibold text-red-700 dark:text-red-300">
                                    Upload another valid Driver License →
                                </p>
                            @endif
                        @else
                            <p class="mt-4 text-sm text-red-600 dark:text-red-400">
                                You still need to upload your Driver License.
                            </p>
                        @endif

                        @if ($driverLicenseIsClickable)
                            </a>
                        @else
                    </div>
                    @endif

                    {{-- Identity Document card --}}
                    @if ($identityDocumentIsClickable)
                        <a href="{{ route('customer.document.create') }}"
                            class="block rounded-2xl border p-5 {{ $identityDocumentCardClass }}">
                        @else
                            <div class="rounded-2xl border p-5 {{ $identityDocumentCardClass }}">
                    @endif

                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">
                                Identity Document
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                ID Card or Passport.
                            </p>
                        </div>

                        <span class="rounded-full px-3 py-1 text-xs font-bold {{ $identityDocumentBadge['class'] }}">
                            {{ $identityDocumentBadge['label'] }}
                        </span>
                    </div>

                    @if ($identityDocument)
                        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $identityDocument->document_type === 'passport' ? 'Passport' : 'ID Card' }}
                            uploaded on {{ $identityDocument->created_at->format('d.m.Y H:i') }}
                        </p>

                        @if ($identityDocumentRejected)
                            <p class="mt-3 text-sm font-semibold text-red-700 dark:text-red-300">
                                Upload another valid ID Card or Passport →
                            </p>
                        @endif
                    @else
                        <p class="mt-4 text-sm text-red-600 dark:text-red-400">
                            You still need to upload an ID Card or Passport.
                        </p>
                    @endif

                    @if ($identityDocumentIsClickable)
                        </a>
                    @else
                </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                Quick actions
            </h2>

            <div class="mt-6 space-y-3">
                <a href="{{ route('cars.index') }}"
                    class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 font-semibold text-gray-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-gray-800 dark:text-gray-200 dark:hover:border-blue-500 dark:hover:text-blue-400">
                    <span>Browse cars</span>
                    <span>→</span>
                </a>

                <a href="{{ route('customer.favorites.index') }}"
                    class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 font-semibold text-gray-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-gray-800 dark:text-gray-200 dark:hover:border-blue-500 dark:hover:text-blue-400">
                    <span>View favorites</span>
                    <span>→</span>
                </a>

                <a href="{{ route('customer.document.create') }}"
                    class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 font-semibold text-gray-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-gray-800 dark:text-gray-200 dark:hover:border-blue-500 dark:hover:text-blue-400">
                    <span>Upload documents</span>
                    <span>→</span>
                </a>

                <a href="{{ route('customer.rentals.index') }}"
                    class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 font-semibold text-gray-700 transition hover:border-blue-500 hover:text-blue-600 dark:border-gray-800 dark:text-gray-200 dark:hover:border-blue-500 dark:hover:text-blue-400">
                    <span>My rentals</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Rental overview --}}
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <a href="{{ route('customer.rentals.index') }}"
            class="block rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-500 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-blue-500">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Total rentals
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                {{ $totalRentals }}
            </p>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                View your rental history and reservation details.
            </p>
        </a>

        <a href="{{ route('customer.rentals.index') }}"
            class="block rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-yellow-500 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-yellow-500">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Pending rentals
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                {{ $pendingRentals }}
            </p>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                View requests waiting for admin approval.
            </p>
        </a>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Payment methods
            </p>

            <p class="mt-2 text-lg font-bold text-gray-900 dark:text-white">
                Cash / Card
            </p>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Payment tracking will support unpaid, pending, paid and refunded statuses.
            </p>
        </div>
    </div>

    </div>
    </div>
</x-customer.layout>
