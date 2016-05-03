<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banner';

    /**
     * 获取图片
     */
    public function image()
    {
        return $this->hasOne('App\Image','id');
    }

}
