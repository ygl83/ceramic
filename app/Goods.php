<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    /**
     * 获取图片id
     *
     * @param  string  $value
     * @return string
     */
    public function getImageIdAttribute($value)
    {
        if(!empty($value))
        {
			$value = explode(',', $value);
        }

        return $value;
    }

    /**
     * 设置id
     *
     * @param  string  $value
     * @return string
     */
    public function setImageIdAttribute($value)
    {
        if(is_array($value))
        {
			$value = implode(',', $value);
        }
        $this->attributes['image_id'] = $value;
    }



}
