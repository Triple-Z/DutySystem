@extends('layouts.main')
@section('script')
<script src="{{asset('js/echarts.js')}}"></script>
@endsection
@section('content-in-main')
    <div id="echart"  class="col-sm-9 col-sm-offset-3 col-md-offset-2 main" style="width: 600px;height:400px;"></div>
        <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('echart'));

        // 指定图表的配置项和数据
        myChart.title = '单轴散点图';

        var hours = ['12a', '1a', '2a', '3a', '4a', '5a', '6a',
                '7a', '8a', '9a','10a','11a',
                '12p', '1p', '2p', '3p', '4p', '5p',
                '6p', '7p', '8p', '9p', '10p', '11p'];
        var days = ['Saturday'];

        var data = [[0,0,5],[0,8,1],[0,15,1]];

        option = {
            tooltip: {
                position: 'top'
            },
            title: [],
            singleAxis: [],
            series: []
        };

        echarts.util.each(days, function (day, idx) {
            option.title.push({
                textBaseline: 'middle',
                top: (idx + 0.5) * 100 / 7 + '%',
                text: day
            });
            option.singleAxis.push({
                left: 150,
                type: 'category',
                boundaryGap: false,
                data: hours,
                top: (idx * 100 / 7 + 5) + '%',
                height: (100 / 7 - 10) + '%',
                axisLabel: {
                    interval: 2
                }
            });
            option.series.push({
                singleAxisIndex: idx,
                coordinateSystem: 'singleAxis',
                type: 'scatter',
                data: [],
                symbolSize: function (dataItem) {
                    return dataItem[1] * 4;
                }
            });
        });

        echarts.util.each(data, function (dataItem) {
            option.series[dataItem[0]].data.push([dataItem[1], dataItem[2]]);
        });

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
@endsection