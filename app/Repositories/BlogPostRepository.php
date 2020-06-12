<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Class BlogPostRepository.
 *
 * @package App/Repsitories
 */
class BlogPostRepository extends CoreRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get posts list for show in list (Admin)
     *
     * @return LengthAwarePaginator
     */

    public function getAllWithPaginate(){
        $fields = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this->startConditions()
            ->select($fields)
            ->orderBy('id', 'DESC')
            ->with(['user:id,name'])
            ->paginate(25);

        return $result;
    }

    /**
     * Get Model for admin edit
     *
     * @param int $id
     *
     * @return Model
     *
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

}
