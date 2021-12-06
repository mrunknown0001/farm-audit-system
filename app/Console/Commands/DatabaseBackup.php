<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Config;
use Carbon\Carbon;
use App\DatabaseBackup as DBBackup;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Full Database Backup';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    {
        // $filename = "backup-" . Carbon::now()->format('Y-m-d-h-i-s') . ".sql";
        $filename = "Online-Audit-Backup-" . Carbon::now()->format('Y-m-d-h-i-s') . ".gz";

        $dbhost = Config::get('values.dbhost');
        $dbname = Config::get('values.dbname');
        $rdbuser = Config::get('values.rdbuser'); // sql root username
        $rdbpass = Config::get('values.rdbpass'); // sql root password
        
        // $command = "sudo mysqldump -u " . $rdbuser ." -p" . $rdbpass . " " . $dbname . " > " . storage_path() . "/app/backup/" . $filename . " && sudo cp " . storage_path() . "/app/backup/" . $filename . " " . public_path() . "/bak/" . $filename;

        $command = "sudo mysqldump -u " . $rdbuser ." -p" . $rdbpass . " " . $dbname . " | gzip > " . storage_path() . "/app/backup/" . $filename . " && sudo cp " . storage_path() . "/app/backup/" . $filename . " " . public_path() . "/bak/" . $filename;


        $returnVar = NULL;
        $output  = NULL;
        if(PHP_OS_FAMILY == "Linux") {
            exec($command, $output, $returnVar);

            $db = new DBBackup();
            $db->filename = $filename;
            $db->url = public_path() . "/bak/" . $filename;
            $db->save();

            $this->info("Database " . $dbname . " Successfully Backed Up!");
        }
        else {
            $this->info("Database " . $dbname . " is Unable to Backup on this OS!");
        }
    }
    }
}
