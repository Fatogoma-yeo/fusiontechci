<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 space-y-6">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <div class="py-4 flex justify-between">
                        <label for="title" class="font-bold my-2 text-primary text-white">
                            <h1 class="text-2xl font-bold">Modifier un Utilisateur</h1>
                            <h3>Modifier l'utilisateur.</h3>
                        </label>
                        <div for="title" class="text-sm my-2 text-primary">
                            <a href="{{ route('users.index') }}" class="rounded-full border ns-inset-button error hover:bg-gray-200 hover:text-gray-900 text-white  px-1 py-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __( 'Retour' ) }}
                            </a>
                        </div>
                    </div>
                    <div class="bg-white rounded-md shadow-lg py-2 px-4 w-full">
                        <form method="POST" action="{{ route('users.update', $user->id) }}" id="editForm">
                            @method('PUT')
                            @csrf

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />

                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" required autofocus />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />

                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" required />
                            </div>

                            <!-- Role -->
                            <div class="mt-4">
                                <x-input-label for="role" :value="__('Role')" />

                                <!-- <x-text-input id="role" class="block mt-1 w-full" type="text" name="role" :value="$user->role" required autofocus /> -->
                                <select name="roles" id="role" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-md" required>
                                    @foreach($userRole as $user)
                                        <option value="{{ $user }}">{{ $user }}</option>
                                    @endforeach
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" name="roles">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block mt-1 w-full"
                                                type="password"
                                                name="password"
                                                required autocomplete="new-password" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                name="confirm-password" required />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Update') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
