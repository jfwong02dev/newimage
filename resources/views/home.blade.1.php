@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-sm-4">
        <div class="stat-panel">
            <div class="stat-row">
                <!-- Success darker background -->
                <div class="stat-cell bg-success darker">
                    <!-- Stat panel bg icon -->
                    <i class="fa fa-lightbulb-o bg-icon" style="font-size:60px;line-height:80px;height:80px;"></i>
                    <!-- Big text -->
                    <span class="text-bg">Overview</span><br>
                    <!-- Small text -->
                    <span class="text-sm">System statistics</span>
                </div>
            </div> <!-- /.stat-row -->
            <div class="stat-row">
                <!-- Success background, without bottom border, without padding, horizontally centered text -->
                <div class="stat-counters bg-success no-border-b no-padding text-center">
                    <!-- Small padding, without horizontal padding -->
                    <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                        <!-- Big text -->
                        <span class="text-bg"><strong>{{ $no_of_available_users }} / {{ $no_of_all_users }}</strong></span><br>
                        <!-- Extra small text -->
                        <span class="text-xs">USERS</span>
                    </div>
                    <!-- Small padding, without horizontal padding -->
                    <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                        <!-- Big text -->
                        <span class="text-bg"><strong>{{ $no_of_available_services }} / {{ $no_of_all_services }}</strong></span><br>
                        <!-- Extra small text -->
                        <span class="text-xs">SERVICES</span>
                    </div>
                    <!-- Small padding, without horizontal padding -->
                    <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                        <!-- Big text -->
                        <span class="text-bg"><strong>{{ $no_of_available_products }} / {{ $no_of_all_products }}</strong></span><br>
                        <!-- Extra small text -->
                        <span class="text-xs">PRODUCTS</span>
                    </div>
                </div> <!-- /.stat-counters -->
            </div> <!-- /.stat-row -->
            <div class="stat-row">
                <!-- Success background, without bottom border, without padding, horizontally centered text -->
                <div class="stat-counters bg-success no-border-b no-padding text-center">
                    <!-- Small padding, without horizontal padding -->
                    <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                        <!-- Big text -->
                        <span class="text-bg"><strong>{{ $no_of_available_sales }} / {{ $no_of_all_sales }}</strong></span><br>
                        <!-- Extra small text -->
                        <span class="text-xs">SALES</span>
                    </div>
                    <div class="stat-cell col-xs-4 padding-sm no-padding-hr">
                        <!-- Big text -->
                        <span class="text-bg"><strong>{{ $no_of_available_adjustments }} / {{ $no_of_all_adjustments }}</strong></span><br>
                        <!-- Extra small text -->
                        <span class="text-xs">ADJUSTMENTS</span>
                    </div>
                    <!-- Success background, small padding, without left and right padding, vertically centered text -->
                    <a href="#" class="stat-cell col-xs-4 bg-success padding-sm no-padding-hr valign-middle">
                        <!-- Extra small text -->
                        <span class="text-xs">MORE&nbsp;&nbsp;<i class="fa fa-caret-right"></i></span>
                    </a>
                </div> <!-- /.stat-counters -->
            </div> <!-- /.stat-row -->
        </div> <!-- /.stat-panel -->
    </div>
    <div class="col-sm-8">
        <!-- Javascript -->
        <script>
            init.push(function () {
                var uploads_data = [
                    { day: '2014-03-10', v: 20 },
                    { day: '2014-03-11', v: 10 },
                    { day: '2014-03-12', v: 15 },
                    { day: '2014-03-13', v: 12 },
                    { day: '2014-03-14', v: 5  },
                    { day: '2014-03-15', v: 5  },
                    { day: '2014-03-16', v: 20 }
                ];
                Morris.Line({
                    element: 'hero-graph',
                    data: uploads_data,
                    xkey: 'day',
                    ykeys: ['v'],
                    labels: ['Value'],
                    lineColors: ['#fff'],
                    lineWidth: 2,
                    pointSize: 4,
                    gridLineColor: 'rgba(255,255,255,.5)',
                    resize: true,
                    gridTextColor: '#fff',
                    xLabels: "day",
                    xLabelFormat: function(d) {
                        return ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov', 'Dec'][d.getMonth()] + ' ' + d.getDate(); 
                    },
                });
            });
        </script>
        <!-- / Javascript -->

        <div class="stat-panel">
            <div class="stat-row">
                <!-- Bordered, without right border, top aligned text -->
                <div class="stat-cell col-sm-4 bordered no-border-r padding-sm-hr valign-top">
                    <!-- Small padding, without top padding, extra small horizontal padding -->
                    <h4 class="padding-sm no-padding-t padding-xs-hr"><i class="fa fa-cloud-upload text-primary"></i>&nbsp;&nbsp;Uploads</h4>
                    <!-- Without margin -->
                    <ul class="list-group no-margin">
                        <!-- Without left and right borders, extra small horizontal padding -->
                        <li class="list-group-item no-border-hr padding-xs-hr">
                            Documents <span class="label pull-right">34</span>
                        </li> <!-- / .list-group-item -->
                        <!-- Without left and right borders, extra small horizontal padding -->
                        <li class="list-group-item no-border-hr padding-xs-hr">
                            Audio <span class="label pull-right">128</span>
                        </li> <!-- / .list-group-item -->
                        <!-- Without left and right borders, without bottom border, extra small horizontal padding -->
                        <li class="list-group-item no-border-hr no-border-b padding-xs-hr">
                            Videos <span class="label pull-right">12</span>
                        </li> <!-- / .list-group-item -->
                    </ul>
                </div> <!-- /.stat-cell -->
                <!-- Primary background, small padding, vertically centered text -->
                <div class="stat-cell col-sm-8 bg-primary padding-sm valign-middle">
                    <div id="hero-graph" class="graph" style="height: 180px;"></div>
                </div>
            </div>
        </div> <!-- /.stat-panel -->
    </div>
</div> <!-- / .row -->
@endsection