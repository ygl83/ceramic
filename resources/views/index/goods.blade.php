<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('goods.title') }}</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>{{ config('goods.title') }}</h1>

<!--              <div id="example3">
                <h2></h2>
                <ul class="kiss-slider" >
                    @foreach($imageList as $image)
                        <li>
                            <img src="index/upload/{{$image->image->image_uuid.'.'.$image->image->extention}}">
                            </img>
                        </li>
                    @endforeach
                </ul>
                <ul class="kiss-pagination text-center"></ul>
                <p class="text-center btn-actions">
                    <button type="button" data-target="0">To slide 0!</button>
                    <button type="button" data-target="1">To slide 3!</button>
                    <button type="button" data-target="2">To slide 4!</button>
                    <button type="button" data-target="3">To slide 4!</button>
                    <button type="button" data-target="4">To slide 4!</button>
                </p>
            </div>
 -->
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
        <script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="/assets/js/goods/jquery.kiss-slider.min.js"></script>
        <script>
            $(window).load(function() {
                $('#example3 .kiss-slider').kissSlider({
                    prevSelector: '#example3 .previous',
                    nextSelector: '#example3 .next'
                });
                $('#example3 .btn-actions button').click(function() {
                    $('#example3 .kiss-slider').kissSlider('moveTo', {index:$(this).data('target')});
                })
            });
        </script>
    </body>
</html>
