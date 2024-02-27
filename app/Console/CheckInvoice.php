<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Invoice Status';

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
