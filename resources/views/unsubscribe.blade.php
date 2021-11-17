<x-app-layout>
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Unsubscribe') }}</h4>
                </div>
            </div>
        </div>
        <div class="row">
			@if(session()->has('success'))
				<div class="alert alert-success" role="alert" style="width: 100%">
					{{ session()->get('success') }}
				</div>
			@elseif (isset($errors) && $errors->any())
				<div class="alert alert-danger" role="alert">
					@foreach ($errors->all() as $error)
						{{ $error }}
					@endforeach
				</div>
			@endif
			@if(!session()->has('success'))
        	<div class="card">
        		<div class="col-12" style="padding: 30px;">
				<form action="{{ route('unsubscribe.store') }}" method="post">
					@csrf
					<input type="hidden" name="PersonID" value="{{ $customer->PersonID }}">
					<input type="hidden" name="EmailHashSum" value="{{ $customer->EmailHashSum }}">
					<div class="form-group">
	                    <div class="custom-control custom-checkbox">
	                        <input type="checkbox" class="custom-control-input" id="opt_out_marketing" name="opt_out_marketing" value="1" />
	                        <label class="custom-control-label" for="opt_out_marketing">Do you wish to opt out of email marketing?</label>
	                    </div>
	                </div>

					<div class="form-group">
	                    <div class="custom-control custom-checkbox">
	                    <input type="checkbox" class="custom-control-input" id="opt_out_mot_reminder" name="opt_out_mot_reminder" value="1" />
	                        <label class="custom-control-label" for="opt_out_mot_reminder">Do you wish to opt out of MOT reminders?</label>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <div class="custom-control custom-checkbox">
	                    <input type="checkbox" class="custom-control-input" id="opt_out_all" name="opt_out_all" value="1" />
	                        <label class="custom-control-label" for="opt_out_all">Do you wish to opt out of everything from ATS?</label>
	                    </div>
	                </div>

	                *Disclaimer – you will still receive MOT EDM notifications if you have signed up to ATS MOT reminders. Please click the second or third button if you don’t wish to receive those either.

	                <div class="form-group mt-2">
                    	<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                	</div>
        		</form>
        		</div>
        	</div>
			@endif
        </div>
    </div>
</x-app-layout>