<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-2 py-2 bg-gray-100 transition-shadow rounded-full border shadow-sm font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-200 hover:shadow-lg']) }}>
    {{ $slot }}
</button>
