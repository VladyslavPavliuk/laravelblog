<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVideoJob;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Collection;


class DiggingDeeperController extends Controller
{
    /**
     * Basic Knowledge
     *
     * @url https://laravel.com/docs/8.x/eloquent-collections
     *
     * @url https://laravel.com/api/8.x/Illuminate/Database/Eloquent/Collection.html
     */

    public function collections()
    {

//        /**
//         * @var Collection $eloquentCollection
//         */
//        $eloquentCollection = BlogPost::withTrashed()->get();
//        /**
//         * @var \Illuminate\Support\Collection $collection
//         */
//        $collection = collect($eloquentCollection->toArray());

//        $result = [];

//        $result['first'] = $collection->first();
//        $result['last'] = $collection->last();

//        $result['where']['data'] = $collection
//            ->where('category_id', '=', 10)
//            ->values()
//            ->keyBy('id');
//
//        $result['where']['count'] = $result['where']['data']->count();
//        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
//        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();

//        $result['where_first'] = $collection
//            ->firstWhere('created_at', '>', '2020-01-17 01:35:11');

        // Like most other collection methods, map returns a new collection instance
        // it does not modify the collection it is called on.
//        $result['map']['all'] = $collection->map(function (array  $item) {
//            $newItem = new \stdClass();
//            $newItem->item_id = $item['id'];
//            $newItem->item_name = $item['title'];
//            $newItem->exists = is_null($item['deleted_at']);
//            return $newItem;
//        });

        // If you want to transform the original collection, use the transform method
//        $collection->transform(function (array $item) {
//            $newItem = new stdClass();
//            $newItem->item_id = $item['id'];
//            $newItem->item_name = $item['title'];
//            $newItem->exists = is_null($item['deleted_at']);
//            $newItem->created_at = Carbon::parse($item['created_at']);
//            return $newItem;
//        });

//        $newItem1 = new \StdClass();
//        $newItem1->id = 34;
//
//        $newItem2 = new \StdClass();
//        $newItem2->id = 35;
//
//        // Put element in thhend of collection
//        $newItemFirst = $collection->prepend($newItem1)->first();
//        $newItemLast = $collection->push($newItem2)->last();
//        $pulledItem = $collection->pull(1);

        // Filter instead of orWhere();
//        $filtred = $collection->filter(function ($item) {
//            $byDay = $item->created_at->isFriday();
//            $byDate = $item->created_at->day == 13;
//            $result = $byDate && $byDay;
//
//            return $result;
//        });
//        }
//    }
//        $sortSimpleCollection = collect([4, 23, 1, 32 , 7])->sort()->values();
//        $sortAscCollection = $collection->sortBy('created_at');
//        $sortDescCollection = $collection->sortByDesc('item_id');
//        dd(compact('sortSimpleCollection', 'sortAscCollection', 'sortDescCollection'));
    }

    public function processVideo()
    {
        ProcessVideoJob::dispatch()
            // Postpone the execution of the task from the moment it is placed in the queue
            // Does not affect the pause between attempts to complete the task.
        // ->delay(10)
            // ->onQueue('name_of_queue')
        ;
    }
    /**
     * php artisan queue:listen --queue=generate-catalog --tries=3 --delay=10
     */
    public function  prepareCatalog()
    {
        GenerateCatalogMainJob::dispatch();
    }
}
