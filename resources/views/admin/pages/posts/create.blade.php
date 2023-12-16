@extends('admin.master')

@section('title')
    Create Post
@endsection
@section('maincontent')
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-8">
                <h1 class="page-heading">
                    Create Post
                </h1>
            </div>
            <div class="col-sm-4 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a href="{{route('admin.posts.index')}}">Posts</a></li>
                    <li class="link-effect">Create Post</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    <!-- Page Content -->
    <div class="content content-narrow">
        <div class="row">
            <div class="col-md-12">
                <!-- Static Labels -->
                <div class="block">
                    <div class="block-content block-content-narrow">
                        <form class="form-horizontal push-10-t add-post-form" action="{{route('admin.posts.store')}}"
                              method="post">
                            @csrf


                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control" type="text" id="post-title"
                                               name="title" placeholder="Post Title" value="{{old('title')}}" required>
                                        <label for="post-title">Title</label>
                                    </div>
                                    @if ($errors->has('title'))
                                        <div id="post-title-error"
                                             class="help-block animated fadeInDown">{{ $errors->first('title') }}</div>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <div class="form-material form-material-primary">
                                        <textarea class="form-control" type="text" id="post-body"
                                                  name="body" placeholder="Post Description"
                                                  required>{{old('body')}}</textarea>
                                        <label for="post-body">Description</label>
                                    </div>
                                    @if ($errors->has('body'))
                                        <div id="post-body-error"
                                             class="help-block animated fadeInDown">{{ $errors->first('body') }}</div>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-9">
                                    <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Static Labels -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection

@section('custom-styles')
    <link rel="stylesheet" href="{{asset("admin_assets/js/plugins/select2/select2.min.css")}}">
@endsection
@section('custom-js')
    <script src="{{asset('admin_assets/js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin_assets/js/plugins/select2/select2.min.js')}}"></script>
    <script>
        jQuery(function () {
            // Init page helpers (Slick Slider plugin)
            App.initHelpers('select2');
            App.initFormValidation('.add-post-form');
        });
    </script>
@endsection
@section('custom-styles')
@endsection