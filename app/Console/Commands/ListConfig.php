<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TimeNode;
use Carbon\Carbon;

class ListConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all the important config';

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

        $this->info('TimeNodes settings:');
        $timenodes = TimeNode::all();
        foreach ($timenodes as $timenode) {
            $name = $timenode->name;
            $time = Carbon::create(null, null, null, $timenode->hour, $timenode->minute, $timenode->second);
            $timeString = $time->toTimeString();
            $day = $timenode->day;
            if ($day) {
                $this->info('    ' . $name . ' +' . $day . 'Day(s) ' . $timeString);
            } else {
                $this->info('    ' . $name . ' ' . $timeString);
            }
        }
    }
}
