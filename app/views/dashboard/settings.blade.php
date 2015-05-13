@extends('dashboard.index')

@section('dashboard-aside')
  <div id="settings-menu" class="ui secondary vertical pointing menu">

    <a id="account" class="red item" href="{{route('land.services')}}">Account</a>
    <a id="signage" class="red item" href="{{route('signage.services')}}">Users</a>
    <a id="signage" class="red item" href="{{route('signage.services')}}">Businesses</a>

  </div>
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#dashboard-menu #settings').trigger('click');
     });
  </script>
@endsection
