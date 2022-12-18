<?php
namespace App\Http\Traits;

trait CommonHelperTrait {

    /**
     * @param array $productArr
     * @param string $column
     * @return array
     * return array of uniques values from array based on column name
     */
    public function getUniqueValuesFromArray($productArr, $column)
    {
        $columnValues = [];
        foreach ($productArr as $product) {
            $columnValues[] = $product[$column];
        }
        return array_unique($columnValues);
    }

    /**
     * @param array $chunk
     * @param string $column
     * @return array
     * return grouped array from array based on column name
     */
    public function getGroupedArray($chunk, $column)
    {
        $productGroups = array();
        foreach ($chunk as $prod) {
            $productGroups[$prod[$column]][] = $prod;
        }

        return $productGroups;
    }

    /**
     
     * @return array
     */
    /**
     * @param $xmlObject
     * @param object $gObj
     * @return array
     * convert xml to array
     */
    public function simpleXmlToArray($xmlObject, $gObj=[])
    {
        foreach ($xmlObject as $index => $node ){
            if(count($node) === 0){
                $out[$node->getName()] = $node->__toString ();

                if(count($gObj) > 0){
                    foreach ($gObj as $gValue) {
                        $out[$gValue->getName()] = $gValue->__toString(); 
                    }
                }            
                
            }else{
                $gObj = $node->children('g', true);
                $out[] = $this->simpleXmlToArray($node, $gObj);
            }
        }

        return $out;
    }
}