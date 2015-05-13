@extends('dashboard.index')

@section('dashboard-aside')
<div id="department-menu" class="ui vertical menu">

  <div class="header item">Department</div>
    <a id="land" class="blue item" href="{{route('land.services')}}">Land</a>
    <a id="hire" class="orange item" href="{{route('hire.services')}}">Hire</a>
    <a id="signage" class="orange item" href="{{route('signage.services')}}">Signage</a>
    <a id="building" class="red item" href="{{route('building.services')}}">Building</a>
    <a id="housing" class="teal item" href="{{route('housing.services')}}">Housing</a>
    <a id="permits" class="teal item" href="{{route('permits.services')}}">Permits</a>
    <a id="weights" class="teal item" href="{{route('weights.services')}}">Weights</a>

  <div class="header item">
    Our Company
  </div>

  <a class="item">
    About Us
  </a>
  <a class="item">
    Jobs
  </a>
  <a class="item">
    Locations
  </a>
  <div class="header item">
    Support
  </div>
  <a class="item">
    FAQ
  </a>
  <a class="item">
    E-mail Support
  </a>
</div>
@endsection

@section('dashboard-content')
  
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#dashboard-menu #services').trigger('click');
     });
  </script>
@endsection
