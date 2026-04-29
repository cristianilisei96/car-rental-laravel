<x-admin.layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6" x-data="{ open: false }">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Cars</h1>

            <button @click="open = true"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm">
                Add New Car
            </button>

            <!-- Modal Add Car -->
            <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50" style="display:none;">
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="open=false"></div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 z-50 w-full max-w-md">
                    <h2 class="text-xl font-semibold mb-4">Add New Car</h2>
                    {{-- <form action="{{ route('admin.cars.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" name="name" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:text-white">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Brand</label>
                            <select name="brand_id" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:text-white">
                                <option value="">Select brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                            <select name="color_id" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:text-white">
                                <option value="">Select color</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="open=false"
                                class="mr-2 px-4 py-2 bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 rounded-md text-sm">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm">
                                Save
                            </button>
                        </div>
                    </form> --}}
                    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data"
                        class="text-white">
                        @csrf

                        <!-- NAME -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Name</label>
                            <input type="text" name="name" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                        </div>

                        <!-- BRAND -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Brand</label>
                            <select name="brand_id" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                                <option value="">Select brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- MODEL -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Model</label>
                            <select name="model_id" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                                <option value="">Select model</option>
                                @foreach ($models as $model)
                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- COLOR -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Color</label>
                            <select name="color_id" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                                <option value="">Select color</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- FUEL -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Fuel</label>
                            <select name="fuel_id" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                                <option value="">Select fuel</option>
                                @foreach ($fuels as $fuel)
                                    <option value="{{ $fuel->id }}">{{ $fuel->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- SEATS -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Seats</label>
                            <select name="seat_id" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                                <option value="">Select seats</option>
                                @foreach ($seats as $seat)
                                    <option value="{{ $seat->id }}">{{ $seat->seats }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- TYPE -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Type</label>
                            <select name="type_id" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                                <option value="">Select type</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- TRANSMISSION -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Transmission</label>
                            <select name="transmission_id" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                                <option value="">Select transmission</option>
                                @foreach ($transmissions as $transmission)
                                    <option value="{{ $transmission->id }}">{{ $transmission->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- STATUS -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Status</label>
                            <select name="status_id" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                                <option value="">Select status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- YEAR -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Year</label>
                            <input type="number" name="year" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                        </div>

                        <!-- PRICE -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Price per day (€)</label>
                            <input type="number" name="price_per_day" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                        </div>

                        <!-- DESCRIPTION -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Description</label>
                            <textarea name="description" rows="3"
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md"></textarea>
                        </div>

                        <!-- IMAGES -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Images</label>
                            <input type="file" name="images[]" multiple accept="image/*"
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md">
                        </div>

                        <div class="flex justify-end">
                            <button type="button" @click="open=false"
                                class="mr-2 px-4 py-2 bg-gray-300 rounded-md">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

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

        <!-- Error message -->
        @if ($errors->any())
            <div
                class="flex items-starat sm:items-center mb-4 px-4 py-3 rounded-md bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                <svg class="w-4 h-4 me-2 shrink-0 mt-0.5 sm:mt-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                {{ $errors->first() }}
            </div>
        @endif


        {{-- TABLE OR EMPTY STATE --}}
        @if ($cars->count())

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-4 py-3 w-40 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Image</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($cars as $car)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $car->id }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                        <div class="font-medium">{{ $car->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $car->brand_id ? 'Brand ID: ' . $car->brand_id : '' }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div
                                            class="w-36 h-24 bg-gray-100 dark:bg-gray-900 rounded overflow-hidden flex items-center justify-center">
                                            @if ($car->mainImage && $car->mainImage->image_path)
                                                <a href="{{ asset('storage/' . $car->mainImage->image_path) }}"
                                                    target="_blank" rel="noopener">
                                                    <img src="{{ asset('storage/' . $car->mainImage->image_path) }}"
                                                        alt="{{ $car->name }}" class="w-full h-full object-cover">
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400">No image</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center space-x-2">
                                            <a href="{{ route('admin.cars.show', $car->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-xs font-medium text-white rounded">
                                                View
                                            </a>

                                            <a href="{{ route('admin.cars.edit', $car->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-xs font-medium text-gray-900 rounded">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this car?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-xs font-medium text-white rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- <div class="px-6 py-4 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600 dark:text-gray-300">
                            Showing {{ $cars->firstItem() ?? 0 }} to {{ $cars->lastItem() ?? 0 }} of
                            {{ $cars->total() }} results
                        </div>

                        <div>
                            {{ $cars->links() }}
                        </div>
                    </div>
                </div> --}}

                <!-- Pagination -->
                <div class="p-6">
                    {{ $cars->links() }}
                </div>

            </div>
        @else
            {{-- EMPTY STATE UI --}}

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-12 text-center">
                <h2 class="text-xl font-semibold mb-2 text-white">
                    No cars found
                </h2>

                <p class="text-gray-500 mb-6">
                    Start by adding your first car 🚗
                </p>
            </div>
        @endif
    </div>
</x-admin.layout>
