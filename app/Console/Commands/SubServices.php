<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubService;
use Illuminate\Console\Command;

class SubServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:subservices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'filtering services from products table and saving in subservices table.';

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
        $categories = Category::where('name', 'LIKE', '%service%')->get();
        $ids = $categories->pluck('id')->toArray();

        $services = Product::whereIn('category_id', $ids)->get();

        foreach ($services as $service) {
            $categoryName = Category::where('id', $service->category_id)->first()->name;
            $serviceId = Service::where('name', $categoryName)->first()->id;

            $subService = new SubService;
            $subService->name = $service->name;
            $subService->price = $service->price;
            $subService->service_id = $serviceId;
            $subService->save();
        }
        return 0;
    }
}
