<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;

/**
 * Class BlogCategoryRepository.
 *
 * @package App\Repositories
 */

class BlogCategoryRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
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

    /**
     * Get category list for enter in fall out list
     *
     * @return Collection
     *
     */
    public function getForComboBox()
    {
        $columns = implode(', ',[
            'id',
            'CONCAT(id, ". ", title) AS title',
            ]);

        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;
    }

    /**
     * Get category for enter a paginate.
     *
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function getAllWithPaginate($perPage = null){

        $fields = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($fields)
            ->paginate($perPage);

        return $result;
    }

}
