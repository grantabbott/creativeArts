
				<!-- Footer -->
				<footer>
				&copy; <a href="{!! URL::to('/') !!}">{!! config('config.application_name') !!}</a> Version {!! config('constants.VERSION').' '.config('config.credit') !!}
				<p class="pull-right">
				@if(config('config.show_terms_and_conditions'))
					<a href="/terms-and-conditions">Terms & Conditions</a>
				@endif
				@if(config('config.show_datetime_in_footer'))
					{!! App\Classes\Helper::showDateTime(date('d M Y,h:i a')) !!} 
				@endif
				@if(config('config.show_timezone_in_footer'))
					<strong>Timezone:</strong> {!! $default_timezone !!}
				@endif
				</p>
				</footer>
				<!-- End Footer -->