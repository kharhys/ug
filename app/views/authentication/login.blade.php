@extends('layout')

@section('aside')
<div class="ui segment">
  <h4 class="ui small header">Online Services</h4>
    <hr/>
    <p>&nbsp</p>

    <p>The following are some of the services availbale on this portal to logged in users.</p>
    <div class="ui accordion">

      @foreach($services as $service)
        <!-- accordion item -->
        <div class="title">
          <i class="dropdown icon"></i>
          <strong class="ui small header"> {{$service->Title}} </strong>
        </div>
        <div class="content">
          <p>
            {{$service->ShortDecsription}}
          </p>
            <a class="ui teal" href="#"> More Information <i class="ui right double angle icon"></i>  </a>
        </div>
      @endforeach

    </div>

    <p>&nbsp<br/>&nbsp</p>
</div>
@endsection

@section('section')
<div class="ui segment">
  <form class="ui form" method="POST" action="{{route('portal.post.login')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <h4 class="ui dividing header">Login to access your account</h4>

    @include('partials.notification')

    <div class="required field">
      <label>Email</label>
      <div class="ui icon input">
        <input type="email" placeholder="Username" name="email" value="{{ Input::old('email') }}">
        <i class="user icon"></i>
      </div>
    </div>
    <div class="required field">
      <label>Password</label>
      <div class="ui icon input">
        <input type="password" name="password">
        <i class="lock icon"></i>
      </div>
    </div>

    <div class="ui form segment">
      <div class="inline field">
        <div class="ui checkbox">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember"> Remember me </label>
        </div>
      </div>
    </div>

    <button class="fluid ui orange submit button"> Sign In</button>

    <div class="ui horizontal divider">
      Can't Login?
    </div>

    <div class="ui two column middle aligned relaxed fitted stackable grid">
      <div class="column">
        <a class="fluid ui green labeled icon button" href="{{route('portal.get.register')}}">
          Register
          <i class="add icon"></i>
        </a>
      </div>

     <div class="center aligned column">
       <div class="fluid ui  labeled icon button">
         <i class="signup icon"></i>
         Reset Password
       </div>
     </div>
   </div>

  </form>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $( document ).ready(function() {
      console.log( "ready!" );
      $('.ui.accordion').accordion();
  });
</script>
@endsection
