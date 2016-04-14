<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Crypt;
use Storage;

class FileUploadController extends Controller
{
    protected $upload;
    protected $err_message = '';
    protected $tmp_path = 'tmp_upload';
    protected $path = 'upload';


    // public function __construct(Upload $upload)
    // {
    //     $this->upload = $upload;
    // }
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
        $data=$this->uploadToTemp($request,'file');
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

        /**
     * [getFileData 将图片从临时文件夹保存到upload文件夹
     *       并且返回文件信息二维数组 用于记录数据库]
     *       
     * @param  [type] $request [请求]
     * @param  [type] $name    [表单提交的name[]]
     * @return [array]         [返回临时文件图片信息数组]
     */
    public function moveToUpload($request,$name )
    {
        $fileNameArray = $this->getPostFileName($request,$name);
        $fileData = $this->moveToUploadFromTmp($fileNameArray);
        
        return $fileData;
    }

    /**
     * [getPostFileName 获取post中的文件名数组]
     * @param  [type] $request [请求]
     * @param  [type] $name    [表单提交名称]
     * @return [array]         [文件名集合]
     */
    public function getPostFileName($request,$name)
    {
        return $request->input($name);
    }

    /**
     * [getFileList 根据文件名返回文件详细信息列表]
     * @param  [Request] $request     [请求]
     * @param  [array] $fileNameArray [文件名数组]
     * @return [array]                [详细信息数组]
     */
    protected function moveToUploadFromTmp($fileDataArray)
    {
        $fileData = [];

        if(count($fileDataArray)>0)
        { 
            foreach ($fileDataArray as $file) 
            {   
                $info = json_decode( Crypt::decrypt($file) );
                $fileName = $info->fileName;
                $originalName = $info->originalName;  
                
                //遍历提交的文件名 从临时文件读取文件信息 保存到数组中
                if (Storage::disk('tmp')->exists($fileName))
                {

                    $tmpFileName=$this->tmp_path.'/'.$fileName;
                    $toFileName=$this->path.'/'.$fileName;          
                    
                    //从临时文件夹移动到上传文件夹
                    Storage::disk('index')->move($tmpFileName,$toFileName);

                    // 获取文件大小
                    $filesize=Storage::disk('upload')->size($fileName);
                    //获取文件名
                    $ad_attachment_uuid = substr($fileName,0,strpos($fileName,".")) ;
                    $extension = substr($fileName,strpos($fileName,".")+1,strlen($fileName));
                
                    $fileData[] = array(
                            'ad_attachment_uuid' => $ad_attachment_uuid ,
                            'size'               => $filesize,
                            'original_name'       => $originalName,
                            'extention'          => $extension
                    );     
                }

            }
        }
        return $fileData; 
    }
    /**
     * [uploadToTemp 单文件上传到临时文件夹]
     * @param  [type] $request [请求]
     * @param  [type] $name    [表单提交的name]
     * @return [type]          [返回结果数组]
     */
    public function uploadToTemp($request,$name)
    {
        $file = $request->file($name);
        if ( $file->isValid() )
        {   
            $extension = $file->getClientOriginalExtension();
            $originalName = $file->getClientOriginalName();
            //$size = $file->getClientSize();
            $fileName = time().'.'.$extension;
            $request->file('file')->move(public_path().'/'.$this->tmp_path, $fileName);

            return array(
                'status'=>1,
                'data'=>Crypt::encrypt(json_encode(
                        [
                            'fileName'=>$fileName,
                            'originalName'=>$originalName
                        ])
                )
            );
        }else{
            if( $file->getError() == 1 )
            {
                return array('status'=>0,'data'=>'文件太大');
            }
            //$file->getError()
            return array('status'=>0,'data'=>'文件上传失败');
        }
        
    }
    public function getUploadPath()
    {
        return public_path().'/index/'.$this->tmp_path;
    }
}