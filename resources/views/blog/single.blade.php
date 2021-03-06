@extends('master')

@section('title', "| $post->title")

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>{{ $post->title }}</h1>

            {{-- {!! !!} <- This Ensures That The HTML Code From The Database Is Run On Screen --}}
            {{-- {!! !!} <- Only Used For The WYSIWYG Editor --}}
            <p>{!! $post->body !!}</p>

            <hr>

            <p>Posted in: {{ $post->category->name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3 class="comments-title">
                <span class="glyphicon glyphicon-comment"></span>
                {{ $post->comments()->count() }} Comments
            </h3>

            @foreach($post->comments as $comment)
                <div class="comment">
                    <div class="author-info">
                        <img src="" class="author-image">
                        <div class="author-name">
                            <h4>{{ $comment->name }}</h4>
                            <p class="author-time">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="comment-content">
                        {{ $comment->comment }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div id="comment-form" class="col-md-8 col-md-offset-2" style="margin-top: 50px">
            <form action="/comments/{post_id}" method="POST">
                {{ csrf_field() }}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea rows="3" type="text" name="comment" id="commnt" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="hidden">
                    <input type="text" name="post_id" id="post_id" value="{{ $post->id }}">
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Publish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection