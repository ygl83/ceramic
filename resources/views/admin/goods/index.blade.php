@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-6">
            <h3>goodsList <small>» Listing</small></h3>
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
                    <th>图片</th>
                    <th>添加时间</th>
                    <th>更改时间</th>
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
                        <a href="/blog/{{ $goods->image_id }}" class="btn btn-xs btn-warning">
                            <i class="fa fa-eye"></i> View
                        </a>
                    </td>
                    <td data-order="{{ $goods->created_at->timestamp }}">
                        {{ $goods->created_at->format('Y-m-d H:i:s') }}
                    </td>
                    <td data-order="{{ $goods->updated_at->timestamp }}">
                        {{ $goods->updated_at->format('Y-m-d H:i:s') }}
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
<script>
    $(function() {
        $("#goodsList-table").DataTable({
            order: [[0, "desc"]]
        });
    });
</script>
@stop