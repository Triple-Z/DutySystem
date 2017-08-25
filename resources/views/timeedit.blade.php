@extends('layouts.main')
@section('content-in-main')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 tab-panel panel panel-default">
	<div class="panel-heading" style="text-align: center;font-size: large;margin-top: 5%;">考勤时间编辑</div>
	<div class="panel-body" style="margin-bottom: 5%;">
	    <div class="table-responsive col-md-10 col-md-offset-1">
		    <form class="form-horizontal" method="POST" action="timeedit/update">
		    	{{ csrf_field() }}
				{{ method_field('PUT') }}
		        <table class="table table-striped">
		            <thead  style="text-align:center;">
		                <tr>
		                    <th>时间节点</th>
		                    <th title="0 为本日&#10;1 为次日">天</th>
		                    <th title="24 小时制">时</th>
		                    <th>分</th>
		                    <th>秒</th>
		                </tr>
		            </thead>
		            <tbody>

						@foreach($timenodes as $timenode)
							<tr>
								@if (strcmp($timenode->name, "am_start") == 0)
									<th title="上午开始时间：&#10;上午签到记录最早记录时间">上午开始时间</th>
								@elseif (strcmp($timenode->name, "am_end") == 0)
									<th title="上午结束时间：&#10;上午签到记录最晚记录时间">上午结束时间</th>
								@elseif (strcmp($timenode->name, "pm_start") == 0)
									<th title="下午开始时间：&#10;下午签到记录最早记录时间">下午开始时间</th>
								@elseif (strcmp($timenode->name, "pm_end") == 0)
									<th title="下午结束时间：&#10;下午签到记录最晚记录时间">下午结束时间</th>
								@elseif (strcmp($timenode->name, "am_ddl") == 0)
									<th title="上午上班开始时间：&#10;从该时间到迟到最晚时间都是上午迟到时间">上午上班时间</th>
								@elseif (strcmp($timenode->name, "am_late_ddl") == 0)
									<th title="上午迟到最晚时间：&#10;该时间之后首次进入也计为缺勤">上午迟到最晚时间</th>
								@elseif (strcmp($timenode->name, "pm_ddl") == 0)
									<th title="下午上班开始时间：&#10;从该时间到早退最早时间末次出也记为缺勤">下午上班时间</th>
								@elseif (strcmp($timenode->name, "pm_early_ddl") == 0)
									<th title="下午早退最早时间：&#10;从该时间到下班时间出记为早退">下午早退最早时间</th>
								@elseif (strcmp($timenode->name, "pm_away") == 0)
									<th title="下午下班时间：&#10;一直持续到下午结束时间">下午下班时间</th>
								@endif
								
								<th><input type="text" value="{{ $timenode->day }}" name="{{ $timenode->name . '_day' }}"/></th>
								<th><input type="text" value="{{ $timenode->hour }}" name="{{ $timenode->name . '_hour' }}"/></th>
								<th><input type="text" value="{{ $timenode->minute }}" name="{{ $timenode->name . '_minute' }}"/></th>
								<th><input type="text" value="{{ $timenode->second }}" name="{{ $timenode->name . '_second' }}"/></th>
		                	</tr>
						@endforeach

		            </tbody>
		        </table>
	            <button type="submit" class="btn btn-primary pull-right">
	                提交
	            </button>
			</form>
	    </div>
	</div>
</div>
@endsection