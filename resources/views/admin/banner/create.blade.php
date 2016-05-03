@extends('admin.layout')

@section('styles')
    <link href="/assets/pickadate/themes/default.css" rel="stylesheet">
    <link href="/assets/pickadate/themes/default.date.css" rel="stylesheet">
    <link href="/assets/pickadate/themes/default.time.css" rel="stylesheet">
    <link href="/assets/selectize/css/selectize.css" rel="stylesheet">
    <link href="/assets/selectize/css/selectize.bootstrap3.css" rel="stylesheet">
@stop

@section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3>幻灯片 <small>» 添加幻灯片</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">表格</h3>
                </div>
                <div class="panel-body">

                    @include('admin.partials.errors')
                    @if ( isset($model->id) )
                    <form action="{{  url('admin/banner/'.$model->id) }}" class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    @else 
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.banner.store') }}">
                    @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="content" class="col-md-2 control-label">
                                    幻灯片内容
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="content" id="content" value="{{ $model->content or old('content') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                  <label for="upload_img" class="control-label col-sm-3">
                                  上传图片<br>
                                  (gif|jpeg|png|jpg)<br>
                                  <span  id="imgCount">
                                    最多1张                                  
                                  </span>
                                  <br/>
                                  最大2M
                                  </label>
                                  <div class="col-sm-6 col-xs-10" id="upload_container">
                                    <div id="uploader" class="uploader">
                                      <!--用来存放文件信息-->
                                      <div id="fileList" class="uploader-list">
                                          @if ( isset($img) )
                                              <div class="file-item thumbnail " data="{{$img['id']}}">
                                                <img src="{{ asset('index/upload').'/'.$img['image_uuid'].'.'.$img['extention'] }}">
                                                <div class="info">{{ $img['original_name'] }}</div>
                                                <a class="glyphicon glyphicon-remove btn-remove" data="{{$img['id']}}" data-toggle="delete_image"></a>
                                              </div>      
                                          @endif
                                      </div>
                                      <div id="filePicker" >
                                        请选择文件
                                      </div>
                                    </div>
                                  </div>
                            
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-md-2 control-label">
                                    排序
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="order" id="order" value="{{ $model->order or old('order') }}">
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fa fa-disk-o"></i>
                                        保存
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
<script src="/assets/pickadate/picker.js"></script>
<script src="/assets/pickadate/picker.date.js"></script>
<script src="/assets/pickadate/picker.time.js"></script>
<script src="/assets/selectize/selectize.min.js"></script>
  {{-- start file upload --}}
  <link href="//cdn.bootcss.com/webuploader/0.1.1/webuploader.css" rel="stylesheet">
  <script type="text/javascript" src="//cdn.bootcss.com/webuploader/0.1.1/webuploader.min.js"></script>
  {{-- end file upload --}}
<script>
  // 初始化上传
  var uploader = WebUploader.create({

      // 选完文件后，是否自动上传。
      auto: true,
      swf: 'http://cdn.bootcss.com/webuploader/0.1.1/Uploader.swf',
      // 文件接收服务端。
      server: '{{ url('goods/upload') }}',
      sendAsBinary: false,
      pick: '#filePicker',
      method: 'post',
      resize: false,
      // runtimeOrder: 'flash',
      fileNumLimit: 1,
      compress: null,
      duplicate: true,
      // fileSizeLimit: 2097152,
      // fileSingleSizeLimit: 2097152,
      accept: {
          title: 'Images',
          extensions: 'gif,jpg,jpeg,bmp,png',
          mimeTypes: 'image/*'
      },
      formData: {
          '_token': {!! '"'.csrf_token().'"' !!}
      }
  });
</script>
<script src="/assets/js/upload.js"></script>
@stop