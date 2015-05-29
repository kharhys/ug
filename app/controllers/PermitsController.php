<?php

class PermitsController extends Controller {

  public function services() {
    return View::make('permits.index');
  }

  public function apply() {

    $formID = 2;
    $serviceID = 303;
    $form = ServiceForm::findOrFail($formID);

    return View::make('permits.apply', [ 'ServiceID'=> $serviceID, 'form'=> $form ]);
  }

  public function submitApplication() {
    $input = Input::all();

    $rules = [
        'ColumnID.1' => 'required|string',
        'ColumnID.2' => 'required|numeric',
        'ColumnID.3' => 'required|numeric',
        'ColumnID.4' => 'required|string',
        'ColumnID.6' => 'required|string',
        'ColumnID.8' => 'required|string',
        'ColumnID.117' => 'required|string',
        'ColumnID.120' => 'required|string',
        'ColumnID.123' => 'required|string',
        'ColumnID.129' => 'required|string',
        'ColumnID.130' => 'required|string',
        'ColumnID.132' => 'required|email',
        'ColumnID.133' => 'required|string',
        'ColumnID.156' => 'required|string',
        'ColumnID.157' => 'required|string',
        'ColumnID.158' => 'required|string',
    ];
    $msgs = [
      'ColumnID.1.required' => 'Business Activity Description is required.',
      'ColumnID.1.string' => 'Business Activity Description may only contain letters.',

      'ColumnID.2.required' => 'Business Premise Area (Square Meters) is required.',
      'ColumnID.2.numeric' => 'Business Premise Area (Square Meters) may only contain digits.',

      'ColumnID.3.required' => 'Number of Employees is required.',
      'ColumnID.3.numeric' => 'Number of Employees may only contain digits.',

      'ColumnID.4.required' => 'Other Business Clarification Details  is required.',
      'ColumnID.4.string' => 'Other Business Clarification Details  may only contain letters.',

      'ColumnID.6.required' => 'Business Zone is required.',
      'ColumnID.6.string' => 'Business Zone may only contain letters.',

      'ColumnID.8.required' => 'Ward is required.',
      'ColumnID.8.string' => 'Ward may only contain letters.',

      'ColumnID.117.required' => 'Registrants ID/Passport Number is required.',
      'ColumnID.117.string' => 'Registrants ID/Passport Number may only contain letters.',

      'ColumnID.120.required' => 'SubCounty is required.',
      'ColumnID.120.string' => 'SubCounty may only contain letters.',

      'ColumnID.123.required' => 'Nearest Road is required.',
      'ColumnID.123.string' => 'Nearest Road may only contain letters.',

      'ColumnID.129.required' => 'Postal Address is required.',
      'ColumnID.129.string' => 'Postal Address may only contain letters.',

      'ColumnID.130.required' => 'Postal Code is required.',
      'ColumnID.130.string' => 'Postal Code may only contain letters.',

      'ColumnID.132.required' => 'Email is required.',
      'ColumnID.132.email' => 'Email may only contain letters.',

      'ColumnID.133.required' => 'Website is required.',
      'ColumnID.133.string' => 'Website may only contain letters.',

      'ColumnID.156.required' => 'Business Name is required.',
      'ColumnID.156.string' => 'Business Name may only contain letters.',

      'ColumnID.157.required' => 'Registrants Age is required.',
      'ColumnID.157.string' => 'Registrants Age may only contain letters.',

      'ColumnID.158.required' => 'Registrants Gender is required.',
      'ColumnID.158.string' => 'Registrants Gender may only contain letters.',
    ];
    $valid = Validator::make(Input::all(),$rules, $msgs);
    if ($valid->fails()){
        return Redirect::back()->withErrors($valid);
    }

    $app = new Application();

    $app->FormID = 2;
    $app->ServiceID = 303;
    $app->ServiceStatusID = 1;
    $app->SubmissionDate = date('Y-m-d H:i:s');
    $app->CustomerID = Auth::user()->customerID();

    $app->save();

    $columns = Input::get('ColumnID');
    dd($columns);

    foreach($columns as $key => $value)
    {
        $params['ServiceHeaderID'] = $app->id();
        $params['ColumnID'] = $key;
        $params['Value'] = $value;

        Api::AddFormData($params);

    }

    Session::flash('success_msg','Application sent successfully');
    return Redirect::route('portal.dashboard');

  }

  public function index() {
    $data = DB::table('ServiceHeader')
      ->select(['ServiceHeader.ServiceHeaderID',
            'ServiceHeader.PermitNo as No',
            'Services.ServiceName',
            'ServiceHeader.CreatedDate as Date',
            'ServiceStatus.ServiceStatusDisplay'])
      ->where('ServiceHeader.CustomerID', Auth::user()->customerID())
      ->where('Services.ServiceCategoryID', 2)
      ->join('Customer','Customer.CustomerID','=','ServiceHeader.CustomerID')
      ->join('Services','Services.ServiceID','=','ServiceHeader.ServiceID')
      ->join('ServiceStatus','ServiceStatus.ServiceStatusID','=','ServiceHeader.ServiceStatusID')
      ->get();
    return View::make('permits.applications', ['applications'=> $data]);
  }

  public function renew() {
    $data = DB::table('ServiceHeader')
      ->select(['ServiceHeader.ServiceHeaderID',
            'ServiceHeader.PermitNo as No',
            'Services.ServiceName',
            'ServiceHeader.CreatedDate as Date',
            'ServiceStatus.ServiceStatusDisplay'])
      ->where('ServiceHeader.CustomerID', Auth::user()->customerID())
      ->where('ServiceStatus.ServiceStatusDisplay','Expired Awaiting Renewal')
      ->where('Services.ServiceCategoryID', 2)
      ->join('Customer','Customer.CustomerID','=','ServiceHeader.CustomerID')
      ->join('Services','Services.ServiceID','=','ServiceHeader.ServiceID')
      ->join('ServiceStatus','ServiceStatus.ServiceStatusID','=','ServiceHeader.ServiceStatusID')
      ->get();
    return View::make('permits.renew', ['applications'=> $data]);
  }

  public function extend($ServiceHeaderID) {
    $columns = DB::table('FormData')
      ->where('FormData.ServiceHeaderID', $ServiceHeaderID)
      ->lists('Value', 'FormColumnID');

    $app = new Application();

    $app->FormID = 2;
    $app->ServiceID = 303;
    $app->ServiceStatusID = 1012;
    $app->SubmissionDate = date('Y-m-d H:i:s');
    $app->CustomerID = Auth::user()->customerID();

    $app->save();

    foreach($columns as $key => $value)
    {
        $params['ServiceHeaderID'] = $app->id();
        $params['ColumnID'] = $key;
        $params['Value'] = $value;

        Api::AddFormData($params);

    }

    Session::flash('success_msg','Application sent successfully');
    return Redirect::route('portal.dashboard');
  }

}
