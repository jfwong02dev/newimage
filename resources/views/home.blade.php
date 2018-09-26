@extends('layouts.master')

@section('title', __('translate.pagetitle/dashboard'))

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel widget-tasks">
                <div class="panel-body">
                    <div class="col-sm-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title task-sort-icon"><i class="panel-title-icon fa fa-calendar"></i>{{__('translate.widget-title/calendar')}}</span>
                            </div> <!-- / .panel-heading -->
                            <div class="panel-body popovers">
                                <div id="calendar"></div>
                                <form action="{{route('report.all-sales-search')}}" method="post" id="link-to-details-form">
                                    @csrf
                                    <input type="hidden" name="from_date" value="{{ old('from_date') ?? '' }}" />
                                    <input type="hidden" name="to_date" value="{{ old('to_date') ?? '' }}" />
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title task-sort-icon"><i class="panel-title-icon fa fa-bar-chart-o"></i>{{__('translate.widget-title/monthly-sale')}}</span>
                            </div> <!-- / .panel-heading -->
                            <!-- Without vertical padding -->
                            <div class="panel-body">
                                <canvas id="myChart" width="400" height="400"></canvas>
                            </div> <!-- / .panel-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
		<!-- Javascript -->
		<script>
            $(document).ready(function(){
                var daily_sales = <?php echo json_encode($daily_sales); ?>;
                var monthly_statistic_chart = <?php echo json_encode($monthly_statistic_chart); ?>;
                var lowest_of_month = <?php echo json_encode($lowest_of_month); ?>;
                var highest_of_month = <?php echo json_encode($highest_of_month); ?>;
                
                var calendar = $('#calendar').fullCalendar({
                    /*
                        events is the main option for calendar.
                        for demo we have added predefined events in json object.
                    */
                    events: daily_sales,
                    eventRender: function(event, element, view) {
                        return $('<a class=\"fc-day-grid-event fc-h-event fc-event fc-start fc-end\"' + 
                                    (lowest_of_month.indexOf(event.start['_i']) !== -1 
                                        ? ' style=\"background-color: #e66454; border-color: #e3503e;\"' 
                                        : (highest_of_month.indexOf(event.start['_i']) !== -1 
                                            ? ' style=\"background-color: #5ebd5e; border-color: #4cb64c;\"' 
                                            : '')) + '>' + 
                                    '<div class=\"fc-content\">' +
                                        '<span class=\"fc-title\">' + event.title + '</span>' +
                                    '</div>' + 
                                 '</a>');
                    },
                    eventClick: function(event, jsEvent, view) {
                        $('input[name=from_date').val(event.start['_i']);
                        $('input[name=to_date').val(event.start['_i']);
                        $('#link-to-details-form').submit();
                    },
                });

                var ctx = document.getElementById("myChart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: monthly_statistic_chart['month'],
                        datasets: [{
                            label: '# Service',
                            data: monthly_statistic_chart['total_service'],
                            backgroundColor: "rgba(29, 137, 207, 1)",
                            borderWidth: 1
                        },{
                            label: '# Product',
                            data: monthly_statistic_chart['total_product'],
                            backgroundColor: "rgba(91, 192, 222, 1)",
                            borderWidth: 1
                        }]
                    },
                    options: {
                        tooltips: {
                            mode: 'label',
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var cat = data.datasets[tooltipItem.datasetIndex].label;
                                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    var total = 0;
                                    for (var i = 0; i < data.datasets.length; i++) {
                                        total += data.datasets[i].data[tooltipItem.index];
                                    }
                                    
                                    if (tooltipItem.datasetIndex != data.datasets.length - 1) {
                                        return cat + " : RM " + value;
                                    } else {
                                        return [cat + " : RM " + value, "# Total : RM " + total];
                                    }
                                }
                            }
                        },
                        scales: {
                            xAxes: [{
                                stacked: true
                            }],
                            yAxes: [{
                                stacked: true
                            }]
                        },
                    }
                });
            });

            init.push(function () {
                $('.widget-tasks .panel-body').pixelTasks().sortable({
                    axis: "y",
                    handle: ".task-sort-icon",
                    stop: function( event, ui ) {
                        // IE doesn't register the blur when sorting
                        // so trigger focusout handlers to remove .ui-state-focus
                        ui.item.children( ".task-sort-icon" ).triggerHandler( "focusout" );
                    }
                });
            });
		</script>
		<!-- / Javascript -->
	@endsection
@endsection