   // 提示信息
  var noPreview = "请提交";
  var uploadFailed = "上传失败";

var setHeader = function(object, data, headers) {
    headers['Access-Control-Allow-Origin'] = '*';
    headers['Access-Control-Request-Headers'] = 'content-type';
    headers['Access-Control-Request-Method'] = 'POST';
}
uploader.on('uploadBeforeSend ', setHeader);

// 监听上传呈现缩略图
uploader.on( 'fileQueued', function( file ) {
    var $li = $(
            '<div id="' + file.id + '" class="file-item thumbnail new_file">' +
                '<img>' +
                '<div class="info">' + file.name + '</div>' +
                '<span class="glyphicon glyphicon-remove btn-remove"></span>'+
            '</div>'
            ),
        $img = $li.find('img');


    // $list为容器jQuery实例
    $('#fileList').append( $li );


    //图片上限提示
    //var count = $('#fileList').find('.thumbnail').length;
    //$('#img-count').text(count);

    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100
    uploader.makeThumb( file, function( error, src ) {
        if ( error || src == null ) {
            $img.replaceWith('<span>'+noPreview+'</span>');
            return;
        }

        $img.attr( 'src', src );
    }, 100, 100 );
});

// 移除文件
uploader.on( 'fileQueued', function( file ) {

    var newFile = $('#fileList').find('.new_file');
    newFile.children('.btn-remove').on('click', function()
    {
        var file_id = $(this).parent().attr('id');
        
        $('#fileList').find('#'+file_id).remove();
        uploader.removeFile( file );
    })
    
    var imgNumLimit = uploader.options.fileNumLimit,
        num = ($("#fileList").find('.thumbnail')).length;
    if ( num > imgNumLimit )
    {
        $('#'+file.id).remove();
        $('#imgCount').css("color","red");
        uploader.removeFile(file); 
    }   
})


// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#'+file.id ),
        $percent = $li.find('.progress span');

    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
    }

    $percent.css( 'width', percentage * 100 + '%' );
});

// 文件上传成功，给item添加成功class, 用样式标记上传成功。
uploader.on( 'uploadSuccess', function( file ) {
    $( '#'+file.id ).addClass('upload-state-done');
});

uploader.on( 'uploadAccept', function( file, response ) {
    if ( response.status=='1' ) {   
        //上传成功
        var $div = $( '#'+file.file.id );

        var hidden=$('<input type="hidden" name="files[]" value="'+response.data+'" >');
        $div.append(hidden);

        return true;

    }else {
        var $li = $( '#'+file.file.id ),
            $error = $li.find('div.error');
        // 避免重复创建
        if ( !$error.length )
        {
            $error = $('<div class="error"></div>').appendTo( $li );
            $error.text(response.data);

        }
        return false;
    }
});

// 文件上传失败，显示上传出错。
uploader.on( 'uploadError', function( file, code ) {
    var $li = $( '#'+file.id ),
        $error = $li.find('div.error');
    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error"></div>').appendTo( $li );
        $error.text(uploadFailed);
    }
     
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').remove();
});
/**
 * 广告创建初始化脚本
 */
$.extend({
    deleteFile: function()
    {
        $('[data-toggle="delete_image"]').bind('click', function()
        {
            var val = $(this).attr('data');
            $('#fileList').append('<input type="hidden" name="delete_image[]" value='+val+'>');
            $('div[data='+val+']').remove();
        })
    },
})

$.deleteFile();


