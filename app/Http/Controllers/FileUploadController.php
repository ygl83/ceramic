<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Services\UploadService as Upload;

class FileUploadController extends Controller
{
    protected $upload;


    public function __construct(Upload $upload)
    {
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
    }
    public function upload(Request $request)
    {
        $this->validate_ajax($request);
        //上传到临时文件夹
        $data=$this->upload->uploadToTemp($request,'file');
        header('Access-Control-Allow-Origin: application/json');

       die (json_encode($data));
    }

    public function remove($fileName=null,$AdUuid=null)
    {
        $ad_attachment_uuid = substr($fileName,0,strpos($fileName,"."));
        //根据uuid 查询图片记录 
        $model=$this->attachment->getAttachmentByUuid($ad_attachment_uuid);

        //删除图片
        // if(isset($model))
        // { 
        //     if(Storage::disk('upload')->exists($fileName))
        //         $res=Storage::disk('upload')->delete($fileName);
        // }

        //删除记录
        $model->delete();

        return redirect('ad/'.$AdUuid.'/edit');
    }

    //验证输入文件
    protected function validate_ajax($request)
    {
        $validator = Validator::make($request->all(),[
            'file' =>'mimes:jpg,jpeg,png,gif',
        ]);

        if($validator->fails())
        {
            die(json_encode(['status' => 0,'data' =>$validator->messages()->first('file')]));
        }
    }
}