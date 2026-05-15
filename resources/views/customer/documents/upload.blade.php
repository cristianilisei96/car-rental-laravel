<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Upload Identity Document') }}
            </h2>
        </x-slot>

        <!-- Success message -->
        @if (session('success'))
            <div
                class="flex items-starat sm:items-center mb-4 px-4 py-3 rounded-md bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4 me-2 shrink-0 mt-0.5 sm:mt-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Info message -->
        @if (session('info'))
            <div
                class="flex items-starat sm:items-center mb-4 px-4 py-3 rounded-md bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4 me-2 shrink-0 mt-0.5 sm:mt-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
                {{ session('info') }}
            </div>
        @endif

        <!-- Error message -->
        @if ($errors->any())
            <div
                class="flex items-starat sm:items-center mb-4 px-4 py-3 rounded-md bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                <svg class="w-4 h-4 me-2 shrink-0 mt-0.5 sm:mt-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                {{ $errors->first() }}
            </div>
        @endif

        @if ($document)
            <div class="mb-6 p-4 bg-white dark:bg-gray-800 shadow text-white sm:rounded-lg">
                <p class="font-semibold">Document already uploaded</p>
                <p>Status:
                    @if ($document->status == 'pending')
                        <span class="font-bold text-yellow-500">Pending verification</span>
                    @elseif($document->status == 'approved')
                        <span class="font-bold text-green-500">Approved</span>
                    @elseif($document->status == 'rejected')
                        <span class="font-bold text-red-500">Rejected</span>
                    @endif
                </p>

                @if ($document)

                    <div class="mt-4">

                        @if (in_array($document->file_type, ['jpg', 'jpeg', 'png']))
                            <div>
                                <a href="{{ Storage::url($document->file_path) }}" class="inline-block" target="_blank">
                                    <img src="{{ Storage::url($document->file_path) }}"
                                        class="w-64 rounded-lg shadow-md border hover:scale-105 transition" />
                                </a>
                            </div>
                        @elseif($document->file_type == 'pdf')
                            {{-- <div class="flex items-center space-x-2 text-gray-700">📄 PDF document uploaded</div> --}}
                            {{-- <a href="{{ Storage::url($document->file_path) }}" class="inline-block" target="_blank">
                        <img src="{{ Storage::url($document->file_path) }}" class="w-64 rounded-lg shadow-md border hover:scale-105 transition" />
                    </a> --}}

                            <object data="{{ Storage::url($document->file_path) }}" type="application/pdf"
                                class="w-505 rounded-lg shadow-md border hover:scale-105 transition">
                                <p>Unable to display PDF file. <a
                                        href="{{ Storage::url($document->file_path) }}">Download</a> instead.</p>
                            </object>

                            <embed src="{{ Storage::url($document->file_path) }}" type="application/pdf" width="50%"
                                height="500px">
                        @endif

                        <div>
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                                class="inline-block mt-3 text-indigo-600 hover:underline font-semibold">View full
                                document →</a>
                        </div>

                    </div>

                @endif

            </div>
        @else
            <div class="mb-6 p-4 bg-blue-500 rounded">
                <p>No document uploaded yet</p>
            </div>

        @endif

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <form method="POST" action="{{ route('customer.document.store') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Upload ID document (jpg / png / pdf)
                    </label>

                    <select name="document_type" required
                        class="mb-3 block text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                        <option value="">Select document</option>
                        <option value="id_card">ID Card</option>
                        <option value="driver_license">Driver License</option>
                        <option value="passport">Passport</option>
                    </select>

                    <input type="file" name="document" required
                        class="block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400" />

                    @error('document')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">Upload
                        document</button>
                </div>
            </form>
        </div>

    </div>

    <x-public-footer />
</x-app-layout>
