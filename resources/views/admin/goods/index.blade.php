@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-6">
            <h3>商品管理 <small>» 商品列表</small></h3>
        </div>
        <div class="col-md-6 text-right">
            <a href="/admin/goods_manage/create" class="btn btn-success btn-md">
                <i class="fa fa-plus-circle"></i> 添加商品
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            @include('admin.partials.errors')
            @include('admin.partials.success')

            <table id="goodsList-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>商品编号</th>
                    <th>商品名称</th>
                    <th>库存</th>
                    <th>描述</th>
                    <th>排序</th>
                    <th>操作</th>
                                    </tr>
            </thead>
            <tbody>
            @foreach ($goodsList as $goods)
                <tr>
                    <td>{{ $goods->goods_uuid }}</td>
                    <td>{{ $goods->name }}</td>
                    <td>{{ $goods->nums }}</td>
                    <td>{{ $goods->description }}</td>
                    <td>{{ $goods->order }}</td>
                    <td>
                        <a href="/admin/goods_manage/{{ $goods->id }}/edit" class="btn btn-xs btn-info">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a role="button" class="btn btn-xs btn-danger" data-toggle="confirm_delete" data-href="goods_manage/delete/{{ $goods->id }}" data-original-title="" title="">删除 
                        </a>                        
                    </td>
               
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>

</div>
@stop

@section('scripts')
  {{-- confirmation --}}
  <script src="//cdn.bootcss.com/bootstrap-confirmation/1.0.3/bootstrap-confirmation.js"></script>
  {{-- confirmation --}}
<script>
    $(function() {
        $("#goodsList-table").DataTable({
            order: [[0, "desc"]],
        });
    });
        //确认删除提示框
        var title = '是否删除';
        var okLabel = '确定';
        var cancelLabel = '取消';
        var positon = 'bottom';
$.deleteConfirmation(title,okLabel,cancelLabel,positon);
</script>
@stop