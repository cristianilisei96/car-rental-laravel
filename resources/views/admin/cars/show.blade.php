<x-admin.layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="mb-6">
            <x-flash-messages />
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden p-6">
            <!-- Carousel/Slideshow -->
            @php $images = $car->images->take(9); @endphp
            <div x-data="{ active: 0, images: {{ $images->pluck('image_path') }} }" class="mb-8">
                <div class="relative w-full flex justify-center items-center">
                    @foreach ($images as $index => $image)
                        <div x-show="active === {{ $index }}" class="relative w-full flex flex-col items-center">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Car image"
                                class="rounded-lg aspect-video object-contain w-full max-w-5xlll shadow border-4 {{ $image->is_main ? 'border-green-500' : 'border-transparent' }} transition">
                            @if ($image->is_main)
                                <span
                                    class="absolute top-4 left-4 bg-green-500 text-white text-md px-3 py-1 rounded shadow">Main</span>
                            @else
                                <form method="POST"
                                    action="{{ route('admin.cars.setMainImage', [$car->id, $image->id]) }}"
                                    class="absolute top-4 left-4">
                                    @csrf
                                    <button type="submit"
                                        class="bg-gray-700 bg-opacity-80 text-white text-md px-3 py-1 rounded shadow hover:bg-green-600 transition">Set
                                        as main</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                    <!-- Carousel controls -->
                    <button type="button" @click="active = active > 0 ? active - 1 : images.length - 1"
                        class="absolute left-5 top-1/2 -translate-y-1/2 bg-gray-700 bg-opacity-60 hover:bg-opacity-90 text-white rounded-full p-2 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <button type="button" @click="active = active < images.length - 1 ? active + 1 : 0"
                        class="absolute right-5 top-1/2 -translate-y-1/2 bg-gray-700 bg-opacity-60 hover:bg-opacity-90 text-white rounded-full p-2 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
                <!-- Thumbnails -->
                <div class="flex justify-center gap-2 mt-4 flex-wrap">
                    @foreach ($images as $index => $image)
                        <button type="button" @click="active = {{ $index }}"
                            :class="[
                                active === {{ $index }} ? 'border-blue-600' : (
                                    {{ $image->is_main ? 'true' : 'false' }} ? 'border-green-500' : 'border-gray-300'
                                )
                            ]"
                            class="border-4 rounded w-24 h-16 bg-gray-200 dark:bg-gray-700 overflow-hidden focus:outline-none transition-all relative">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="thumb"
                                class="object-cover w-full h-full" />
                            @if ($image->is_main)
                                <span
                                    class="absolute top-1 left-1 bg-green-500 text-white text-xs px-1 rounded shadow">Main</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Car details -->
            <div class="mt-10">
                <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-gray-100">Car Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Name</label>
                        <input type="text" value="{{ $car->name }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                    <!-- Brand -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Brand</label>
                        <input type="text" value="{{ $car->brand->name }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                    <!-- Model -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Model</label>
                        <input type="text" value="{{ $car->model->name }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                    <!-- Color -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Color</label>
                        <input type="text" value="{{ $car->color->name }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                    <!-- Fuel -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Fuel</label>
                        <input type="text" value="{{ $car->fuel->name }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                    <!-- Seats -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Seats</label>
                        <input type="text" value="{{ $car->seat->seats }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Type</label>
                        <input type="text" value="{{ $car->type->name }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                    <!-- Transmission -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Transmission</label>
                        <input type="text" value="{{ $car->transmission->name }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Status</label>
                        <input type="text" value="{{ $car->status->name }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                    <!-- Year -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Year</label>
                        <input type="text" value="{{ $car->year }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Price per day</label>
                        <input type="text" value="€{{ $car->price_per_day }}" disabled
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                    </div>

                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Description</label>
                    <textarea disabled rows="4"
                        class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">{{ $car->description }}</textarea>
                </div>
            </div>

        </div>
    </div>
</x-admin.layout>
