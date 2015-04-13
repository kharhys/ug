@extends('dashboard.index')

@section('dashboard-aside')
<div id="department-menu" class="ui vertical menu">

  <div class="header item">Department</div>
    <a id="land" class="blue item" href="{{route('land.services')}}">Land</a>
    <a id="signage" class="blue item" href="{{route('land.services')}}">Signage</a>
    <a id="building" class="blue item" href="{{route('land.services')}}">Building</a>

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
  ices
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#dashboard-menu #services').trigger('click');
     });
  </script>
@endsection
