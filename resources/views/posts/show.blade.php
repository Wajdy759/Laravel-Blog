@extends('master')

@section('title', '| View Post')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $post->title }}</h1>
            <div class="tags">
                @foreach ($post->tags as $tag)
                    <span class="label label-default">{{ $tag->name }}</span>
                @endforeach
            </div>

            <hr>
            <p class="lead">{{ $post->body }}</p>            
        </div>

        <div class="col-md-4">
            <div class="well">
                <dl class="dl-horizontal">
                    <dt>URL:</dt>
                    <dd><a href = "{{ url('blog/'.$post->slug) }}">{{ '/blog/'.$post->slug }}</a></dd>
                </dl>

                <dl class="dl-horizontal">
                    <dt>Category:</dt>
                    <dd>{{ $post->category->name }}</dd>
                </dl>

                <dl class="dl-horizontal">
                    <dt>Created At:</dt>
                    <dd>{{ $post->created_at->diffForHumans() }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Last Updated:</dt>
                    <dd>{{ $post->updated_at->diffForHumans() }}</dd>
                </dl>
                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        <a href="/posts/{{$post->id}}/edit" class="btn btn-primary btn-block">Edit</a>
                    </div>
                    <div class="col-sm-6">
                        <form onsubmit="return confirm('Are You Sure You Want To Delete This Post?');" action="/posts/{{ $post->id }}" method="POST" >                            
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-danger btn-block" value="Delete" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection