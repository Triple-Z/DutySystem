<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>无人机院考勤系统</title>
        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> -->
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
        <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
        <style type="text/css">
            body {
                padding-top: 50px;
            }
            .sidebar {
                position: fixed;
                -moz-box-shadow: 8px 8px 8px #888888; /* 老的 Firefox */
                box-shadow: 8px 8px 8px #888888;
                margin-bottom:10px;
            }
            .nav-sidebar > li {
                padding-left: 40px;
            }
            @yield('style')
        </style>
        @yield('script')
<!--         <script type="text/javascript">
            $(document).ready(function(){  
                url = document.domain;
                alert(url)
            })  
        </script> -->
    </head>
    <body>
    
        {{-- Session message   --}}
        @if(session()->has('flash_success'))
            <div class="alert alert-success col-md-10 col-md-offset-2">
                {{ session()->get('flash_success', 'default') }}
                <a class="close" onclick="$('.alert').attr('class','fade')">&times;</a>
            </div>
        @endif

        @if(session()->has('flash_warning'))
            <div class="alert alert-info col-md-10 col-md-offset-2">
                {{ session()->get('flash_warning', 'default') }}
                <a class="close" onclick="$('.alert').attr('class','fade')">&times;</a>
            </div>
        @endif

        @if(session()->has('flash_error'))
            <div class="alert alert-danger col-md-10 col-md-offset-2">
                {{ session()->get('flash_error', 'default') }}
                <a class="close" onclick="$('.alert').attr('class','fade')">&times;</a>
            </div>
        @endif

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="">无人机院考勤系统</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href={{ url('/home') }}>管理面板</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} 
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        退出
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-right" role="search">
                        {{csrf_field()}}
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="按工号搜索" name="employee_id">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar" id="left-nav">
                        <li><a href="{{url('/')}}/">进出记录总览</a></li>
                        <li><a href="{{url('/valid')}}">每日出勤情况</a></li>
                        <li><a href="{{url('/report')}}">每月报表</a></li>
<!--                         <li><a href="{{url('/graph')}}">绘制出勤曲线</a></li> -->
                        <li><a href="{{url('/holidays')}}">节假日编辑</a></li>
                        <li><a href="{{url('/timeedit')}}">考勤设置</a></li>
                        <li><a href="{{url('/leave')}}">请假情况</a></li>
                    </ul>    
                </div>
                @yield('content-in-main')
            </div>
        </div>
        @yield('holidays-view')
    </body>
    <script type="text/javascript">
        $(function () {
            $("#left-nav").find("li").each(function () {
                var a = $(this).find("a:first")[0];
                if ($(a).attr("href") == location.href) {
                    $(this).addClass("active");
                } else {
                    $(this).removeClass("active");
                }
            });
        });
    </script>
</html>