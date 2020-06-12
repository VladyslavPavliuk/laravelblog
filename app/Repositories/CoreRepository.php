<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepository.
 *
 * @package App\Repositories
 *
 * Repository for work with essence.
 * May give data-group.
 * Can't create/edit essence.
 */
abstract class CoreRepository
{
    /**
     * @var Model
     *
     */
    protected $model;
    /**
     * CoreRepository constructor.
     *
     */

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();
    /**
     * @return Model|\Illuminate\Foundation\Application|mixed
     */
    protected function startConditions()
    {
        return clone $this->model;
    }

}
