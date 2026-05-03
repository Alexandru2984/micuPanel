<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Documentation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6 text-gray-100 prose prose-invert">
                    <h1>MicuPanel Documentation</h1>
                    <p>MicuPanel is a private, self-hosted admin panel for managing your entire VPS ecosystem, services, domains, and repositories.</p>

                    <h2>Data Model</h2>
                    <ul>
                        <li><strong>Projects</strong>: Core entity. Represents a deployed application or experiment.</li>
                        <li><strong>Domains</strong>: Related to projects. Maps URLs to projects.</li>
                        <li><strong>Repositories</strong>: Git repos associated with a project.</li>
                        <li><strong>Services</strong>: Systemd, Docker, or Nginx services running a project.</li>
                        <li><strong>Notes</strong>: General or project-specific notes.</li>
                        <li><strong>Tags</strong>: For categorizing projects (Many-to-Many).</li>
                    </ul>

                    <h2>Security Model</h2>
                    <p>Registration is strictly disabled. The application requires authentication for all pages except the <code>/health</code> endpoint. <strong>Do NOT store secrets, API keys, or database passwords in the project records.</strong></p>

                    <h2>Import/Export Format</h2>
                    <p>Data can be exported via the API. JSON export includes all related domains, repositories, and services. CSV export provides a flat list of projects.</p>

                    <h2>Limitations of v1</h2>
                    <ul>
                        <li>No direct shell execution.</li>
                        <li>No log viewing capabilities.</li>
                        <li>Read-only metadata storage.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>