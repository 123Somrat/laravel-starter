@extends('admin.master')

@section('title')
    User List
@endsection
@section('maincontent')
    <!-- Page Content -->
    <div class="content">
        <!-- Dynamic Table Full -->
        <div class="block">
            <div class="block-content">
                <div class="block-header">
                    <h3 class="block-title col-md-6">User List</h3>
                    @can('user.create')
                        <a href="{{route('admin.users.create')}}" class="pull-right btn btn-primary btn-rounded">Add
                            User</a>
                    @endcan
                </div>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                <table class="table table-bordered table-striped js-dataTable-full">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th data-orderable="false">Role</th>
                        <th data-orderable="false">Extra Permissions</th>
                        <th class="text-center" data-orderable="false" data-searchable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $index=>$user)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role_display_names->implode(", ")}}</td>
                            <td>{{$user->permission_display_names->implode(", ")}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    @can('users.edit')
                                        <a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-xs btn-default"
                                           type="button" data-toggle="tooltip" title="Edit User"><i
                                                    class="fa fa-pencil"></i></a>
                                    @endcan
                                    @can('users.delete')
                                        <form class="user-remove"
                                              action="{{route('admin.users.destroy',$user->id)}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-xs btn-default" type="submit"
                                                    data-toggle="tooltip"
                                                    title="Remove User"><i class="fa fa-times"></i>
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
                text: 'To Remove This User!!',
                confirmButtonText: 'Yes, Remove!',
            };

            // CustomScript.onSubmitSweetAlert(data, '.supplier-inactive');
            // CustomScript.dataTableWithPrint('.js-dataTable-full');
            App.initDataTable('.js-dataTable-full');
            App.initOnSubmitSweetAlert(data, '.user-remove');
        });
    </script>
@endsection

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/js/plugins/sweetalert/sweetalert.min.css')}}">

    <link rel="stylesheet" href="{{asset('admin_assets/js/plugins/datatables/jquery.dataTables.min.css')}}">
    <style type="text/css">
        .user-remove {
            float: left;
        }
    </style>
@endsection