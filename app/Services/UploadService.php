<?php 
namespace App\Services;

use Storage;
use Crypt;
use App\Image;

/**
* 图片上传类
*/
class UploadService 
{
    protected $err_message = '';
    protected $tmp_path = 'tmp_upload';
    protected $path = 'upload';

    function __construct()
    {
        # code...
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
        $fileNameArray = $request->input('files');
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
        $imageId = '';
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
                    
                    // 获取文件大小
                    $filesize=Storage::disk('tmp')->size($fileName);
                    //获取文件名
                    $image_uuid = substr($fileName,0,strpos($fileName,".")) ;
                    $extension = substr($fileName,strpos($fileName,".")+1,strlen($fileName));
                	
                	$imageTable = new \App\Image();
                	$imageTable->extention = $extension;
                	$imageTable->size = $filesize;
                	$imageTable->image_uuid = $image_uuid;
                	$imageTable->original_name = $originalName;
                	$insertSuccess = $imageTable->save();
					if($insertSuccess)
					{
						$insertId = $imageTable->id;
	                    $imageId[] = $insertId;
	                    //从临时文件夹移动到上传文件夹
	                    Storage::disk('index')->move($tmpFileName,$toFileName);
	                }
                }

            }
        }
        return $imageId; 
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
            $request->file('file')->move(public_path().'/index/'.$this->tmp_path, $fileName);

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
                return array('status'=>0,'data'=>'图片上传太大');
            }
            //$file->getError()
            return array('status'=>0,'data'=>'图片上传');
        }
        
    }
    public function getUploadPath()
    {
        return public_path().'/index/'.$this->tmp_path;
    }
   	//获取图片列表
	public function getImageList($arrayId = [])
    {
        return Image::find($arrayId);
    }

}
