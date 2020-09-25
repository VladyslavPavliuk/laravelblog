<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

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
//        $result = [];

        /**
         * @var Collection $eloquentCollection
         */
        $eloquentCollection = BlogPost::withTrashed()->get();
        /**
         * @var \Illuminate\Support\Collection $collection
         */
        $collection = collect($eloquentCollection->toArray());

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
        $collection->transform(function (array $item){
           $newItem = new stdClass();
           $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);
            return $newItem;
        });

        dd($collection);
    }
}
