<x-admin.layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">#<?= $user->id . ' - ' . $user->name; ?>'s Documents</h1>
        </div>

        <div x-data="{ editOpen:false, editId:null, editName:'' }" class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">Document</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">Document type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">Uploaded At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase">Actions</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($documents as $document)
                        <tr>
                            <td class="px-6 py-4">
                                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-blue-600 underline">
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
                                @if($document->status === 'approved')
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
                                @if($document->status !== 'approved')
                                    
                                    @if($document->status !== 'replaced')
                                        <form action="{{ route('admin.customer.documents.approve', $document->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Approve</button>
                                    </form>
                                    @endif
                                    {{-- <form action="{{ route('admin.customers.documents.reject', $document->id) }}" method="POST" style="display:inline; margin-left: 5px;">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Reject</button>
                                    </form> --}}
                                @else                                    
                                    <form action="{{ route('admin.customer.documents.reject', $document->id) }}" method="POST" style="display:inline; margin-left: 5px;">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Reject</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.customer.documents.destroy', $document->id) }}" method="POST" style="display:inline; margin-left:5px;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete document?')" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-gray-500 dark:text-gray-300">No documents uploaded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">#<?= $user->id . ' - ' . $user->name; ?>'s Profile</h1>
        </div>
        
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Profile Information') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Update your account's profile information and email address.") }}
                        </p>
                    </header>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div>
                                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                        {{ __('Your email address is unverified.') }}

                                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    
</x-admin.layout>


