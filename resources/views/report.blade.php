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
@section('script')
<script src="{{asset('js/moment.js')}}" type="text/javascript"></script>
<script src="{{asset('js/zh-cn.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    var idTmr;  
    function  getExplorer() {  
        var explorer = window.navigator.userAgent ;  
        //ie  
        if (explorer.indexOf("MSIE") >= 0) {  
            return 'ie';  
        }  
        //firefox  
        else if (explorer.indexOf("Firefox") >= 0) {  
            return 'Firefox';  
        }  
        //Chrome  
        else if(explorer.indexOf("Chrome") >= 0){  
            return 'Chrome';  
        }  
        //Opera  
        else if(explorer.indexOf("Opera") >= 0){  
            return 'Opera';  
        }  
        //Safari  
        else if(explorer.indexOf("Safari") >= 0){  
            return 'Safari';  
        }  
    }  
    function method(tableid) {  
        if(getExplorer()=='ie')  
        {  
            var curTbl = document.getElementById(tableid);  
            var oXL = new ActiveXObject("Excel.Application");  
            var oWB = oXL.Workbooks.Add();  
            var xlsheet = oWB.Worksheets(1);  
            var sel = document.body.createTextRange();  
            sel.moveToElementText(curTbl);  
            sel.select();  
            sel.execCommand("Copy");  
            xlsheet.Paste();  
            oXL.Visible = true;  

            try {  
                var fname = oXL.Application.GetSaveAsFilename("Excel.xls", "Excel Spreadsheets (*.xls), *.xls");  
            } catch (e) {  
                print("Nested catch caught " + e);  
            } finally {  
                oWB.SaveAs(fname);  
                oWB.Close(savechanges = false);  
                oXL.Quit();  
                oXL = null;  
                idTmr = window.setInterval("Cleanup();", 1);  
            }  

        }  
        else  
        {  
            tableToExcel(tableid)  
        }  
    }  
    function Cleanup() {  
        window.clearInterval(idTmr);  
        CollectGarbage();  
    }  
    var tableToExcel = (function() {  
        var uri = 'data:application/vnd.ms-excel;base64,',  
                template = '<html><head><meta charset="UTF-8"></head><body><table>{table}</table></body></html>',  
                base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },  
                format = function(s, c) {  
                    return s.replace(/{(\w+)}/g,  
                            function(m, p) { return c[p]; }) }  
        return function(table, name) {  
            if (!table.nodeType) table = document.getElementById(table)  
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}  
            window.location.href = uri + base64(format(template, ctx))  
        }  
    })()  
</script>  
<script type="text/javascript">
    function today() {
        var dd = new Date();
        var y = dd.getFullYear();
        var m = dd.getMonth()+1;//获取当前月份的日期
        var d = dd.getDate();
        return y+"-"+m;
    }
    var today = today();
    $(function () {

        var picker2 = $('#datetimepicker2').datetimepicker({  
            format: 'YYYY-MM',  
            locale: moment.locale('zh-cn'),
            maxDate: today
        });  
        //动态设置最小值  
        picker1.on('dp.change', function (e) {  
            picker2.data('DateTimePicker').minDate(e.date);  
        });  
        //动态设置最大值  
        picker2.on('dp.change', function (e) {  
            picker1.data('DateTimePicker').maxDate(e.date);  
        });  
    });  
</script>
@endsection
@section('content-in-main')
<!-- modal model -->
<!-- <div id="modal-switch" tabindex="-1" role="dialog" aria-labelledby="modal-switch-label" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">记录修正</span></button>
                <div id="modal-switch-label" class="modal-title" style="font-size: large;">记录修正</div>
            </div>
            <div class="modal-body">
                <form role="form" style="margin:15px;">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="control-label">选择修改项</label><br/>
                        <select id="period" class="selectpicker btn" data-live-search-style="begins" name="period" style="float: none;">
                            <optgroup label="选择显示周期">
                                <option value="today_morning_earliest_record">上午签到时间</option>
                                <option value="today_morning_latest_record">上午离班时间</option>
                                <option value="today_afternoon_earliest_record">下午签到时间</option>
                                <option value="today_afternoon_latest_record">下午离班时间</option>
                            </optgroup>
                        </select>
                    </div>
                    <br/>
                    <div class="form-group">  
                        <label>修改为：</label>  
                        <div class='input-group date' id='datetimepicker2'>  
                            <input type='text' class="form-control" />  
                            <span class="input-group-addon">  
                                <span class="glyphicon glyphicon-calendar"></span>  
                            </span>  
                        </div>  
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
</div> -->

<!-- filter choice -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div style="margin-top: 20px;">
            <form class="form-horizontal" method="POST" action="/report">
                {{ csrf_field() }}
                <div class="col-md-2 col-md-offset-3">
                    <div style="font-size: 150%;">
                        选择显示月份：
                    </div>
                </div>
                <div class="col-md-2" style="margin-left: -40px;">  
                    <div class="form-group">  
                        <!--指定 date标记-->  
                        <div class="input-group date" id="datetimepicker2" style="width: 81%;">  
                            <input type="text" class="form-control" type="time" autocomplete="off" placeholder="显示月份" name="month" required/>  
                            <span class="input-group-addon">  
                                <span class="glyphicon glyphicon-calendar"></span>  
                            </span>  
                            <button type="submit" class="btn btn-primary pull-right" style="margin-left: 5px;">
                                确定
                            </button>
                        </div>  
                    </div> 
                </div>  
            </form>
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
            <button type="button" class="btn btn-primary" onclick="method('tableExcel')">
                导出本页表格为excel
            </button>
        </div>
    </div>

    <div class="table-responsive col-md-11">
        <table class="table table-striped" id="tableExcel">
            <thead style="text-align:center;">
                <tr>
                    <th>工号</th>
                    <th>姓名</th>
                    <th>应出勤天数</th>
                    <th>实际出勤天数</th>
                    <th>事假</th>
                    <th>病假</th>
                    <th>迟到</th>
                    <th>早退</th>
                    <th>旷工</th>
                    <th>出勤率</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <th><a href="/employees/{{ $employee->work_number }}">{{ $employee->work_number }}</a></th>
                        <th>{{ $employee->name }}</th>
                        <th>{{ $valid_days }}</th>
                        <th>{{ $employee->month_report_data($date)['normal'] }}</th>
                        <th>{{ $employee->month_report_data($date)['absence_valid_work'] }}</th>
                        <th>{{ $employee->month_report_data($date)['absence_valid_ill'] }}</th>
                        <th>{{ $employee->month_report_data($date)['late'] }}</th>
                        <th>{{ $employee->month_report_data($date)['early_leave'] }}</th>
                        <th>{{ $employee->month_report_data($date)['absence_invalid'] }}</th>
                        @if ($valid_days)
                            <th>{{ number_format(($employee->month_report_data($date)['normal'] / $valid_days) * 100, 2) . '%' }}</th>
                        @else
                            <th>0.00%</th>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="text-align: center;">
             {{ $employees->links() }} 
        </div>
    </div>
</div>
@endsection
