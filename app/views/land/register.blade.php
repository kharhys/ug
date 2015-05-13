@extends('land.services')

@section('service')
  <form class="ui form" action="{{ route('land.submit.registration') }}" method="post" enctype="multipart/form-data">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

      @foreach ($form->sections() as $section )
        @if ($section->Show)
          @if ( count($section->columns()) > 0 )
            <h4 class=" ui blue dividing header">{{$section}} </h4>
            @foreach($section->columns() as $col)
              {{Api::CustomFormField($col->id())}}
            @endforeach
          @endif
        @endif
      @endforeach

      <div class="ui section divider"></div>

      <div class="ui buttons">
        <div class="ui button">Save</div>
        <div class="or"></div>
        <button class="ui green button"> Submit </button>
      </div>

  </form>
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#land-menu #register').trigger('click');
       $('select').dropdown();
     });
  </script>
@endsection
