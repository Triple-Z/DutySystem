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
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{asset('js/moment.js')}}" type="text/javascript"></script>
<script src="{{asset('js/zh-cn.js')}}" type="text/javascript"></script>
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {  
        var picker1 = $('#datetimepicker1').datetimepicker({  
            format: 'YYYY-MM-DD HH:mm',  
            locale: moment.locale('zh-cn'),  
            //minDate: '2016-7-1'  
        });  
        var picker2 = $('#datetimepicker2').datetimepicker({  
            format: 'YYYY-MM-DD HH:mm',  
            locale: moment.locale('zh-cn')  
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
</div> -->

<!-- filter choice -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div>
            <form class="form-horizontal" method="POST" action="">
                {{ csrf_field() }}
                <div class="col-md-1 col-md-offset-2" style="vertical-align: middle;margin-top: 20px;font-size: 150%;">
                    显示时段:
                </div>
                <div class="col-md-2" style="margin-left: 50px;">  
                    <div class="form-group">  
                        <label>选择开始时间：</label>  
                        <!--指定 date标记-->  
                        <div class="input-group date" id="datetimepicker1" style="width: 81%;">  
                            <input type="text" class="form-control" type="time" autocomplete="off" placeholder="开始时间" name="start_time" required/>  
                            <span class="input-group-addon">  
                                <span class="glyphicon glyphicon-calendar"></span>  
                            </span>  
                        </div>  
                    </div> 
                </div>  
                <div class="col-md-2">  
                    <div class="form-group">  
                        <label>选择结束时间：</label>  
                        <!--指定 date标记-->  
                        <div class="input-group date" id="datetimepicker2">  
                            <input type='text' class="form-control" type="time" autocomplete="off" placeholder="结束时间" name="end_time" required/>  
                            <span class="input-group-addon">  
                                <span class="glyphicon glyphicon-calendar"></span>  
                            </span>  
                            <button type="submit" class="btn btn-primary pull-right">
                                确定
                            </button>
                        </div>  
                    </div>
                </div> 
            </form>
    </div>
</div>

<!-- content view -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div>
        <div class="col-sm-2 col-md-2" style="font-size: 200%;float: left;">
            所有刷卡记录
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
                        <th>{{ $record->employee->id }}</th>
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

<!--                     <th>
                        <button data-toggle="modal" data-target="#modal-switch" class="btn btn-primary btn-sm">修改记录</button>
                    </th> -->
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