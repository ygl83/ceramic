<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\GoodsManageService as Goods;
use App\Services\UploadService as Upload;

class GoodsManageController extends Controller
{
    protected $goods;
    protected $upload;

    public function __construct(Goods $goods, Upload $upload)
    {
        $this->goods = $goods;
        $this->upload = $upload;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goodsList = $this->goods->getGoodList();
        return view('admin.goods.index')
                ->with( 'goodsList',$goodsList );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$data = $this->dispatch(new PostFormFields());

        return view('admin.goods.create');        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //表单验证
        //$this->validateAdInfo($request);

        //图片保存到upload 
        $fileData = $this->upload->moveToUpload($request,'files');

        //新增商品信息        
        $uuid=$this->goods->addGoods($request,$fileData);

        //保存信息到数据库
        //$this->attachment->batchInsertByAdUuid($uuid,$fileData);

        return redirect('admin/goods_manage')
                        ->withSuccess('添加商品成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $goods = $this->goods->getGoods($id);
        $imgList = $this->goods->getImageList($goods->image_id);
        //旧输入数据
        $oldData = $request->old();
        if( $oldData )
        {
            foreach( $oldData as $key => $val )
            {
                if( isset($goods->$key) && $val != $goods->$key )
                {
                    $goods->$key = $val;
                }
            }

        }

        return view('admin.goods.create')
                    ->with('model',$goods)
                    ->with('imgList' ,$imgList);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //表单验证
        //$this->validateAdInfo($request);

        //图片保存到upload
        $fileData= $request->input('files')?$this->upload->moveToUpload($request,'files'): [];

        $this->goods->updateGoods($request,$fileData,$id);

        return redirect('admin/goods_manage')
                        ->withSuccess('修改商品成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->goods->deleteGoods($id);

        return redirect('admin/goods_manage')
                        ->withSuccess('删除成功');
    }

    /**
     * 处理异步数据
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {
        $data = $this->goods->anyData($request);
        die($data);
    }

}
