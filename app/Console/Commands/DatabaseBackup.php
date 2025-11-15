<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Spatie\DbDumper\Databases\MySql;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Creates a backup of the MySQL database.';

    public function handle() {
        $filename = "bazaar-buddy-backup-" . now()->format('Y-m-d_H-i-s') . ".sql";
        $path = storage_path('app/backups/' . $filename);
        
        try {
            MySql::create()
                ->setDbName(config('database.connections.mysql.database'))
                ->setUserName(config('database.connections.mysql.username'))
                ->setPassword(config('database.connections.mysql.password'))
                ->dumpToFile($path);
            
            $this->info("Database backup created successfully at: {$path}");
        } catch (\Exception $e) {
            $this->error("Database backup failed: " . $e->getMessage());
        }
    }
}