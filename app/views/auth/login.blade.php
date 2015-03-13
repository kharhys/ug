@extends('app')

<header class="bg-dark"></header>

<table style="width:71%; margin: 0 auto">
  <tr>
    <td width="50%"> <h1> <a href="/">  <img src="../images/logo.png" width="15%"/> </a><small>County Revenue Management System</small></h1> </td>
    <td align="right">
    </td>
  </tr>
</table>

@section('content')

	<form class="form-horizontal span6 offset3" role="form" method="POST" action="/login">
		<h2>User Login</h2>
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="form-group">
			<label class="col-md-4 control-label">E-Mail Address</label>
			<div class="col-md-6 input-control text">
				<input type="email" class="form-control" name="email" value="{{ Input::old('email') }}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Password</label>
			<div class="col-md-6 input-control password">
				<input type="password" class="form-control" name="password">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="remember"> Remember Me
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="submit" class="button primary" style="margin-right: 15px;">
					Login
				</button>

				<a href="/password/email">Forgot Your Password?</a>
			</div>
		</div>
	</form>
@endsection
