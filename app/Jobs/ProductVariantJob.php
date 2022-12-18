<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductType;
use App\Models\ProductVariant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Traits\CommonHelperTrait;
use Throwable;

class ProductVariantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable, CommonHelperTrait;

    protected $chunk;
    protected $productTypes;
    protected $productBrands;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $productGroups = $this->getGroupedArray($this->chunk, 'item_group_id');
        $this->productTypes = ProductType::pluck('id', 'name')->toArray();
        $this->productBrands = ProductBrand::pluck('id', 'name')->toArray();
        
        $productArr = [];
        $productVarientArr = [];
        foreach ($productGroups as $productGroup) {
            $productArr[] = [
                'id' => $productGroup[0]['item_group_id'],
                'product_brand_id' => $this->productBrands[$productGroup[0]['brand']],
                'product_type_id' => $this->productTypes[$productGroup[0]['product_type']],
                'title' => $this->getProductTitle($productGroup[0]['title']),
                'image_link' => $productGroup[0]['image_link'],
                'price' => $productGroup[0]['price']
            ];

            foreach ($productGroup as $productVariant) {
                $productVarientArr[] = [
                    'id' => $productVariant['id'],
                    'product_id' => $productVariant['item_group_id'],
                    'age_group' => $productVariant['age_group'],
                    'gender' => $productVariant['gender'],
                    'color' => $productVariant['color'],
                    'size' => $productVariant['size'],
                    'description' => $productVariant['description']
                ];
            }
        } 
        $this->updateProducts($productArr);
        $this->updateProductVariants($productVarientArr);
    }

    private function updateProducts($productArr)
    {
        Product::upsert(
            $productArr,
            ['id'],
            [
                'product_brand_id',
                'product_type_id',
                'title',
                'image_link',
                'price'
            ]
        );
    }

    private function updateProductVariants($productVarientArr)
    {
        ProductVariant::upsert(
            $productVarientArr,
            ['id'],
            [
                'product_id',
                'age_group',
                'gender',
                'color',
                'size',
                'description'
            ]
        ); 
    }

    /**
     * @param $title
     * @return string
     */
    private function getProductTitle($title)
    {
        $titleArr = explode(',', $title);
        return $titleArr[1];
    }

    public function failed(Throwable $throwable)
    {
        // Send user notification of failure....
    }
}
