@extends('layouts.panel')
@section('style')
    <style type="text/css">
        body {
            padding-top: 0;
        }
        .col-md-8 {
            padding-top: 70px;
        }
        .nav-sidebar>li {
            padding-left: 40px;
        }
        form {
            padding-bottom: 50px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <!-- <li class="active"><a data-toggle="tab" href="#last">上次登录记录</a></li> -->
                <li class="active"><a data-toggle="tab" href="#history">历史登录记录</a></li>
                <li><a data-toggle="tab" href="#name">修改用户名</a></li>
                <li><a data-toggle="tab" href="#password">修改密码</a></li>
            </ul> 
        </div>
        <div class="col-md-8 tab-content">
            <!-- <div class="tab-pane panel panel-default fade active in" id="last">
                <div class="panel-heading">上次登录记录</div>
                <div class="panel-body">
                    You are logged in!
                </div>
            </div> -->
            <div class="tab-pane panel panel-default fade" id="email">
                <div class="panel-heading">修改邮箱</div>
                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
            <div class="tab-pane panel panel-default fade" id="name">
                <div class="panel-heading">修改用户名</div>
                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
            <div class="tab-pane panel panel-default fade active in" id="history">
                <div class="panel-heading">登录历史</div>
                <div class="panel-body">
                <div class="table-responsive col-md-11">
                    <table class="table table-striped" id="tableExcel">
                        <thead style="text-align:center;">
                            <tr>
                                <th style="width:30%;">用户</th>
                                <th>时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($actions as $action)
                                <tr>
                                    <th>{{ $action->user->name }}</th>
                                    <th>{{ $action->timestamp }}</th>
                                    @if ($action->action == 'login')
                                        <th>登录</th>
                                    @elseif ($action->action == 'logout')
                                        <th>注销</th>
                                    @else
                                        <th></th>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: center;">
                        {{ $actions->links() }} 
                    </div>
                </div>
            </div>
            </div>
            <div class="tab-pane panel panel-default fade" id="password">
                <div class="panel-body">
                    <form class="login-form col-md-8 col-md-offset-2" action="admin/resetpassword" method="POST">
                        {{ csrf_field() }}
                        <h3 class="font-green">修改密码</h3>
                        @if($errors->first())
                            <div class="alert alert-danger display-hide" style="display: block;">
                                <button class="close" data-close="alert"></button>
                                <span>   </span>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">原始密码</label>
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="原始密码" name="oldpassword" required autofocus>
                            @if ($errors->has('word'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">新密码</label>
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="新密码" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">重复密码</label>
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="重复密码" name="password_confirmation" required>
                        </div>
                        <div class="form-group">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">
                                    重置密码
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
