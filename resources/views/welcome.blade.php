@extends('layouts.main')
@section('content-in-main')
<!-- modal model -->
<div id="modal-switch" tabindex="-1" role="dialog" aria-labelledby="modal-switch-label" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <div id="modal-switch-label" class="modal-title">Title</div></div>
            <div class="modal-body">
                <input id="switch-modal" type="checkbox" checked="checked"></div>
        </div>
    </div>
</div>

<!-- filter choice -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="btn-group bootstrap-select">
                <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="first-disabled" title="Corn" aria-expanded="false">
                    <span class="filter-option pull-left">Corn</span>&nbsp;
                    <span class="caret"></span>
                </button>
                <div class="dropdown-menu open" style="max-height: 177px; overflow: hidden; min-height: 134px;">
                    <div class="bs-searchbox">
                        <input type="text" class="form-control" autocomplete="off">
                    </div>
                    <ul class="dropdown-menu inner" role="menu" style="max-height: 123px; overflow-y: auto; min-height: 80px;">
                        <li class="dropdown-header " data-optgroup="1"><span class="text">Fruit</span></li>
                        <li data-original-index="1" data-optgroup="1" class="">
                            <a tabindex="0" class="opt  " style="" data-tokens="null">
                                <span class="text">Apple</span>
                                <span class="glyphicon glyphicon-ok check-mark"></span>
                            </a>
                        </li>
                        <li data-original-index="2" data-optgroup="1" class="">
                            <a tabindex="0" class="opt undefined" style="" data-tokens="null">
                                <span class="text">Orange</span>
                                <span class="glyphicon glyphicon-ok check-mark"></span>
                            </a>
                        </li>
                        <li class="divider" data-optgroup="2div"></li>
                        <li class="dropdown-header " data-optgroup="2">
                            <span class="text">Vegetable</span></li>
                        <li data-original-index="3" data-optgroup="2" class="selected active">
                            <a tabindex="0" class="opt  " style="" data-tokens="null">
                                <span class="text">Corn</span>
                                <span class="glyphicon glyphicon-ok check-mark"></span>
                            </a>
                        </li>
                        <li data-original-index="4" data-optgroup="2">
                            <a tabindex="0" class="opt undefined" style="" data-tokens="null">
                                <span class="text">Carrot</span>
                                <span class="glyphicon glyphicon-ok check-mark"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- content view -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h2 class="sub-header">Section title</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>姓名</th>
                    <th>到达</th>
                    <th>离开</th>
                    <th>Header</th>
                    <th>Header</th>
                    <th>选项</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1,001</td>
                    <td>Lorem</td>
                    <td>ipsum</td>
                    <td>dolor</td>
                    <td>sit</td>
                    <td><button data-toggle="modal" data-target="#modal-switch" class="btn btn-default">修正记录</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection