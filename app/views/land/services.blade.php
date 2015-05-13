@extends('dashboard.services')


@section('dashboard-content')
  <div id="land-menu" class="ui fluid two item pointing menu">
  <!--  <a id="search" href="{{route('land.search')}}" class=" blue item">
      <i class="search icon"></i> Search Land Records
    </a> -->
    <a id="register" href="{{route('land.registration')}}" class=" blue item">
      <i class="plus icon"></i> Register Land
    </a>
    <a id="pay" href="{{route('land.pay')}}" class="blue item">
      <i class="money icon"></i> Pay Rates
    </a>
  </div>

  @yield('service')
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#department-menu #land').trigger('click');
     });
  </script>
@endsection
