<x-admin.layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        <!-- Header și Buton Add New statu -->
        <div class="flex justify-between items-center mb-6" x-data="{ open:false }">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Car status</h1>
            
            <button @click="open = true"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm dark:bg-blue-500 dark:hover:bg-blue-600">
                Add New statu
            </button>

            <!-- Modal Add statu -->
            <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50" style="display:none;">
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="open=false"></div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 z-50 w-full max-w-md">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Add New statu</h2>
                    <form action="{{ route('statuses.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">statu</label>
                            <input type="text" name="name" required
                                   class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:text-white">
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

        <!-- Success message -->
        @if(session('success'))
            <div class="flex items-starat sm:items-center mb-4 px-4 py-3 rounded-md bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2 shrink-0 mt-0.5 sm:mt-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Error message -->
        @if($errors->any())
            <div class="flex items-starat sm:items-center mb-4 px-4 py-3 rounded-md bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                <svg class="w-4 h-4 me-2 shrink-0 mt-0.5 sm:mt-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Table + Edit Modal -->
        <div x-data="{ editOpen:false, editId:null, editName:'' }" class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($statuses as $status)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $status->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $status->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $status->created_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <!-- Edit Button -->
                            <button @click="editId={{ $status->id }}; editName='{{ $status->name }}'; editOpen=true;"
                                    class="px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md text-md mr-2 font-bold">
                                Edit
                            </button>
                            <!-- Delete Form -->
                            <form action="{{ route('statuses.destroy', $status->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-md"
                                        onclick="return confirm('Are you sure you want to delete this statu?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Edit Modal -->
            <div x-show="editOpen" class="fixed inset-0 flex items-center justify-center z-50" style="display:none;">
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="editOpen=false"></div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 z-50 w-full max-w-md">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Edit status</h2>
                    <form :action="`/admin/cars/statuses/${editId}`" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Name</label>
                            <input type="text" name="name" x-model="editName"
                                   class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 focus:border-yellow-500 dark:text-white">
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="editOpen=false" class="mr-2 px-4 py-2 bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 rounded-md text-sm">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Pagination -->
            <div class="p-6">
                {{ $statuses->links() }}
            </div>
        </div>

    </div>
</x-admin.layout>