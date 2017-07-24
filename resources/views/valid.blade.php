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
                <div id="modal-switch-label" class="modal-title">Title</div>
            </div>
            <div class="modal-body">
                <input id="switch-modal" type="checkbox" checked="checked">
            </div>
        </div>
    </div>
</div>

<!-- filter choice -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div style="margin-top: 20px;">
            <div class="col-md-3 col-md-offset-1" style="display: inline-block;">
                <form class="pull-left">
                    {{csrf_field()}}
                    <select id="period" class="selectpicker btn" data-live-search-style="begins">
                        <optgroup label="选择显示周期">
                            <option>今天</option>
                            <option>最近一周</option>
                            <option>最近一个月</option>
                            <option>最近半年</option>
                            <option>最近一年</option>
                            <option>所有记录</option>
                        </optgroup>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">
                        确定
                    </button>
                </form>
            </div>
            <div class="col-md-5">
                <form class="" role="search">
                    {{csrf_field()}}
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="按名字搜索" name="employee_name">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- content view -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div>
        <div class="col-sm-2 col-md-2" style="font-size: 200%;float: left;">
            所有记录
        </div>
        <div class="col-sm-2 col-md-2" style="float: right;">
            <button type="button" class="btn btn-primary">
                导出为excel
            </button>
        </div>
    </div>

    <div class="table-responsive col-md-11">
        <table class="table table-striped">
            <thead  style="text-align:center;">
                <tr>
                    <th>姓名</th>
                    <th>上午签到时间</th>
                    <th>上午最后离开时间</th>
                    <th>下午签到时间</th>
                    <th>下午最后离开时间</th>
                    <th>出勤情况/备注</th>
                    <th>记录修正</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection
