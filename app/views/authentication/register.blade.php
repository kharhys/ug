@extends('layout')

@section('section')
<div class="ui raised segment">
  <form class="ui form">
    <h4 class="ui horizontal header divider"> Personal Information </h4>

    <div class="ui hidden divider"></div>
    <div class="field">
      <label>Name</label>
      <div class="three fields">
        <div class="field">
          <input type="text" name="first-name" placeholder="First Name">
        </div>
        <div class="field">
          <input type="text" name="middle-name" placeholder="Middle Name">
        </div>
        <div class="field">
          <input type="text" name="last-name" placeholder="Last Name">
        </div>
      </div>
    </div>

    <div class="ui hidden divider"></div>
    <div class="two fields">
      <div class="required field">
        <label>ID Number</label>
        <input type="text" name="id-number" placeholder="National ID Number">
      </div>
      <div class="required field">
        <label>Phone Number</label>
        <input type="text" name="phone-number" placeholder="Mobile Phone Number">
      </div>
    </div>

    <div class="ui hidden divider"></div>
    <h4 class="ui horizontal header divider"> Account Information </h4>

    <div class="two fields">
      <div class="required field">
        <label>Email</label>
        <div class="ui icon input">
          <input type="text" name="email" placeholder="Email Address">
          <i class="email icon"></i>
        </div>
      </div>
      <div class="required field">
        <label>Email Confirmation</label>
        <div class="ui icon input">
          <input type="text" name="email-confirmation" placeholder="Confirm Email Address">
          <i class="email icon"></i>
        </div>
      </div>
    </div>

    <div class="two fields">
      <div class="required field">
        <label>Password</label>
        <div class="ui icon input">
          <input type="password" name="password">
          <i class="lock icon"></i>
        </div>
      </div>
      <div class="required field">
        <label>Password Confirmation</label>
        <div class="ui icon input">
          <input type="text" name="password-confirmation">
          <i class="lock icon"></i>
        </div>
      </div>
    </div>

    <div class="ui section divider"></div>

    <div class="ui error message">
      <div class="header">We noticed some issues</div>
    </div>

    <a href="#" class="fluid orange ui submit button">
      <i class="send outline icon"></i>
      Register
    </a>

  </form>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $( document ).ready(function() {
      console.log( "ready!" );
      $('.ui.dropdown').dropdown();
  });
</script>
@endsection
