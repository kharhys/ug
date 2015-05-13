<?php

class WeightsController extends Controller {

  public function services() {
    return Redirect::route('weights.apply');
  }

  public function apply() {

    $formID = 11;
    $serviceID = 1348;
    $form = ServiceForm::findOrFail($formID);

    return View::make('weights.apply', [ 'ServiceID'=> $serviceID, 'form'=> $form ]);
  }

  public function submitApplication() {
    $input = Input::all();
    dd($input);

    $rules = [
        'ColumnID.103' => 'required|string',
        'ColumnID.114' => 'required|string',
        'ColumnID.115' => 'required|string',
        'ColumnID.116' => 'required|string'
    ];
    $msgs = [
      'ColumnID.103.required' => 'Banner Size is required.',
      'ColumnID.103.string' => 'Banner Size may only contain letters.',

      'ColumnID.114.required' => 'Town is required.',
      'ColumnID.114.string' => 'Town may only contain letters.',

      'ColumnID.115.required' => 'Location is required.',
      'ColumnID.115.string' => 'Location may only contain letters.',

      'ColumnID.116.required' => 'Street is required.',
      'ColumnID.116.string' => 'Street may only contain letters.',
    ];
    $valid = Validator::make(Input::all(),$rules, $msgs);
    if ($valid->fails()){
        return Redirect::back()->withErrors($valid);
    }

    $app = new Application();

    $app->FormID = 10;
    $app->ServiceStatusID = 1;
    $app->CustomerID = Auth::id();
    $app->ServiceID = Input::get('service');
    $app->SubmissionDate = date('Y-m-d H:i:s');

    $app->save();

    $columns = Input::get('ColumnID');

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

  public function renew() {
    $data = DB::table('ServiceHeader')
      ->select(['ServiceHeader.ServiceHeaderID',
            'ServiceHeader.PermitNo as No',
            'Services.ServiceName',
            'ServiceHeader.CreatedDate as Date',
            'ServiceStatus.ServiceStatusDisplay'])
      ->where('ServiceHeader.CustomerID', Auth::id())
      ->where('Services.ServiceCategoryID', 2)
      ->join('Customer','Customer.CustomerID','=','ServiceHeader.CustomerID')
      ->join('Services','Services.ServiceID','=','ServiceHeader.ServiceID')
      ->join('ServiceStatus','ServiceStatus.ServiceStatusID','=','ServiceHeader.ServiceStatusID')
      ->get();
    return View::make('permits.applications', ['applications'=> $data]);
  }

}
