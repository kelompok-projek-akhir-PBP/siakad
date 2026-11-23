<?php

namespace Database\Seeders;

use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

abstract class DummySeeder extends Seeder
{
    protected function insertChunked(string $table, array $rows, int $size = 50): void
    {
        foreach (array_chunk($rows, $size) as $chunk) {
            $this->insertWithRetry($table, $chunk);
        }
    }

    private function insertWithRetry(string $table, array $chunk): void
    {
        $maxAttempts = 4;
        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                if ($attempt === 1) {
                    DB::table($table)->insert($chunk);
                } else {
                    DB::table($table)->insertOrIgnore($chunk);
                }

                return;
            } catch (QueryException $e) {
                $lostConnection = str_contains($e->getMessage(), 'server has gone away')
                    || str_contains($e->getMessage(), 'Lost connection');

                if (! $lostConnection || $attempt === $maxAttempts) {
                    throw $e;
                }

                $this->command?->warn("Koneksi putus saat mengisi {$table}, mencoba lagi ({$attempt}/".($maxAttempts - 1).')...');
                sleep(2);
                DB::reconnect();
            }
        }
    }
}