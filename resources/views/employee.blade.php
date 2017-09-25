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
    function today() {
        var dd = new Date();
        var y = dd.getFullYear();
        var m = dd.getMonth()+1;//获取当前月份的日期
        var d = dd.getDate();
        return y+"-"+m+"-"+d;
    }
    var today = today();
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
</script>
@endsection

@section('content-in-main')
<!-- modal model for correct-->
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
                <form id="edit_form" role="form" method="POST" action="">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <table class="table table-hover" style="text-align: center;width: 90%;">
                        <thead>
                            <tr>
                                <th style="width: 40%;">修改选项</th>
                                <th>当前记录</th>
                                <th>修改为</th>
                            </tr>
                        </thead>
                        <tbody>
    <!--                         <tr>
                                <td>刷卡时间</td>
                                <td id="td_check_time"></td>
                                <td>
                                    <div class="input-group date" id="datetimepicker2" style="width: 70%;margin-left: 15%;">  
                                        <input id="calendar233" type="text" class="form-control" type="time" autocomplete="off" placeholder="显示日期" name="start_time" required/>  
                                        <span class="input-group-addon">  
                                            <span class="glyphicon glyphicon-calendar"></span>  
                                        </span>
                                    </div>   
                                </td>
                            </tr> -->
                            <tr>
                                <td>刷卡位置</td>
                                <td id="td_card_gate"></td>
                                <td>
                                    <select id="period" class="selectpicker btn" data-live-search-style="begins" name="card_gate">
                                        <optgroup label="刷卡位置  ">
                                            <option value="SN01">A</option>
                                            <option value="SN02">B</option>
                                            <option value="SN03">C</option>
                                        </optgroup>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>进出方向</td>
                                <td id="td_check_direction"></td>
                                <td>
                                    <select id="period" class="selectpicker btn" data-live-search-style="begins" name="check_direction">
                                        <optgroup label="进出方向">
                                            <option value="1">进</option>
                                            <option value="0">出</option>
                                        </optgroup>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>刷卡方式</td>
                                <td id="td_check_method"></td>
                                <td>
                                    <select id="period" class="selectpicker btn" data-live-search-style="begins" name="check_method">
                                        <optgroup label="刷卡方式">
                                            <option value="card">门禁</option>
                                            <option value="car">车闸</option>
                                            <option value="请假">请假</option>
                                        </optgroup>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>备注</td>
                                <td id="td_note"></td>
                                <td><input id="note" class="form-control placeholder-no-fix" type="note" name="note" style="width: 45%;margin-left: 27.5%;" required></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="margin-top: 15px;margin-left: 90%;">提交</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal model for profile -->
<div id="modal-switch-profile" tabindex="-1" role="dialog" aria-labelledby="modal-switch-label" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">员工信息</span>
                </button>
                <div id="modal-switch-label" class="modal-title" style="font-size: large;">员工信息</div>
                <table class="table table-hover" style="text-align: center;margin: 10%;width: 80%;">
                  <tbody>
                    <tr>
                      <td style="font-weight: bold;">工号</td>
                      @if($employee->work_number)
                      <td>{{ $employee->work_number}}</td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">姓名</td>
                      @if($employee->name)
                      <td>{{ $employee->name }}</td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">电话</td>
                      @if($employee->phone_number)
                      <td>{{ $employee->phone_number }}</td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">部门</td>
                      @if($employee->department)
                      <td>{{ $employee->department }}</td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">职位</td>
                      @if($employee->work_title)
                      <td>{{ $employee->work_title }}</td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    <tr>
                      <td style="font-weight: bold;">考勤卡号</td>
                      @if($employee->card_uid)
                      <td>{{ $employee->card_uid }}</td>
                      @else
                      <td></td>
                      @endif
                      <tr>
                      <td style="font-weight: bold;">车牌号</td>
                      @if($employee->car_number)
                      <td>{{ $employee->car_number }}</td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    </tr>
                  </tbody>
                </table>

            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="col-md-12" style="margin-top:10px;margin-bottom:20px;">
        <button data-toggle="modal" data-target="#modal-switch-profile" class="btn-primary btn">
            员工信息
        </button>
        <button type="button" class="btn btn-primary pull-right" onclick="method('tableExcel')">
            导出本页表格为excel
        </button>
    </div>
    <div style="float:left;margin-top:20px;margin-bottom:30px;">
        <form class="form-horizontal" method="POST" action="/">
            {{ csrf_field() }}
            <div class="col-md-2 col-md-offset-3 col-xs-4 col-xs-offset-1">  
                <div class="form-group">  
                    <!--指定 date标记-->  
                    <div class="input-group date" id="datetimepicker1" style="width:95%;">  
                        <input type="text" class="form-control" type="time" autocomplete="off" placeholder="起始时间：" name="start_time" required/>  
                        <span class="input-group-addon">  
                            <span class="glyphicon glyphicon-calendar"></span>  
                        </span>  
                    </div>  
                </div> 
            </div>  
            <div class="col-md-2 col-xs-4">  
                <div class="form-group">  
                    <!--指定 date标记-->  
                    <div class="input-group date" id="datetimepicker2" style="width:95%;">  
                        <input type='text' class="form-control" type="time" autocomplete="off" placeholder="结束时间：" name="end_time" required/>  
                        <span class="input-group-addon">  
                            <span class="glyphicon glyphicon-calendar"></span>  
                        </span>  

                    </div>  
                </div>
            </div> 
            <div class="form-group col-xs-2 col-md-2 col-xs-offset-2">
                <button type="submit" class="btn btn-primary">
                    确定
                </button>
            </div>
        </form>
    </div>
    <div class="table-responsive col-md-11">
        <table class="table table-striped" id="tableExcel">
            <thead  style="text-align:center;">
                <tr>
                    <th>工号</th>
                    <th>姓名</th>
                    <th>记录时间</th>
                    <th>刷卡位置</th>
                    <th>进出方向</th>
                    <th>刷卡方式</th>
                    <th>外出时间</th>
                    <th>是否正常外出</th>
                    <th>备注</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    @if($record->employee)
                        <th><a id="work_number_{{$record->id}}" href="/employees/{{ $record->employee->work_number }}">{{ $record->employee->work_number }}</a></th>
                    @else
                        <th id="work_number_{{$record->id}}">N/A</th>
                    @endif
                    
                    @if($record->employee)
                        <th id="name_{{$record->id}}">{{ $record->employee->name }}</th>
                    @else
                        <th id="name_{{$record->id}}">N/A</th>
                    @endif

                    @if($record->check_time)
                        <th id="check_time_{{$record->id}}">{{ $record->check_time }}</th>
                    @else
                        <th id="check_time_{{$record->id}}">N/A</th>
                    @endif

                    @if($record->card_gate)
                        <th id="card_gate_{{$record->id}}">{{ $record->card_gate }}</th>
                    @else
                        <th id="card_gate_{{$record->id}}">N/A</th>
                    @endif

                    @if($record->check_direction==1)
                        <th id="check_direction_{{$record->id}}">进</th>
                    @else
                        <th id="check_direction_{{$record->id}}">出</th>
                    @endif

                    @if($record->check_method=="car")
                        <th id="check_method_{{$record->id}}">车闸</th>
                    @elseif($record->check_method=="card") 
                        <th id="check_method_{{$record->id}}">门禁</th>
                    @else
                        <th id="check_method_{{$record->id}}">{{ $record->check_method }}</th>
                    @endif

                    {{-- Out time duration  --}}
                    @php
                        $hasDuration = false;
                    @endphp
                    @foreach ($in_out_duration as $duration)
                        @if ($duration['in_id'] == $record->id)
                            <th>{{ $duration['diff']->format('%H:%I:%S') }}</th>
                            @php
                                $hasDuration = true;
                            @endphp
                            @break
                        @endif
                    @endforeach

                    @if (!$hasDuration)
                        <th></th>
                    @endif
                    <th>
                        <a href="{{url('/graph')}}">是</a>
                    </th>

                    @if($record->note)
                        <th id="note_{{$record->id}}">{{ $record->note }}</th>
                    @else
                        <th id="note_{{$record->id}}"></th>
                    @endif
                    <th>
                        <button id="{{$record->id}}" data-toggle="modal" data-target="#modal-switch" class="btn-primary btn" onclick="set_action(this.id)">修改</button>
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
<script type="text/javascript">
    function set_action(record_id){
        var work_number = "work_number" + "_" + record_id;
        var card_gate = "card_gate" + "_" + record_id;
        var check_direction = "check_direction" + "_" + record_id;
        var check_method = "check_method" + "_" + record_id;
        var note = "note" + "_" + record_id;
        work_number_value = document.getElementById(work_number).innerHTML;
        card_gate_value = document.getElementById(card_gate).innerHTML;
        check_direction_value = document.getElementById(check_direction).innerHTML;
        check_method_value = document.getElementById(check_method).innerHTML;
        note_value = document.getElementById(note).innerHTML;
        document.getElementById("td_card_gate").innerHTML= card_gate_value;
        document.getElementById("td_check_direction").innerHTML = check_direction_value;
        document.getElementById("td_check_method").innerHTML = check_method_value;
        document.getElementById("td_note").innerHTML = note_value;
        var action = "/employees/" + work_number_value + "/records/" + record_id;
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
@endsection