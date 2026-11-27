@props([
    'headers' => [],
    'striped' => false,
])

<div {{ $attributes->merge(['class' => 'w-full overflow-hidden rounded-xl border border-gray-200/80 bg-white shadow-2xs']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            @if (!empty($headers))
                <thead class="bg-gray-50/80 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-secondary">
                    <tr>
                        @foreach ($headers as $header)
                            <th scope="col" class="px-5 py-3.5 text-center">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-gray-100 {{ $striped ? '[&>tr:nth-child(even)]:bg-gray-50/40' : '' }}">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
