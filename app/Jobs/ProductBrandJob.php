<?php

namespace App\Jobs;

use App\Models\ProductBrand;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProductBrandJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $productBrands;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productBrands)
    {
        $this->productBrands = $productBrands;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->productBrands as $productBrand) {
            ProductBrand::firstOrCreate([
                'name' => $productBrand
            ]);
        }
    }

    public function failed(Throwable $throwable)
    {
        // Send user notification of failure....
    }
}
