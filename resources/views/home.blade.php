@extends('layouts.app')
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
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a data-toggle="tab" href="#last">上次登录记录</a></li>
                <li><a data-toggle="tab" href="#history">登录历史</a></li>
                <li><a data-toggle="tab" href="#password">修改密码</a></li>
            </ul> 
        </div>
<!--         <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">上次登录记录</div>
                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div> -->
        <div class="col-md-8 tab-content">
            <div class="tab-pane panel panel-default fade active in" id="last">
                <div class="panel-heading">上次登录记录0</div>
                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
            <div class="tab-pane panel panel-default fade" id="history">
                <div class="panel-heading">上次登录记录1</div>
                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
            <div class="tab-pane panel panel-default fade" id="password">
                <div class="panel-heading">上次登录记录2</div>
                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
