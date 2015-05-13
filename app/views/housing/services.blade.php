@extends('dashboard.services')


@section('dashboard-content')
  <div id="housing-menu" class="ui fluid three item pointing menu">
    <a id="home" href="{{route('housing.home')}}" class=" teal item">
      <i class="home icon"></i> House
    </a>
    <a id="stall" href="{{route('housing.stall')}}" class="teal item">
      <i class="columns icon"></i> Stall
    </a>
    <a id="applications" href="{{route('housing.applications')}}" class=" teal item">
      <i class="print icon"></i> Applications
    </a>
  </div>

  @yield('service')
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#department-menu #housing').trigger('click');
     });
  </script>
@endsection
