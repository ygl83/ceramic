<?php

/**
*	AccountManageService层
*	
*	Created by 2015-12-23
*/

namespace App\Services;


use App\Goods as goods;
use App\Image as image;

class GoodsService
{
    public function getGoodList()
    {
    	$goodsList = Goods::orderBy('created_at', 'desc')->paginate(10);
    	foreach($goodsList as $keys => $goods)
    	{
    		if($goods->image_id)
    		{
    			$goods->imageFiles = [];
    			$imageFile = [];
    			foreach ($goods->image_id as $key => $id)
    			{
    				$image = Image::find($id);
    				$imageFile[] = $image->image_uuid.'.'.$image->extention;
    			}
    			$goods->imageFiles = $imageFile;
    		}
    	}
        return $goodsList;
    }
}