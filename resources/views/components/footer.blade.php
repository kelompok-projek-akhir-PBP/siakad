<footer {{ $attributes->merge(['class' => 'relative bg-white dark:bg-gray-900 border-t border-gray-200/80 dark:border-gray-800 px-4 sm:px-6 py-3.5 flex flex-col sm:flex-row items-center justify-center text-xs text-gray-500 dark:text-gray-400 select-none transition-colors duration-200 shrink-0']) }}>
    <p class="text-center">
        &copy; {{ date('Y') }} <span class="font-semibold text-gray-800 dark:text-gray-200">SIAKAD</span>. Hak Cipta Dilindungi.
    </p>

    <span class="sm:absolute sm:right-6 text-[11px] font-mono text-gray-400 dark:text-gray-500 mt-1 sm:mt-0">
        v1.0.0
    </span>
</footer>
