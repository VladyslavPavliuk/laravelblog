<?php

namespace App\Jobs\GenerateCatalog;


class GenerateCatalogMainJob extends AbstractJob
{
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     */
    public function handle()
    {
        $this->debug('start');
        // Start caching from products
        GenerateCatalogCacheJob::dispatchNow();
        //Then creating chain of tasks for creating files with prices
        $chainPrices = $this->getChainPrices();
        // Main subtasks
        $chainMain = [
            new GenerateCategoriesJob(),
            new GenerateDeliveriesJob(),
            new GeneratePointsJob(),
        ];
        //Subtasks which must do last
        $chainLast = [
            // Archive a files and transfer them in the public directory
            new ArchiveUploadsJob(),
            // Send message to third party service about possibility to download new file from catalog
            new SendPriceRequestJob(),
        ];
        $chain = array_merge($chainPrices,$chainMain ,$chainLast);

        GenerateGoodsFileJob::withChain($chain)->dispatch();
        $this->debug('finish');
    }

    /**
     * @return array
     */
    private function getChainPrices()
    {
        $result = [];
        $products = collect([1,2,3,4,5]);
        $fileNum = 1;

        foreach ($products->chunk(1) as $chunk) {
            $result[] = new GeneratePricesFileChunkJob($chunk, $fileNum);
            $fileNum++;
        }
        return $result;
    }
}
