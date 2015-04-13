@extends('dashboard.index')

@section('dashboard-aside')
  x
@endsection

@section('dashboard-content')
  y
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#dashboard-menu #home').trigger('click');
     });
  </script>
@endsection
