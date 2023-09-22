<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 space-y-6">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <div class="py-4 flex justify-between">
                        <label for="title" class="font-bold my-2 text-primary text-white">
                            <h1 class="text-2xl font-bold">Créer un nouveau rôle</h1>
                            <h3>Créez un nouveau rôle et enregistrez-le.</h3>
                        </label>
                        <div for="title" class="text-sm my-2 text-primary">
                            <a href="{{ route('roles.index') }}" class="rounded-full border ns-inset-button error hover:bg-gray-200 hover:text-gray-900 text-white flex px-1 py-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="px-1">{{ __( 'Go Back' ) }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="bg-white rounded-md shadow-lg py-4 px-4 w-full">
                        <form method="POST" action="{{ route('roles.store') }}" id="createForm">
                            @csrf
                            <!-- Name -->
                            <div>
                                <div class="py-2">
                                    <x-input-label for="role" :value="__('Nom')" />
                                </div>

                                <x-text-input id="role" class="block mt-4 w-full" type="text" name="name" :value="old('role')" required autofocus />
                                <p class="py-1 text-xs">Fournir un nom au role</p>
                            </div>

                            <div class="flex justify-center font-bold underline text-lg"> Permissions </div>
                            <div class="overflow-x-auto">
                                @foreach($listes as $liste)
                                    <div class="flex">
                                        @foreach($liste as $list)
                                            <div class="flex-1">
                                                <div class="flex py-4 px-4">
                                                    <x-text-input class="w-6 h-6" type="checkbox" value="{{ $list->id }}" id="permission" name="permission[]" />
                                                    <span class="px-6"> {{$list->title}} </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex items-center justify-end mt-4">

                                <x-primary-button class="ml-4">
                                    {{ __('Register') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
