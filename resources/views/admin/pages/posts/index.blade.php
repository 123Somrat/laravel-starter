@extends('admin.master')

@section('title')
    Post List
@endsection
@section('maincontent')
    <!-- Page Content -->
    <div class="content">
        <!-- Dynamic Table Full -->
        <div class="block">
            <div class="block-content">
                <div class="block-header">
                    <h3 class="block-title col-md-6">Post List</h3>
                    @can('posts.create')
                        <a href="{{route('admin.posts.create')}}" class="pull-right btn btn-primary btn-rounded">Add
                            Post</a>
                    @endcan
                </div>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                <table class="table table-bordered table-striped js-dataTable-full">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th class="text-center" data-orderable="false" data-searchable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $index=>$post)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$post->title}}</td>
                            <td>{{$post->body}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    @can('posts.view')
                                        <a href="{{route('admin.posts.show',$post->id)}}" class="btn btn-xs btn-default"
                                           type="button" data-toggle="tooltip" title="View Post"><i
                                                    class="fa fa-eye"></i></a>
                                    @endcan
                                    @can('posts.edit')
                                        <a href="{{route('admin.posts.edit',$post->id)}}" class="btn btn-xs btn-default"
                                           type="button" data-toggle="tooltip" title="Edit Post"><i
                                                    class="fa fa-pencil"></i></a>
                                    @endcan
                                    @can('posts.delete')

                                        <form class="post-remove"
                                              action="{{route('admin.posts.destroy',$post->id)}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-xs btn-default" type="submit"
                                                    data-toggle="tooltip"
                                                    title="Remove Post"><i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
@endsection
@section('custom-js')
    <script src="{{asset('admin_assets/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin_assets/js/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Page JS Code -->
    {{--<script src="assets/js/pages/base_ui_activity.js"></script>--}}
    <script>
        jQuery(function () {
            let data = {
                title: 'Are you sure?',
                text: 'To Remove This Post!!',
                confirmButtonText: 'Yes, Remove!',
            };

            // CustomScript.onSubmitSweetAlert(data, '.supplier-inactive');
            // CustomScript.dataTableWithPrint('.js-dataTable-full');
            App.initDataTable('.js-dataTable-full');
            App.initOnSubmitSweetAlert(data, '.post-remove');
        });
    </script>
@endsection

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/js/plugins/sweetalert/sweetalert.min.css')}}">

    <link rel="stylesheet" href="{{asset('admin_assets/js/plugins/datatables/jquery.dataTables.min.css')}}">
    <style type="text/css">
        .post-remove {
            float: left;
        }
    </style>
@endsection