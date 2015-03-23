@extends('app')

@section('content')

		<form class="form-horizontal" role="form" method="POST" action="{{route('post.register')}}">
			<h1 class="text-center">User Account</h1>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="span4">
					<div class="form-group">
						<label class="label">First Name</label>
						<div class="input-control text">
							<input type="text" class="form-control" name="FirstName" value="{{ Input::old('FirstName') }}">
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="form-group">
						<label class="label">Middle Name</label>
						<div class="input-control text">
							<input type="text" class="form-control" name="MiddleName" value="{{ Input::old('MiddleName') }}">
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="form-group">
						<label class="label">Last Name</label>
						<div class="input-control text">
							<input type="text" class="form-control" name="LastName" value="{{ Input::old('LastName') }}">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span6">
					<div class="form-group">
						<label class="label">ID Number</label>
						<div class="input-control number">
							<input type="text" class="form-control" name="IDNumber" value="{{ Input::old('IDNumber') }}">
						</div>
					</div>

					<div class="form-group">
						<label class="label">Mobile</label>
						<div class="input-control number">
							<input type="number" class="form-control" name="Mobile" value="{{ Input::old('Mobile') }}">
						</div>
					</div>


					<div class="form-group">
						<label class="label">E-Mail Address</label>
						<div class="input-control email">
							<input type="email" class="form-control" name="email" value="{{ Input::old('email') }}">
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="form-group">
						<label class="label">Password</label>
						<div class="input-control password">
							<input type="password" class="form-control" name="password">
						</div>
					</div>

					<div class="form-group">
						<label class="label">Confirm Password</label>
						<div class="input-control password">
							<input type="password" class="form-control" name="password_confirmation">
						</div>
					</div>
				</div>
			</div>

			<div class="text-center">
				<button type="submit" class="button primary large">
					Register
				</button>
			</div>

		</form>
@endsection
