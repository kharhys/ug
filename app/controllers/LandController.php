<?php

class LandController extends BaseController{

    # refactory
    public function services() {
      return View::make('land.index');
    }

    public function search() {
      return View::make('land.search');
    }

    public function submitSearch() {

      $property = DB::table('ServiceHeader as H')
        ->where('H.CustomerID', Auth::user()->CustomerID())
        ->where('F.Value', Input::get('PlotNumber'))
        ->join('Customer as U', 'U.CustomerID', '=', 'H.CustomerID')
        ->join('FormData as F', 'F.ServiceHeaderID', '=', 'H.ServiceHeaderID')
        ->join('FormColumns as C', 'C.FormColumnID', '=', 'F.FormColumnID')
        ->join('ServiceStatus as S', 'S.ServiceStatusID', '=', 'H.ServiceStatusID')
        ->get(['H.CustomerID', 'C.FormColumnName', 'F.Value', 'S.ServiceStatusDisplay', 'H.CreatedDate', 'U.CustomerName', 'U.Email', 'U.Mobile1', 'U.IDNO']);
        //->get();
      //dd($property);
      return View::make('land.show', ['land' => $property[0] ]);
    }

    public function pay() {
      $property = DB::table('ServiceHeader as H')
        ->where('H.CustomerID', Auth::user()->CustomerID())
        ->where('F.FormColumnID', 13)
        ->join('FormData as F', 'F.ServiceHeaderID', '=', 'H.ServiceHeaderID')
        ->join('FormColumns as C', 'C.FormColumnID', '=', 'F.FormColumnID')
        ->join('ServiceStatus as S', 'S.ServiceStatusID', '=', 'H.ServiceStatusID')
        ->get(['C.FormColumnName', 'F.Value', 'S.ServiceStatusName', 'H.SubmissionDate']);
        //->get();
        //dd($property);
      return View::make('land.pay', ['property' => $property ]);

    }

    public function plots() {
      $property = DB::table('ServiceHeader as H')
        ->where('H.CustomerID', Auth::user()->CustomerID())
        ->where('S.ServiceStatusName', 'Approved')
        ->where('F.FormColumnID', 13)
        ->join('FormData as F', 'F.ServiceHeaderID', '=', 'H.ServiceHeaderID')
        ->join('FormColumns as C', 'C.FormColumnID', '=', 'F.FormColumnID')
        ->join('ServiceStatus as S', 'S.ServiceStatusID', '=', 'H.ServiceStatusID')
        ->get(['C.FormColumnName', 'F.Value', 'S.ServiceStatusName', 'H.SubmissionDate']);
        //->get();
      return View::make('land.plots', [ 'property' => $property ]);

    }

    public function invoice($custId) {
      # require customer id :landOwner
      if(is_null(ServiceHeader::where('ServiceID', 1603)->where('CustomerID', $custId)->get()->first())){
       dd('you found something that does not exist');
      }

      $inv = DB::table('ServiceHeader as S')
        ->where('S.CustomerID', $custId)
        ->where('S.ServiceID', 1603)
        ->join('InvoiceLines as I', 'I.ServiceHeaderID', '=', 'S.ServiceHeaderID')
        ->first();

      $invoice = Invoice::findOrFail($inv->InvoiceHeaderID);
      return View::make('land.invoice', ['invoice'=> $invoice]);
    }

    public function register() {

      $formID = 3;
      $serviceID = 1603;
      $form = ServiceForm::findOrFail($formID);

      return View::make('land.register', [ 'ServiceID'=> $serviceID, 'form'=> $form ]);
    }

    public function submitRegistration() {
      $input = Input::all();
      //return Response::json($input);

      $rules = [
          'ColumnID.13' => 'required|numeric',
          'ColumnID.17' => 'required|string',
          'ColumnID.18' => 'required|string',
          'ColumnID.20' => 'required|numeric',
          'ColumnID.21' => 'required|string',
          'ColumnID.23' => 'required|string',
          'ColumnID.24' => 'required|string'
      ];
      $msgs = [
        'ColumnID.13.required' => 'Plot Number is required.',
        'ColumnID.13.string' => 'Plot Number may only contain letters.',
        'ColumnID.17.required' => 'Division/Zone is required.',
        'ColumnID.17.string' => 'Division/Zone may only contain letters.',
        'ColumnID.18.required' => 'Physical Local/Market/Trading Center is required.',
        'ColumnID.18.string' => 'Physical Local/Market/Trading Center may only contain letters.',
        'ColumnID.20.required' => 'Area is required.',
        'ColumnID.20.numeric' => 'Area may only contain numbers.',
        'ColumnID.21.required' => 'Units Of Measure is required.',
        'ColumnID.21.string' => 'Units Of Measure may only contain letters.',
        'ColumnID.23.required' => 'Property Use is required.',
        'ColumnID.23.string' => 'Property Use may only contain letters.',
        'ColumnID.24.required' => 'Nature Of Interest is required.',
        'ColumnID.24.string' => 'Nature Of Interest may only contain letters.'
      ];
      $valid = Validator::make(Input::all(),$rules, $msgs);
      if ($valid->fails()){
          return Redirect::back()
              ->withErrors($valid);
          //return Redirect::route('list.departments');
      }

      $app = new Application();
      $app->FormID = 3;
      $app->ServiceID = 1603;
      $app->ServiceStatusID = 1;
      $app->SubmissionDate = date('Y-m-d H:i:s');
      $app->CustomerID = Auth::user()->customerID();
      $app->save();

      $columns = Input::get('ColumnID');

      foreach($columns as $key => $value)
      {
          $params['ServiceHeaderID'] = $app->id();
          $params['ColumnID'] = $key;
          $params['Value'] = $value;

          Api::AddFormData($params);

      }

      Session::flash('success_msg','Application sent successfully!');
      return Redirect::route('portal.dashboard');
    }

}
