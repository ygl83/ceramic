<?php

/**
*	AccountManageService层
*	
*	Created by 2015-12-23
*/

namespace App\Services;


use App\Goods as goods;

class GoodsService
{
    public function getGoodList()
    {
        return goods::all();
    }

}