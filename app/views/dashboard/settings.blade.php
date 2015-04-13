@extends('dashboard.index')

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#dashboard-menu #settings').trigger('click');
     });
  </script>
@endsection
