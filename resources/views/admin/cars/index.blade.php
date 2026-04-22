<x-admin.layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6" x-data="{ open: false }">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Cars
            </h1>

            <button @click="open = true"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm">
                Add New Car
            </button>


            <!-- Modal Add Car -->
            <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50" style="display:none;">

                <div class="fixed inset-0 bg-black bg-opacity-50" @click="open=false"></div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 z-50 w-full max-w-lg">
                    <h2 class="text-xl font-semibold mb-4">
                        Add New Car
                    </h2>

                    <form action="{{ route('admin.cars.store') }}" method="POST">

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

                    </form>

                </div>
            </div>

        </div>


        {{-- TABLE OR EMPTY STATE --}}

        @if ($cars->count())

            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">

                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Name</th>

                            <th>Image</th>

                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($cars as $car)
                            <tr>

                                <td>{{ $car->id }}</td>

                                <td>{{ $car->name }}</td>

                                <td>

                                    @if ($car->mainImage)
                                        <img src="{{ asset('storage/' . $car->mainImage->path) }}" class="w-16">
                                    @endif

                                </td>

                                <td>

                                    Edit / Delete buttons

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

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
