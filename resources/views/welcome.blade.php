<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- <div class="min-h-screen flex flex-row sm:justify-center gap-14 items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg transform hover:scale-125 transition ease-out duration-300">
                <a href="{{ url('sale-login') }}" class="group" id="user">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-full mx-auto group-hover:stroke-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg transform hover:scale-125 transition ease-out duration-300">
                <a href="{{ url('login') }}" class="group" id="admin">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-full mx-auto group-hover:stroke-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
            </div>
        </div> -->
        <div class="h-full w-full flex">
            <div class="container flex-auto flex-col items-center justify-center flex m-4 sm:mx-auto">
                <div class="flex justify-center items-center py-6">
                    <img class="w-32" src="{{ asset( 'svg/fs.logo.svg' ) }}" alt="">
                </div>
                <div class="rounded shadow md:w-1/2 lg:w-1/3 overflow-hidden">
                    <div id="section-header" class="p-4">
                        <p class="text-center b-8 text-sm">{{ __( "If you see this page, this means NexoPOS 4.x is correctly installed on your system. As this page is meant to be the frontend, NexoPOS 4.x doesn't have a frontend for the meantime. This page shows useful links that will take you to the important resources." ) }}</p>
                    </div>
                    <div class="flex shadow border-t">
                        <div class="flex w-1/3"><a class="link text-sm w-full py-2 text-center" href="{{ route( 'dashboard' ) }}">{{ __( 'Dashboard' ) }}</a></div>
                        <div class="flex w-1/3"><a class="link text-sm w-full py-2 text-center" href="{{ route( 'login' ) }}">{{ __( 'Sign In' ) }}</a></div>
                        <div class="flex w-1/3"><a class="link text-sm w-full py-2 text-center" href="{{ route( 'register' ) }}">{{ __( 'Sign Up' ) }}</a></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
