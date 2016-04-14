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
                    <a href="/goods/{{ $goods->slug }}">{{ $goods->name }}</a>
                    <em>({{ $goods->update_at }})</em>
                    <p>
                        {{ str_limit($goods->descprtion) }}
                    </p>
                </li>
            @endforeach
            </ul>
            <hr>
            {!! $goodsList->render() !!}
        </div>
    </body>
</html>
