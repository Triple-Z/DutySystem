@extends('layouts.main')

@section('script')
@endsection

@section('holidays-view')
    <div id="app" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main"></div>
    <script src="{{asset('vue-schedule-calendar/dist/demo.js')}}"></script>
    <div class="col-md-9 col-md-offset-3">
	    <button class="btn btn-default">提交</button>
    </div>

@endsection