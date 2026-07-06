<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'backup:db {--keep=14 : Jumlah file backup terakhir yang disimpan}';

    protected $description = 'Backup database ke storage/app/backups (SQLite: copy file, MySQL: mysqldump)';

    public function handle(): int
    {
        $dir = storage_path('app/backups');
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        $conn = (string) config('database.default');
        $stamp = date('Ymd-His');

        if ($conn === 'sqlite') {
            $db = (string) config('database.connections.sqlite.database');
            if (!is_file($db)) {
                $this->error('File SQLite tidak ditemukan: ' . $db);
                return self::FAILURE;
            }
            $dest = $dir . '/db-' . $stamp . '.sqlite';
            if (!@copy($db, $dest)) {
                $this->error('Gagal menyalin file SQLite.');
                return self::FAILURE;
            }
            $this->info('Backup SQLite dibuat: ' . $dest);
        } else {
            $c = (array) config('database.connections.' . $conn);
            $dest = $dir . '/db-' . $stamp . '.sql';

            // Password lewat env MYSQL_PWD agar tidak tampil di daftar proses.
            if (!empty($c['password'])) {
                putenv('MYSQL_PWD=' . $c['password']);
            }
            $cmd = sprintf(
                'mysqldump --host=%s --port=%s --user=%s %s > %s 2>&1',
                escapeshellarg((string) ($c['host'] ?? '127.0.0.1')),
                escapeshellarg((string) ($c['port'] ?? '3306')),
                escapeshellarg((string) ($c['username'] ?? 'root')),
                escapeshellarg((string) ($c['database'] ?? '')),
                escapeshellarg($dest)
            );
            $output = [];
            $code = 0;
            exec($cmd, $output, $code);
            putenv('MYSQL_PWD');
            if ($code !== 0) {
                $this->error('mysqldump gagal: ' . implode("\n", $output));
                return self::FAILURE;
            }
            $this->info('Backup MySQL dibuat: ' . $dest);
        }

        // Rotasi: simpan hanya N file terbaru.
        $keep = max(1, (int) $this->option('keep'));
        $files = glob($dir . '/db-*') ?: [];
        usort($files, fn ($a, $b) => filemtime($b) <=> filemtime($a));
        foreach (array_slice($files, $keep) as $old) {
            @unlink($old);
        }

        $this->info('Selesai. Total backup tersimpan: ' . min(count($files), $keep));
        return self::SUCCESS;
    }
}
