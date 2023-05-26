<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class BarCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'barcode:generate';

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
     * @return int
     */
    public function handle()
    {
        $products = Product::all();
        $start = 5010000000000;

        foreach ($products as $key => $product) {
            $autoincrement = $start + $key + 1;
            $product->code = strval($autoincrement);
            $product->Type_barcode = 'CODE128';
            $product->save();
        }

        return 'Success';
    }
}
