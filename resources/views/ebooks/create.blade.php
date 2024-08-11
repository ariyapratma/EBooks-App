<!-- resources/views/ebooks/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah eBook') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Display success or error messages -->
                @if (session('success'))
                    <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('ebooks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <x-label for="name" value="{{ __('Nama eBook') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" required
                            autofocus />
                    </div>

                    <div class="mt-4">
                        <x-label for="pdf" value="{{ __('Upload PDF') }}" />
                        <x-input id="pdf" class="block mt-1 w-full" type="file" name="pdf" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Tambah') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
