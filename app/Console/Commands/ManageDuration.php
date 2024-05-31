<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ManageDuration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:duration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $controller = app()->make('App\Http\Controllers\ManageScala');
        $update_duration = app()->call([$controller, 'update_player_duration']);
        // // Update Duratino of Master Playlist
        $update_duration = app()->call([$controller, 'update_master_duration']);
        // Sort Order By SIC
        $sort_playlist = app()->call([$controller, 'update_sort']);
    }
}
