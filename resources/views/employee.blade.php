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
<script src="{{asset('js/moment.js')}}" type="text/javascript"></script>
<script src="{{asset('js/zh-cn.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    function set_action(work_number,record_id){
        var action = "/employees/" + work_number + "/records/" + record_id;
        $("#edit_form").attr("action",action);
    }
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
                var fname = oXL.Application.GetSaveAsFilename(name, "Excel Spreadsheets (*.xls), *.xls");  
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
        return y+"-"+m+"-"+d;
    }
    var today = today();
    $(function () {

        var picker2 = $('#datetimepicker2').datetimepicker({  
            format: 'YYYY-MM-DD HH:mm:ss',  
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
                <form id="edit_form" role="form" style="margin:15px;" method="POST" action="">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
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
                        <div class="input-group date" id="datetimepicker2">  
                            <input id="calendar233" type="text" class="form-control" type="time" autocomplete="off" placeholder="显示日期" name="start_time" required/>  
                            <span class="input-group-addon">  
                                <span class="glyphicon glyphicon-calendar"></span>  
                            </span>
                        </div>   
                    </div>  
                    <div class="form-group">
                        <label class="control-label visible-ie8 visible-ie9">备注</label>
                        <input class="form-control placeholder-no-fix" type="note" autocomplete="off" id="register_password" name="note" required>
                        <!-- <input id="record_id" type="record_id" name="record_id" hidden="hidden"> -->
                        <button type="submit" class="btn btn-primary" style="margin-top: 15px;margin-left: 90%;">提交</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
            <thead  style="text-align:center;">
                <tr>
                    <th>工号</th>
                    <th>姓名</th>
                    <th>记录时间</th>
                    <th>刷卡位置</th>
                    <th>刷卡方向</th>
                    <th>备注</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    @if($record->employee)
                        <th><a href="/employees/{{ $record->employee->work_number }}">{{ $record->employee->work_number }}</a></th>
                    @else
                        <th>N/A</th>
                    @endif
                    
                    @if($record->employee)
                        <th>{{ $record->employee->name }}</th>
                    @else
                        <th>N/A</th>
                    @endif

                    @if($record->check_time)
                        <th>{{ $record->check_time }}</th>
                    @else
                        <th>N/A</th>
                    @endif

                    @if($record->card_gate)
                        <th>{{ $record->card_gate }}</th>
                    @else
                        <th>N/A</th>
                    @endif

                    @if($record->check_direction==1)
                        <th>进</th>
                    @else
                        <th>出</th>
                    @endif
                    
                    @if($record->note)
                        <th>{{ $record->note }}</th>
                    @else
                        <th>N/A</th>
                    @endif

                    <th>
                        <button id="{{$record->id}}" data-toggle="modal" data-target="#modal-switch" class="btn-primary btn" value="{{$record->employee->work_number}}" onclick="set_action(this.value,this.id)">修改</button>
                    </th>
                </tr>
                @endforeach

            </tbody>
        </table>
        <div style="text-align: center;">
            {{ $records->links() }}
        </div>
    </div>
</div>
@endsection