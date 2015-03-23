@extends('app')

@section('content')

      <h1>Add Business</h1>
      <form class="form-horizontal" role="form" action="" method="post">
          <fieldset>
              <legend>Basic Details</legend>
              <div class="row">
                  <div class="span5">

                      <div class="form-group">
                          <label>Name</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="CustomerName" value="{{Input::old('CustomerName')}}" required="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Registration No</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="RegistrationNumber" value="{{Input::old('RegistrationNumber')}}" required="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>VAT No.</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="VATNumber" value="{{Input::old('VATNumber')}}" required="">
                          </div>
                      </div>


                  </div>

                  <div class="span5">

                      <div class="form-group">
                          <label>Business Type</label>
                          <div class="input-control select">
                              {{ Form::select('BusinessTypeID', $types, Input::old('BusinessTypeID'), array('class' => 'form-control')) }}
                          </div>
                      </div>
                      <div class="form-group">
                          <label>PIN</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="PIN" value="{{Input::old('PIN')}}" required="">
                          </div>
                      </div>


                  </div>
              </div>
          </fieldset>


          <fieldset>
              <legend>Contact Details</legend>
              <div class="row">
                  <div class="span5">

                      <div class="form-group">
                          <label>Postal Address</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="PostalAddress" value="{{Input::old('PostalAddress')}}" required="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Postal Code</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="PostalCode" value="{{Input::old('PostalCode')}}" required="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Town</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="Town" value="{{Input::old('Town')}}" required="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>County</label>
                          <div class="input-control select">
                              {{ Form::select('CountyID', $counties, Input::old('CountyID'), array('class' => 'form-control')) }}
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Telephone (Line 1)</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="Telephone1" value="{{Input::old('Telephone1')}}" required="">
                          </div>
                      </div>


                  </div>

                  <div class="span5">

                      <div class="form-group">
                          <label>Telephone (Line 2)</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="Telephone2" value="{{Input::old('Telephone2')}}" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Mobile (Line 1)</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="Mobile1" value="{{Input::old('Mobile1')}}" required="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Mobile (Line 2)</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="Mobile2" value="{{Input::old('Mobile2')}}">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Email</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="Email" value="{{Input::old('Email')}}" required="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Website (URL)</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="Url" value="{{Input::old('Url')}}">
                          </div>
                      </div>


                  </div>
              </div>
          </fieldset>

          <fieldset>
              <legend>Contact Person</legend>
              <div class="row">
                  <div class="span5">

                      <div class="form-group">
                          <label>Contact Person</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="ContactPerson" value="{{Input::old('ContactPerson')}}" required="">
                          </div>
                      </div>



                  </div>

                  <div class="span5">

                      <div class="form-group">
                          <label>Designation</label>
                          <div class="input-control text">
                              <input class="form-control" type="text" name="Designation" value="{{Input::old('Designation')}}" required="">
                          </div>
                      </div>


                  </div>
              </div>
          </fieldset>
          <div class="modal-footer">
              <a href="{{route('list.businesses')}}" class="button">Cancel</a>
              <button type="submit" class="button success">Submit</button>
          </div>
      </form>
@endsection

@section('page_js')
@endsection