<?php

/**
*	AccountManageService层
*	
*	Created by 2015-12-23
*/

namespace App\Services;

class BasicService
{
    //数据模型
    protected $model = "Users";

    //获取列表所有数据
    public function getList()
    {
    	$modelList = goods::all();
        return $modelList;
    }
}