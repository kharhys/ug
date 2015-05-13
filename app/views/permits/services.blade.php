@extends('dashboard.services')


@section('dashboard-content')
  <div id="permits-menu" class="ui fluid three item pointing menu">
    <a id="application" href="{{route('permits.apply')}}" class=" teal item">
      <i class="add circle icon"></i> Apply
    </a>
    <a id="renewal" href="{{route('permits.renew')}}" class="teal item">
      <i class="time icon"></i> Renew
    </a>
    <a id="applications" href="{{route('signage.applications')}}" class=" teal item">
      <i class="print icon"></i> Applications
    </a>
  </div>

  @yield('service')
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#department-menu #permits').trigger('click');
     });
  </script>
@endsection
