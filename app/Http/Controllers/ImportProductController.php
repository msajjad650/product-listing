<?php

namespace App\Http\Controllers;

use App\Jobs\ProductVariantJob;
use App\Jobs\ProductTypeJob;
use App\Jobs\ProductBrandJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Bus;
use App\Http\Traits\CommonHelperTrait;


class ImportProductController extends Controller
{
    use CommonHelperTrait;
    
    public function index()
    {
        // $content = Storage::get('example.txt');

        //Getting and parsing XML data
        $response = Http::get('https://kidsbrandstore.s3.eu-central-1.amazonaws.com/files/products/google_sv.xml');
        if($response->status() !== 200){
            return 'Error';
        }
        $content = $response->body();        
        $xmlObject = new \SimpleXmlElement($content);
        $productArr = $this->simpleXmlToArray($xmlObject->channel->item);
        
        //Dispatching job processes
        $batch  = Bus::batch([])->dispatch();

        //Loading products, product variants, types and brands
        $batch = $this->generateProductTypeBatch($productArr, $batch);
        $batch = $this->generateProductBrandBatch($productArr, $batch);
        $batch = $this->generateProductVariantBatch($productArr, $batch);

        dd($batch);
    }

    /**
     * @param $productArr
     * @param $batch
     * @return batch
     */
    private function generateProductTypeBatch($productArr, $batch)
    {
        $productTypes = $this->getUniqueValuesFromArray($productArr, 'product_type');
        
        if (count($productTypes) > 1000) {
            $chunks = array_chunk($productTypes, 1000);
            foreach ($chunks as $chunk) {
                $batch->add(new ProductTypeJob($chunk));
            }
        } else{
            $batch->add(new ProductTypeJob($productTypes));
        }
        return $batch;
    }

    /**
     * @param $productArr
     * @param $batch
     * @return batch
     */
    private function generateProductBrandBatch($productArr, $batch)
    {
        $productBrands = $this->getUniqueValuesFromArray($productArr, 'brand');
        
        if (count($productBrands) > 1000) {
            $chunks = array_chunk($productBrands, 1000);
            foreach ($chunks as $chunk) {
                $batch->add(new ProductBrandJob($chunk));
            }
        } else{          
            $batch->add(new ProductBrandJob($productBrands));
        }
        return $batch;
    }

    /**
     * @param $productArr
     * @param $batch
     * @return batch
     */
    private function generateProductVariantBatch($productArr, $batch)
    {    
        if (count($productArr) > 1000) {
            $chunks = array_chunk($productArr, 1000);
            foreach ($chunks as $chunk) {
                $batch->add(new ProductVariantJob($chunk));
            }
        } else {
            $batch->add(new ProductVariantJob($productArr));
        }    
        return $batch;
    }
    
    /**
     * @param $id
     * @return batch
     */
    public function batchProgress($id)
    {
        return Bus::findBatch($id);
    }
}
