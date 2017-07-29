@extends('layouts.main')
@section('content-in-main')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 tab-panel panel panel-default">
	<div class="panel-heading" style="text-align: center;font-size: large;margin-top: 5%;">考勤时间编辑</div>
	<div class="panel-body" style="margin-bottom: 5%;">
	    <div class="table-responsive col-md-10 col-md-offset-1">
		    <form class="form-horizontal" method="POST" action="">
		    	{{ csrf_field() }}
		        <table class="table table-striped">
		            <thead  style="text-align:center;">
		                <tr>
		                    <th>类型名字</th>
		                    <th>天</th>
		                    <th>小时</th>
		                    <th>分</th>
		                    <th>秒</th>
		                </tr>
		            </thead>
		            <tbody>
		                <tr>
		                    <th title="2333">example_name</th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                </tr>             
		                <tr>
		                    <th title="2333">example_name</th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                </tr>  
		                <tr>
		                    <th title="2333">example_name</th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                </tr>  
		                <tr>
		                    <th title="2333">example_name</th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                </tr>  
		                <tr>
		                    <th title="2333">example_name</th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                </tr>  
		                <tr>
		                    <th title="2333">example_name</th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                </tr>  
		                <tr>
		                    <th title="2333">example_name</th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                </tr>  
		                <tr>
		                    <th title="2333">example_name</th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                </tr>  
		                <tr>
		                    <th title="2333">example_name</th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                    <th><input type="text" value="example_value" name=""/></th>
		                </tr>     
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