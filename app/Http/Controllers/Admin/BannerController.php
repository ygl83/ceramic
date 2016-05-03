<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\BannerService as banner;
use App\Services\UploadService as Upload;

class BannerController extends Controller
{
    protected $banner;
    protected $upload;

    public function __construct(Banner $banner, Upload $upload)
    {
        $this->banner = $banner;
        $this->upload = $upload;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bannerList = $this->banner->getBannerList();
        return view('admin.banner.index')
                ->with( 'bannerList',$bannerList );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');   
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
        $fileData = ($this->upload->moveToUpload($request,'files'));
        $fileData = $fileData[0]?$fileData[0]:"";
        //新增商品信息        
        $uuid=$this->banner->addBanner($request,$fileData);

        //保存信息到数据库
        //$this->attachment->batchInsertByAdUuid($uuid,$fileData);

        return redirect('admin/banner')
                        ->withSuccess('添加幻灯片成功');

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
        $banner = $this->banner->getBanner($id);
        $img = $this->upload->getImageList($banner->image_id);
        //旧输入数据
        $oldData = $request->old();
        if( $oldData )
        {
            foreach( $oldData as $key => $val )
            {
                if( isset($banner->$key) && $val != $banner->$key )
                {
                    $banner->$key = $val;
                }
            }

        }

        return view('admin.banner.create')
                    ->with('model',$banner)
                    ->with('img' ,$img);  

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

        $this->banner->updateBanner($request,$fileData,$id);

        return redirect('admin/banner')
                        ->withSuccess('修改幻灯片成功');
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
        $this->banner->deleteBanner($id);

        return redirect('admin/banner')
                        ->withSuccess('删除成功');
    }

}
