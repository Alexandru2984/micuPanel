<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Stats Cards -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm font-medium">Total Projects</div>
                    <div class="text-3xl font-bold text-white mt-2">{{ $stats['total_projects'] }}</div>
                </div>
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm font-medium">Active Projects</div>
                    <div class="text-3xl font-bold text-green-400 mt-2">{{ $stats['active_projects'] }}</div>
                </div>
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm font-medium">Broken Projects</div>
                    <div class="text-3xl font-bold text-red-500 mt-2">{{ $stats['broken_projects'] }}</div>
                </div>
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm font-medium">Experimental Projects</div>
                    <div class="text-3xl font-bold text-purple-400 mt-2">{{ $stats['experimental_projects'] }}</div>
                </div>
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm font-medium">Archived Projects</div>
                    <div class="text-3xl font-bold text-gray-500 mt-2">{{ $stats['archived_projects'] }}</div>
                </div>
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm font-medium">Total Domains</div>
                    <div class="text-3xl font-bold text-blue-400 mt-2">{{ $stats['total_domains'] }}</div>
                </div>
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm font-medium">Total Repositories</div>
                    <div class="text-3xl font-bold text-yellow-400 mt-2">{{ $stats['total_repositories'] }}</div>
                </div>
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700">
                    <div class="text-gray-400 text-sm font-medium">Systemd Services</div>
                    <div class="text-3xl font-bold text-orange-400 mt-2">{{ $stats['total_services'] }}</div>
                </div>
            </div>

            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6 text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Recently Updated Projects</h3>
                    @if($recent_projects->count() > 0)
                        <ul class="divide-y divide-gray-700">
                            @foreach($recent_projects as $project)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <div class="text-md font-medium text-white">{{ $project->name }}</div>
                                        <div class="text-sm text-gray-400">{{ $project->stack }} - {{ $project->environment }}</div>
                                    </div>
                                    <div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($project->status == 'active') bg-green-900 text-green-300 
                                            @elseif($project->status == 'broken') bg-red-900 text-red-300 
                                            @else bg-gray-700 text-gray-300 @endif">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No projects found. Add some to get started!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>