<x-admin.layout>
    <div class="max-w-5xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    Edit Car
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Update car details and optionally upload additional images.
                </p>
            </div>

            <a href="{{ route('admin.cars.show', $car->id) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded-md">
                Back to car
            </a>
        </div>

        @if ($errors->any())
            <div
                class="mb-6 flex items-start sm:items-center px-4 py-3 rounded-md bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                <svg class="w-4 h-4 me-2 shrink-0 mt-0.5 sm:mt-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

                {{ $errors->first() }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Name
                        </label>
                        <input type="text" name="name" value="{{ old('name', $car->name) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Brand
                        </label>
                        <select name="brand_id" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                            <option value="">Select brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected((int) old('brand_id', $car->brand_id) === $brand->id)>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Model
                        </label>
                        <select name="model_id" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                            <option value="">Select model</option>
                            @foreach ($models as $model)
                                <option value="{{ $model->id }}" @selected((int) old('model_id', $car->model_id) === $model->id)>
                                    {{ $model->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Color
                        </label>
                        <select name="color_id" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                            <option value="">Select color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}" @selected((int) old('color_id', $car->color_id) === $color->id)>
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Fuel
                        </label>
                        <select name="fuel_id" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                            <option value="">Select fuel</option>
                            @foreach ($fuels as $fuel)
                                <option value="{{ $fuel->id }}" @selected((int) old('fuel_id', $car->fuel_id) === $fuel->id)>
                                    {{ $fuel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Seats
                        </label>
                        <select name="seat_id" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                            <option value="">Select seats</option>
                            @foreach ($seats as $seat)
                                <option value="{{ $seat->id }}" @selected((int) old('seat_id', $car->seat_id) === $seat->id)>
                                    {{ $seat->seats }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Type
                        </label>
                        <select name="type_id" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                            <option value="">Select type</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @selected((int) old('type_id', $car->type_id) === $type->id)>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Transmission
                        </label>
                        <select name="transmission_id" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                            <option value="">Select transmission</option>
                            @foreach ($transmissions as $transmission)
                                <option value="{{ $transmission->id }}" @selected((int) old('transmission_id', $car->transmission_id) === $transmission->id)>
                                    {{ $transmission->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Status
                        </label>
                        <select name="status_id" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                            <option value="">Select status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" @selected((int) old('status_id', $car->status_id) === $status->id)>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Year
                        </label>
                        <input type="number" name="year" value="{{ old('year', $car->year) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Price per day (€)
                        </label>
                        <input type="number" name="price_per_day" step="0.01"
                            value="{{ old('price_per_day', $car->price_per_day) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Description
                    </label>
                    <textarea name="description" rows="4"
                        class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">{{ old('description', $car->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Existing images
                    </label>

                    @if ($car->images->isEmpty())
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            No images uploaded for this car.
                        </p>
                    @else
                        <div class="mt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach ($car->images as $image)
                                <div
                                    class="relative rounded-lg overflow-hidden border {{ $image->is_main ? 'border-green-500' : 'border-gray-300 dark:border-gray-700' }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $car->name }}"
                                        class="w-full h-28 object-cover">

                                    @if ($image->is_main)
                                        <span
                                            class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded">
                                            Main
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Add more images
                    </label>

                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border rounded-md dark:text-white">

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Optional. Upload additional images for this car. Existing images will not be removed.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.cars.index') }}"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-md text-sm">
                        Cancel
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm">
                        Update car
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin.layout>
