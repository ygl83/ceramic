<?php

/**
*	AccountManageService层
*	
*	Created by 2015-12-23
*/

namespace App\Services;


use App\Banner as banner;
use App\Image as image;

class BannerService
{
	public function getBannerList()
    {
        return $bannerList = banner::with('image')->get();;
    }

    //获取单个商品信息
   	public function getBanner($id)
    {
        return banner::find($id);
    }


 //    //获取图片列表
	// public function getBannerImageList()
 //    {
 //        $bannerList = banner::with('image')->get();
 //        $imageList = [];
 //        if(!empty($bannerList))
 //        {
 //            foreach ($bannerList as $key => &$banner) 
 //            {
 //                $banner->imagefile = $banner->image;
 //            }
 //        }
 //        else
 //        {
 //            return $imageList;
 //        }
 //        if(!empty($imageArr)&&is_array($imageArr))
 //        {
 //            $imageListBak = [];
 //            foreach ($imageArr as $image)
 //            {
 //                $imageListBak[$image['id']] = $image['image_uuid'].'/'.$image['extention'];
 //            }
 //            foreach ($bannerList as $key => $value) 
 //            {
 //                $imageList[$key]['image'] = $imageListBak[$value['image_id']];
 //            }
 //        }
 //        return $imageList;
 //    }

    /**
     * [添加商品]
     * 
     * @param [\Illuminate\Http\Request] $request [请求]
     * @return [string] [返回新增的uuid]
     */
    public function addBanner($request, $image_id = 1)
    {
        $model = new Banner();
        $model->content = $request->input('content');
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
    public function updateBanner($request,$fileData = [],$id = null)
    {
    	if(!isset($id))return false;
        $model = Banner::find($id);
        $deleteImageArr = $request->input('delete_image');
        $image_id = !$model->image_id?'':$model->image_id;
      //   if($deleteImageArr)
    		// $image_id = array_diff($image_id, $deleteImageArr);
    	if(!empty($fileData[0]))
        $image_id = $fileData[0];
        $model->content = $request->input('content');
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
    public static function deleteBanner($id)
    {

        $banner =  Banner::find($id);
        
        $banner->delete();

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