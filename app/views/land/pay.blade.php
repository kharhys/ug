@extends('land.services')

@section('service')
  <div class="ui piled segment">

    <table class="ui compact celled definition table">
      <thead>
        <tr>
          <th></th>
          <th>Property</th>
          <th>Last Bill Due Date</th>
          <th>Last Payment Date</th>
          <th>Current Balance</th>
        </tr>
      </thead>
      <tbody>
        @foreach($property as $prop)
          <tr>
            <td class="collapsing">
              <form class="ui form" method="POST" action="{{route('land.post.search')}}">
                <input type="hidden" name="PlotNumber" value="{{$prop->PlotNumber}}">
                <button class="ui tiny basic button">
                  <i class="linkify icon"></i>
                </button>
              </form>
            </td>
            <td>{{$prop->PlotNumber}} at {{$prop->PhysicalAddress}}</td>
            <td>{{$prop->LastBillDueDate}}</td>
            <td>{{$prop->LastPaymentDate}}</td>
            <td>KSh.  {{$prop->CurrentBalance}}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="full-width">
        <tr>
          <th></th>
          <th colspan="4">
            <div class="ui right floated small labeled icon button">
              <i class="send icon"></i> Request Invoice for all properties
            </div>
          </th>
        </tr>
      </tfoot>
    </table>

  </div>
@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#land-menu #pay').trigger('click');
     });
  </script>
@endsection
