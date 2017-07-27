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

<script type="text/javascript">
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
                        <th>{{ $record->employee->work_number }}</th>
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
                        <button type="button" class="btn btn-primary" onclick="method('')">修改</button>
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