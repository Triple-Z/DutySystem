<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\DailyCheckStatus;

class ListCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all the cache dates';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Cache dates:');
        $checkRecords = DailyCheckStatus::latest('date')->get();
        $lastDate = '1970-01-01';
        foreach ($checkRecords as $record) {
            if ($record->date == $lastDate) {
                continue;
            } else {
                $this->info('    ' . $record->date);
                $lastDate = $record->date;
            }
        }
    }
}
