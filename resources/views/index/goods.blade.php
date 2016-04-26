<html>
    <head>
        <title>{{ config('goods.title') }}</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>{{ config('goods.title') }}</h1>
            <h5>Page {{ $goodsList->currentPage() }} of {{ $goodsList->lastPage() }}</h5>
            <hr>
            <ul>
            @foreach ($goodsList as $goods)
                <li>
                    <div id="goods">
                        <div>
                            商品编号：{{$goods->goods_uuid}}
                        </div>

                        <div>
                            商品：{{$goods->name}}
                        </div>
                        <div>
                            库存：{{$goods->nums}}
                        </div>
                        <div>
                            描述：{{$goods->description}}
                        </div>
                        <div class="gd_images">
                            @if(isset($goods->imageFiles))
                                <div class="gd_image">
                                     @foreach($goods->imageFiles as $imageFile)
                                        <img src="index/upload/{{$imageFile}}" width="20%" height="20%"></img>
                                     @endforeach
                                </div>
                            @endif
                        </div>
                    <div>
                </li>
                <hr>
            @endforeach
            </ul>
            <hr>
            {!! $goodsList->render() !!}
        </div>
    </body>
</html>
