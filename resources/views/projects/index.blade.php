<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('All Projects') }}
            </h2>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                + New Project
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6 text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap text-left text-sm">
                            <thead class="bg-gray-900 text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-medium">Name</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Environment</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Stack</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Status</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @forelse($projects as $project)
                                    <tr>
                                        <td class="px-6 py-4 font-medium text-white">{{ $project->name }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($project->environment) }}</td>
                                        <td class="px-6 py-4 text-gray-400">{{ $project->stack ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($project->status == 'active') bg-green-900 text-green-300 
                                                @elseif($project->status == 'broken') bg-red-900 text-red-300 
                                                @else bg-gray-700 text-gray-300 @endif">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="text-blue-400 hover:text-blue-300 mr-3">Edit</a>
                                            <a href="#" class="text-red-400 hover:text-red-300">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No projects found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
