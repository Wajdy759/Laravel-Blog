@extends('master')

@section('title', '| Edit Post')

@section('head_content')
    {{-- Tag Selector Scripts --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    {{-- WYSIWYG Editor Scripts --}}
    {{-- 
        


        WYSIWYG EXPOSES THE SITE TO SOME SECURITY ISSUES
        HTML TAGS RUNNING MALIGNANT CODE COULD BE RUN ON THE SITE
        SEE WAYS TO FIX THIS BEFORE ADDING WYSIWYG EDITORS
        https://www.youtube.com/watch?v=_md2zRrPAhA
        
        

    --}}
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init({ 
            selector: "textarea", 
            plugins: "code textcolor colorpicker link",
            menubar: false
        });
    </script>
@endsection

@section('content')
<div class="row">
    <form action="/posts/{{ $post->id }}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="col-md-8">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required value="{{ $post->title }}">
            </div>

            <div class="form-group">
                <label for="title">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" required value="{{ $post->slug }}">
            </div>
            
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tags">Tag</label>
                <select name="tags[]" id="tags" class="js-example-basic-multiple form-control" multiple="multiple">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="body">Body</label>
                <textarea rows="7" name="body" name="body" class="form-control" required>{{ $post->body }}</textarea>
            </div>
        </div>

        <div class="col-md-4">
            <div class="well">
                <dl class="dl-horizontal">
                    <dt>Created At:</dt>
                    <dd>{{ $post->created_at->diffForHumans() }}</dd>

                    <dt>Last Updated:</dt>
                    <dd>{{ $post->updated_at->diffForHumans() }}</dd>
                </dl>
                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        <input type="submit" class="btn btn-success btn-block" name="save" value="Save"/>
                    </div>
                    <div class="col-sm-6">
                        <input type="submit" class="btn btn-danger btn-block" name="cancel" value="Cancel"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script_content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        $('.js-example-basic-multiple').select2().val({{ json_encode($post->tags()->allRelatedIds()) }}).trigger('change');
    </script>
@endsection