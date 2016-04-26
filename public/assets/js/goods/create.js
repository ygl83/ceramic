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
