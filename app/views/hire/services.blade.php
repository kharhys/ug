@extends('dashboard.services')


@section('dashboard-content')
  <div id="hire-menu" class="ui fluid three item pointing menu">
    <a id="stadia" href="{{route('hire.stadia')}}" class=" orange item">
      <i class="soccer icon"></i> Stadia
    </a>
    <a id="premises" href="{{route('hire.premises')}}" class="orange item">
      <i class="university icon"></i> Premises
    </a>
    <a id="equipment" href="{{route('hire.equipment')}}" class="orange item">
      <i class="announcement icon"></i> Equipment
    </a>
  </div>

  @yield('service')
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#department-menu #hire').trigger('click');
     });
  </script>
@endsection
