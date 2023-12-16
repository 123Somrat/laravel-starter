@extends('admin.master')

@section('title')
    Edit User
@endsection
@section('maincontent')
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-8">
                <h1 class="page-heading">
                    Edit User
                </h1>
            </div>
            <div class="col-sm-4 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a href="{{route('admin.users.index')}}">Users</a></li>
                    <li class="link-effect">Edit User</li>
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
                        <form class="form-horizontal push-10-t add-user-form"
                              action="{{route('admin.users.update',$user->id)}}"
                              method="post">
                            @method('put')
                            @csrf


                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control" type="text" id="user-name"
                                               name="name" placeholder="User Name"
                                               value="{{old('name')?old('name'):$user->name}}" required>
                                        <label for="user-name">Name</label>
                                    </div>
                                    @if ($errors->has('name'))
                                        <div id="user-name-error"
                                             class="help-block animated fadeInDown">{{ $errors->first('name') }}</div>
                                    @endif

                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control" type="email" id="user-email"
                                               name="email" placeholder="User Email"
                                               value="{{old('email')?old('email'):$user->email}}" required>
                                        <label for="user-email">Email</label>
                                    </div>
                                    @if ($errors->has('email'))
                                        <div id="user-email-error"
                                             class="help-block animated fadeInDown">{{ $errors->first('email') }}</div>
                                    @endif

                                </div>
                            </div>
                            @can('users.assign_role')
                                <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                                    <div class="col-sm-12">
                                        <div class="form-material">
                                            <select class="js-select2 form-control" id="roles" name="roles[]" multiple
                                                    data-placeholder="Please Select a Role" >
                                                <option></option>
                                                <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                @foreach($roles as $role)
                                                    <option value="{{$role->id}}" {{old('roles')?(in_array($role->id,old('roles'))?'selected':''):(in_array($role->id,$user_roles)?'selected':'')}}>{{$role->display_name}}</option>
                                                @endforeach
                                            </select>

                                            <label for="roles">Select Role</label>
                                        </div>
                                        @if ($errors->has('roles'))
                                            <div id="roles-error"
                                                 class="help-block animated fadeInDown">{{ $errors->first('roles') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
                                    <div class="col-sm-12">
                                        <div class="form-material">
                                            <select class="js-select2 form-control" id="permissions"
                                                    name="permissions[]" multiple
                                                    data-placeholder="Please Select  Extra Permissions" >
                                                <option></option>
                                                <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                @foreach($permissions as $index=>$permissionGroup)
                                                    <optgroup label="{{$index}}">
                                                        @foreach($permissionGroup as $permission)
                                                            <option value="{{$permission->id}}" {{old('permissions')?(in_array($permission->id,old('permissions'))?'selected':''):(in_array($permission->id,$user_permissions)?'selected':'')}}>{{$permission->display_name}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>

                                            <label for="permissions">Select Extra Permissions</label>
                                        </div>
                                        @if ($errors->has('permissions'))
                                            <div id="permissions-error"
                                                 class="help-block animated fadeInDown">{{ $errors->first('permissions') }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endcan
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
            App.initFormValidation('.add-user-form');
        });
    </script>
@endsection
@section('custom-styles')
@endsection