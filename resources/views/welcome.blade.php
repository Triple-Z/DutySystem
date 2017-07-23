@extends('layouts.main')
@section('style') 
#period {
    border-color: #ccc;
}
body {
    padding-top:50px;
}
th {
    text-align:center;
}
#search-box {
    padding:5%;
}
@endsection

@section('content-in-main')
<!-- modal model -->
<div id="modal-switch" tabindex="-1" role="dialog" aria-labelledby="modal-switch-label" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <div id="modal-switch-label" class="modal-title">Title</div></div>
            <div class="modal-body">
                <input id="switch-modal" type="checkbox" checked="checked"></div>
        </div>
    </div>
</div>

<!-- filter choice -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="panel panel-default">
        <div class="panel-heading" id="search-box">
            <form role="search" class="col-md-6 col-md-offset-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="搜索姓名" name="name">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="panel-body">
            233333
        </div>
    </div>
</div>

<!-- content view -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h2 class="sub-header">所有记录</h2>
    <div class="table-responsive col-md-10 col-md-offset-1">
        <table class="table table-striped">
            <thead  style="text-align:center;">
                <tr>
                    <th>姓名</th>
                    <th>记录时间</th>
                    @foreach($employees as $employee)
                        <th>{{$employee->name}}</th>>
                    @endforeach
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection
