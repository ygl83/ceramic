<?php

/**
*	AccountManageService层
*	
*	Created by 2015-12-23
*/

namespace App\Services;


use App\Goods as goods;
use App\Image as image;
use Datatables;

class GoodsManageService
{
	public function getGoodList()
    {
        return goods::all();
    }

    //获取单个商品信息
   	public function getGoods($id)
    {
        return goods::find($id);
    }


    //获取图片列表
	public function getImageList($arrayId = [])
    {
        return image::find($arrayId);
    }

    /**
     * [添加商品]
     * 
     * @param [\Illuminate\Http\Request] $request [请求]
     * @return [string] [返回新增的uuid]
     */
    public function addGoods($request, $image_id = [])
    {
        $model = new Goods();
        $model->goods_uuid = $request->input('goods_uuid');
        $model->description = $request->input('description');
        $model->name = $request->input('name');
        $model->nums = $request->input('nums');
        $model->image_id = $image_id;
        $model->order = $request->input('order');
        try {

            $model->save();

            return true;

        } catch (Exception $e) {
            //错误处理
            return null;
        }
        return null;
    }

    /**
     * [添加商品]
     * 
     * @param [\Illuminate\Http\Request] $request [请求]
     * @return [string] [返回新增的uuid]
     */
    public function updateGoods($request,$fileData=[],$id = null)
    {
    	if(!isset($id))return false;
        $model = Goods::find($id);
        $deleteImageArr = $request->input('delete_image');
        $image_id = $model->image_id;
        if($deleteImageArr)
    		$image_id = array_diff($image_id, $deleteImageArr);
    	if($fileData)
    		$image_id += $fileData;
    	if(count($image_id)>5)
    	{
    		return false;
    	}
        $model->goods_uuid = $request->input('goods_uuid');
        $model->description = $request->input('description');
        $model->name = $request->input('name');
        $model->nums = $request->input('nums');
        $model->image_id = $image_id;
        $model->order = $request->input('order');
        try {

            $model->save();

            return true;

        } catch (Exception $e) {
            //错误处理
            return null;
        }
        return null;
    }

   /**
    * [ 根据id删除商品]
    * 
    * @param  [type] $uuid [uuid]
    * @return [bool]       [成功返回true]
    */
    public static function deleteGoods($id)
    {
        $ad =  Goods::find($id);
        
        $ad->delete();

    	return true;
    }

   /**
	* Process datatables ajax request.
	*
	* @return \Illuminate\Http\JsonResponse
	*/
	public function anyData()
	{
	     return Datatables::collection(goods::all())->make(true);
	}

}