@extends('layouts.master')

@section('title', __('translate.pagetitle/dashboard'))

@section('content')
    <div class="panel-body">
        <div id="calendar"></div>
        <form action="{{route('report.all-sales-search')}}" method="post" id="link-to-details-form">
			@csrf
			<input type="hidden" name="from_date" value="{{ old('from_date') ?? '' }}" />
			<input type="hidden" name="to_date" value="{{ old('to_date') ?? '' }}" />
		</form>
    </div>
    @section('script')
		<!-- Javascript -->
		<script>
            $(document).ready(function(){
                var daily_sales = <?php echo json_encode($daily_sales); ?>;
                
                var calendar = $('#calendar').fullCalendar({
                    height: 'auto',
                    aspectRatio: 2,
                    /*
                        events is the main option for calendar.
                        for demo we have added predefined events in json object.
                    */
                    events: daily_sales,
                    eventClick: function(event) {
                        $('input[name=from_date').val(event.start['_i']);
                        $('input[name=to_date').val(event.start['_i']);
                        $('#link-to-details-form').submit();
                    }
                });
            });
		</script>
		<!-- / Javascript -->
	@endsection
@endsection