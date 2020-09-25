<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;

    const ROOT = 1;

    protected $fillable
    =   [
            'title',
            'slug',
            'parent_id',
            'description',
        ];

    public function parentCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id' );
    }

    /**
     * @return string
     */

//    public function getParentTitleAttribute()
//    {
//        $title = $this->parentCategory()->title
//            ?? ($this->isRoot()
//            ? 'Core'
//                : '???');
//        return $title;
//    }


    public function isRoot(){
        return $this->id === BlogCategory::ROOT;
    }

    /**
     * @param string $valueFromDB*
     *
     * @return bool|mixed|null|string|string[]
     */
    public function getTitleAttribute($valueFromobject)
    {
        return mb_strtoupper($valueFromobject);
    }

    /**
     * @param string $incomingValue
     */

    public function setTitleAttributte(string $incomingValue)
    {
        $this->attributes['title'] = mb_strtolower($incomingValue);
    }
}
