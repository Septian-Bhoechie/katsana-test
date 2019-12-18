<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateVehicleTrip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:vehicle-trip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate vehicle trip data from json file';

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
        //
    }
}
