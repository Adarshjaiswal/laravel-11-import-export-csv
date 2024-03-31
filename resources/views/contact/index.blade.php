<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers List') }}
        </h2> 
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Import Customer') }}
                            </h2>
                        </header>
                          <!-- Display error messages -->
                          @if(session('errors'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                @foreach(session('errors') as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <!-- Display success message -->
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif
                        <form action="{{ route('import.customers') }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="csv" :value="__('CSV FILE IN GIVEN SAMPLE FORMAT')" />
                                <x-text-input id="csv" name="csv" type="file" class="mt-1 block w-full" required autofocus />
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Upload') }}</x-primary-button>
                                <a href="{{ asset('SampleCSVFile.csv') }}" class="text-blue-500 hover:text-blue-700 underline">  {{ __('Download sample file') }}</a>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>