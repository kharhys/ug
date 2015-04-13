@extends('land.services')

@section('service')

  <table class="ui definition table">
    <thead>
      <tr>
        <th></th>
        <th>Description</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>Land Owner</td>
        <td>{{$land->CustomerName}}</td>
      </tr>
      <tr>
        <td>Land Owner's ID Number</td>
        <td>{{$land->IDNO}}</td>
      </tr>
      <tr>
        <td>Land Owner's Mobile Number</td>
        <td>{{$land->Mobile1}}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Plot Number</td>
        <td>{{$land->PlotNumber}}</td>
      </tr>
      <tr>
        <td>Document Number</td>
        <td>{{$land->DocumentNumber}}</td>
      </tr>
      <tr>
        <td>Block/LR Number</td>
        <td>{{$land->BlockLRNumber}}</td>
      </tr>
      <tr>
        <td>Universal Parcel Number</td>
        <td>{{$land->UPN}}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Total Annual Amount</td>
        <td>KSh. {{$land->TotalAnnualAmount}}</td>
      </tr>
      <tr>
        <td>Current Balance</td>
        <td>KSh. {{$land->CurrentBalance}}</td>
      </tr>
    </tbody>

    <tfoot class="full-width">
      <tr>
        <th></th>
        <th colspan="4">
          <a href="{{route('land.invoice')}}" class="ui right floated small primary labeled icon button">
            <i class="send icon"></i>
            Request Invoice
          </a>
        </th>
      </tr>
    </tfoot>

  </table>

@endsection

@section('script')
  @parent
  <script type="text/javascript">
     $( document ).ready(function() {
       $('#land-menu #search').trigger('click');
     });
  </script>
@endsection
