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
.form-group {
    margin-bottom:0;
}
@endsection

@section('script')
@endsection

@section('content-in-main')
<!-- modal model -->
<div id="modal-switch" tabindex="-1" role="dialog" aria-labelledby="modal-switch-label" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">记录修正</span></button>
                <div id="modal-switch-label" class="modal-title" style="font-size: large;">记录修正</div>
            </div>
            <div class="modal-body">
                <form role="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="dtp_input1" class="col-md-2 control-label">选择时间</label>
                        <div class="input-group date form_datetime col-md-5" data-date="2017-07-25T05:25:07Z" data-date-format="yyyy MM dd - HH:ii p" data-link-field="dtp_input1">
                            <input class="form-control" size="16" type="text" value="">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input1" value="" class="col-md-11" /><br/>
                    </div>
                    <div class="form-group">
                        <label class="control-label visible-ie8 visible-ie9">备注</label>
                        <input class="form-control placeholder-no-fix" type="note" autocomplete="off" id="register_password" name="note" required>
                        <button type="submit" class="btn btn-primary" style="margin-top: 15px;margin-left: 90%;">提交</button>
                    </div>
                </form>
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
                    <th>记录时间</th>
                    <th>备注</th>
                </tr>
                @foreach($records as $record)
                <tr>
                    <th>{{ $record->employee->name }}</th> 
                    <th>{{ $record->check_time }}</th>
                    <th></th>
<!--                     <th>
                        <button data-toggle="modal" data-target="#modal-switch" class="btn btn-primary btn-sm">修改记录</button>
                    </th> -->
                </tr>
                @endforeach
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection
