@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3 p-0">
                <div class="container">
                    <div class="row">
                        <div class="col-md px-0 d-flex align-items-center mb-3">
                            <div class="pr-4 ml-5">
                            <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$user->profile_image) }}" class="rounded-circle" width="100" height="100">
                            </div>
                            <div class="mt-3 d-flex flex-column">
                                <h3 class="mb-0 py-1 font-weight-bold">{{ $user->name }}</h3>
                                <span class="text-secondary">ユーザーID : {{ $user->id }}</span>
                                <div class="d-flex flex-column justify-content-between">
                                    <div class="d-flex">
                                        @if($user->id === Auth::user()->id)
                                            <div class="mt-3 d-flex">
                                                <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary mr-2">編集</a>
                                                <a href="{{ route('logout') }}" class="btn btn-secondary"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">ログアウト
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        @else
                                            <div class="mt-3 d-flex">
                                                @if($is_following)
                                                    <form action="{{ route('unFollow', $user->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-danger mr-2">フォロー解除</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('follow', $user->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-primary mr-2">フォローする</button>
                                                    </form>
                                                @endif
                                                @if($is_followed)
                                                    <span class="bg-secondary text-light px-2 d-flex align-items-center" style="font-size:11px;">フォロワー</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="tab my-2 justify-content-center">
                    <li class="tab__item px-0 pt-0 ml-3 mr-0"><a class="btn btn-lg px-2" href="{{ url('users/' .$user->id) }}">
                        <div class="text-secondary">本 棚</div>
                            <div class="">{{ $product_count }}</div></a>
                    </li>
                    <li class="tab__item tab__item--active px-0 pt-0 mr-0"><a class="btn btn-lg px-2" href="{{ url('favorites/' .$user->id) }}">
                        <strong>
                            <div class="">読みたい</div>
                            <div class="">{{ $favorite_count }}</div></a>
                        </strong>
                    </li>
                    <li class="tab__item px-0 pt-0 mr-0"><a class="btn btn-lg px-2" href="{{ url('followIndex', $user->id) }}">
                        <div class="text-secondary">フォロー</div>
                        <div class="">{{ $follow_count }}</div></a>
                    </li>
                    <li class="tab__item px-0 pt-0 mr-3 mr-0"><a class="btn btn-lg px-2" href="{{ url('followerIndex', $user->id) }}">
                        <div class="text-secondary">フォロワー</div>
                        <div class="">{{ $follower_count }}</div></a>
                    </li>
                </ul>
            </div>
            
            @if(isset($favorites))
                @foreach($favorites as $favorite)
                    <div class="col-md-8 mb-3">
                        <div class="card">
                            <div class="card-header p-3 w-100 d-flex">
                                <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$favorite->user->profile_image) }}" class="rounded-circle ml-3" width="50" height="50">
                                <div class="ml-2 mt-3 d-flex flex-column flex-grow-1">
                                    <p class="mb-0 text-secondary">{{ $favorite->user->name }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                
                                <h4 class="text-center my-2"><a href="{{ url('products/' .$favorite->product->id) }}" class="text-dark font-weight-bold">{{ $favorite->product->title }} / {{ $favorite->product->author }}</a></h4>
                                <a href="{{ url('products/' .$favorite->product->id) }}"><img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$favorite->product->product_image) }}" width="300" height="300" class="mt-4 d-block mx-auto img-fluid img-responsive thumbnail aligncenter size-full wp-image-425" style="cursor:pointer" /></a>
                                <p class="my-2 pl-4 mb-0">おすすめ度 : {{ $favorite->product->recommend }}</p>
                                <p class="pl-4 mb-0">{{ $favorite->product->text }}</p>
                            </div>
                            <div class="card-footer py-2 d-flex justify-content-end bg-white">
                                <div class="mr-3 d-flex align-items-center">
                                    <a href="{{ url('products/' .$favorite->product->id) }}"><i class="far fa-comment fa-fw"></i></a>
                                    @if(is_countable($favorite->product->comments))
                                        <p class="mb-0 text-secondary">{{ count($favorite->product->comments) }}</p>
                                    @else
                                    <p class="mb-0 text-secondary">0</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $favorites->links() }}
        </div>
    </div>
    @endsection
