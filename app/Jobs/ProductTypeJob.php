<?php

namespace App\Jobs;

use App\Models\ProductType;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProductTypeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $productTypes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productTypes)
    {
        $this->productTypes = $productTypes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->productTypes as $productType) {
            ProductType::firstOrCreate([
                'name' => $productType
            ]);
        }
    }

    public function failed(Throwable $throwable)
    {
        // Send user notification of failure....
    }
}
