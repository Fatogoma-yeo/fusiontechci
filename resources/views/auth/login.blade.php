<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col items-center justify-center select-none">
        <div class="flex flex-col bg-white px-4 sm:px-6 md:px-8 lg:px-10 rounded-xl shadow-2xl w-full max-w-md  border-l-4 border-cyan-900">
            <div class="font-medium self-center sm:text-2xl text-center">
                <img class="w-48 h-auto" src="{{ asset( 'svg/fusion_logo.svg' ) }}" alt="fusiontechci">
            </div>
            <div class="">
                <form method="POST" action="{{ route('login') }}" autocomplete="">
                    @csrf

                    <div class="relative w-full mb-3">
                        <input type="email" name="email" class="border-transparent p-3 placeholder-gray-400 text-gray-700 bg-white rounded text-md shadow focus:outline-none focus:ring w-full @error('email') border-red-500 @else is-valid @enderror" placeholder="{{ __('Email') }}" style="transition: all 0.15s ease 0s;" required />
                        @error('email')
                            <div class="text-red-500">{{ __('Invalid email or password.') }}</div>
                        @else
                            <small class="p-2 text-red-500">* {{ __('Email') }}</small>
                        @enderror
                    </div>
                    <div class="relative w-full mb-3">
                        <input type="password" name="password" class="border-transparent p-3 placeholder-gray-400 text-gray-700 bg-white rounded text-md shadow focus:outline-none focus:ring w-full" placeholder="{{ __('Password') }}" style="transition: all 0.15s ease 0s;" required />
                        <small class="p-2 text-red-500">* {{ __('Password') }}</small>
                    </div>
                    <div class="text-center mt-6 mb-6">
                        <button class="p-3 rounded-lg bg-cyan-900 outline-none text-white shadow w-32 justify-center focus:bg-gray-700 hover:bg-cyan-800">{{ __('Sign In') }}</button>
                    </div>
                    <div class="flex flex-wrap mt-6 hidden">
                        <div class="w-1/2 text-left">
                            <a href="{{ route('password.request') }}" class="text-blue-900 text-xl"><small>{{ __('Password Lost') }} </small></a>
                        </div>
                        <div class="w-1/2 text-right">
                            <a href="#" class="text-blue-900 text-xl"><small>{{ __('Sign In') }}</small></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
