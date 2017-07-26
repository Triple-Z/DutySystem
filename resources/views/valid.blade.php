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
                    <span style="font-size: large;">每页显示周期</span>
                    <select id="period" class="selectpicker btn" data-live-search-style="begins">
                        <optgroup label="选择显示周期">
                            <option>天</option>
                            <option>周</option>
                            <option>月</option>
                            <option>半年</option>
                            <option>一年</option>
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
            <button type="button" class="btn btn-primary" onclick="method('tableExcel')">
                导出本页表格为excel
            </button>
        </div>
    </div>

    <div class="table-responsive col-md-11">
        <table class="table table-striped" id="tableExcel">
            <thead style="text-align:center;">
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
                 @foreach($employees as $employee) 
                    <tr>
                        <th>{{ $employee->name }}</th>

                        @if($employee->special_records()['today_morning_earliest_record'])
                            <th>{{ $employee->special_records()['today_morning_earliest_record']->check_time }}</th> 
                        @else
                            <th>N/A</th>
                        @endif

                        @if($employee->special_records()['today_morning_latest_record'])
                            <th>{{ $employee->special_records()['today_morning_latest_record']->check_time }}</th> 
                        @else
                            <th>N/A</th>
                        @endif

                        @if($employee->special_records()['today_afternoon_earliest_record'])
                            <th>{{ $employee->special_records()['today_afternoon_earliest_record']->check_time }}</th> 
                        @else
                            <th>N/A</th>
                        @endif

                        @if($employee->special_records()['today_evening_latest_record'])
                            <th>{{ $employee->special_records()['today_evening_latest_record']->check_time }}</th> 
                        @else
                            <th>N/A</th>
                        @endif

                        @if($employee->special_records()['note'])
                            <th>{{ $employee->special_records()['note'] }}</th> 
                        @else
                            <th>N/A</th>
                        @endif
                        <th><button type="button" class="btn btn-primary" onclick="method('')">修正</button></th>
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
