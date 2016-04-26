/**
 * 广告创建初始化脚本
 */
$.extend({
    /**
     * 确认删除提示信息 
     * 给标签添加属性 data-toggle='confirm_delete' 就带有这个技能
     * @title  {[string]}  [标题]
     * @OkLabel  {[string]}  [确认提示信息]
     * @CancelLabel  {[string]}  [取消提示信息]
     * @placement    {[string]}  [弹出位置]
     * @return {[type]} [确认则提交操作 ]
     */
    deleteConfirmation: function(title,OkLabel,CancelLabel,placement)
    {
        $('[data-toggle="confirm_delete"]').confirmation({
            title:title,
            btnOkLabel: OkLabel,
            btnCancelLabel: CancelLabel,
            placement: placement,
            container: 'body',
            popout: true
        });     
    },

})