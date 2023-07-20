<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Console\Command;

class Services extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'colecting services';

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
        $data = Category::where('name', 'LIKE', '%service%')->get();
        foreach ($data as $service) {
            $s = new Service;
            $s->name = $service->name;
            $s->save();
        }
        return 0;
    }
}
