<?php

use Illuminate\Support\Facades\Blade;

test('it renders table with basic headers and rows', function () {
    $html = Blade::render('<x-ui.table :headers="[\'ID\', \'Nama\']"><tr><td>1</td><td>Budi</td></tr></x-ui.table>');

    expect($html)
        ->toContain('ID')
        ->toContain('Nama')
        ->toContain('1')
        ->toContain('Budi')
        ->toContain('<table')
        ->toContain('border-collapse');
});

test('it supports structured headers with alignment and custom classes', function () {
    $headers = [
        ['label' => 'No', 'align' => 'center', 'width' => '60px'],
        ['label' => 'Nama Mahasiswa', 'align' => 'left'],
        ['label' => 'Aksi', 'align' => 'right', 'class' => 'custom-col'],
    ];

    $html = Blade::render('<x-ui.table :headers="$headers"><tr><td>1</td><td>Ahmad</td><td>Lihat</td></tr></x-ui.table>', [
        'headers' => $headers,
    ]);

    expect($html)
        ->toContain('text-center')
        ->toContain('text-right')
        ->toContain('custom-col')
        ->toContain('width: 60px;');
});

test('it renders custom header and footer slots', function () {
    $html = Blade::render('
        <x-ui.table>
            <x-slot:header>
                <tr><th>Custom Header</th></tr>
            </x-slot:header>
            <tr><td>Row 1</td></tr>
            <x-slot:footer>
                <span>Pagination Links</span>
            </x-slot:footer>
        </x-ui.table>
    ');

    expect($html)
        ->toContain('Custom Header')
        ->toContain('Row 1')
        ->toContain('Pagination Links');
});

test('it renders toolbar slot when provided', function () {
    $html = Blade::render('
        <x-ui.table :headers="[\'Nama\']">
            <x-slot:toolbar>
                <input placeholder="Cari..." />
            </x-slot:toolbar>
            <tr><td>Ahmad</td></tr>
        </x-ui.table>
    ');

    expect($html)
        ->toContain('placeholder="Cari..."')
        ->toContain('Ahmad');
});

test('it supports striped, hover, and size options', function () {
    $htmlSm = Blade::render('<x-ui.table size="sm" striped :hover="true" :headers="[\'Code\']"><tr><td>CD01</td></tr></x-ui.table>');
    $htmlLg = Blade::render('<x-ui.table size="lg" :striped="false" :hover="false" :headers="[\'Code\']"><tr><td>CD01</td></tr></x-ui.table>');

    expect($htmlSm)
        ->toContain('[&_td]:px-3.5')
        ->toContain('[&>tr:nth-child(even)]:bg-gray-50/50')
        ->toContain('hover:[&>tr]:bg-primary-subtle/20');

    expect($htmlLg)
        ->toContain('[&_td]:px-6');
});

test('it renders automatic empty state when slot is empty', function () {
    $html = Blade::render('<x-ui.table :headers="[\'ID\', \'Nama\']" emptyTitle="Data mahasiswa tidak ditemukan"></x-ui.table>');

    expect($html)
        ->toContain('Data mahasiswa tidak ditemukan')
        ->toContain('colspan="2"');
});

test('it renders subcomponents th, td, tr, empty properly', function () {
    $html = Blade::render('
        <x-ui.table>
            <x-slot:header>
                <tr>
                    <x-ui.table.th align="center" sortable sorted="asc">NIM</x-ui.table.th>
                    <x-ui.table.th>Nama</x-ui.table.th>
                </tr>
            </x-slot:header>
            <x-ui.table.tr active>
                <x-ui.table.td align="center">2201</x-ui.table.td>
                <x-ui.table.td>Siti</x-ui.table.td>
            </x-ui.table.tr>
        </x-ui.table>
    ');

    expect($html)
        ->toContain('NIM')
        ->toContain('Siti')
        ->toContain('text-center')
        ->toContain('bg-primary-subtle/30');
});

test('it renders subcomponent empty', function () {
    $html = Blade::render('
        <x-ui.table :headers="[\'A\', \'B\']">
            <x-ui.table.empty colspan="2" title="Belum ada data nilai" description="Silakan isi KRS terlebih dahulu" />
        </x-ui.table>
    ');

    expect($html)
        ->toContain('Belum ada data nilai')
        ->toContain('Silakan isi KRS terlebih dahulu');
});

test('ui showcase page renders successfully with new table component', function () {
    $response = $this->get(route('ui.showcase'));
    $response->assertOk();
    $response->assertSee('Data Table');
    $response->assertSee('Ahmad Fauzi');
    $response->assertSee('Tidak Ada Jadwal Kuliah Ditemukan');
});
