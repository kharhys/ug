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
      $rules = [
          'PlotNumber'=>'required|exists:Property,PlotNumber'
      ];
      $valid = Validator::make(Input::all(),$rules);
      if ($valid->fails()){
          return Redirect::back();
      }

      $land = DB::table('Property as P')
        ->where('PlotNumber',Input::get('PlotNumber'))
        ->join('Customer as C', 'C.CustomerSupplierID', '=', 'P.CustomerSupplierID')
        ->join('InvoiceHeader as IH', 'IH.CustomerID', '=', 'C.CustomerID')
        ->get(['P.UPN', 'P.BlockLRNumber', 'P.PlotNumber', 'P.DocumentNumber', 'P.LandRates',
               'P.OtherCharges', 'P.TotalAnnualAmount', 'P.TotalArrears', 'P.AccumulatedPenalty',
               'P.CurrentBalance', 'P.CoOwner', 'C.CustomerName', 'C.Mobile1', 'C.IDNO',  'C.CustomerID']);
      return View::make('land.show', ['land' => $land[0] ]);
    }

    public function pay() {
      $property = DB::table('Customer as C')
        ->where('C.CustomerID', Auth::id())
        ->join('Property as P', 'P.CustomerSupplierID', '=', 'C.CustomerSupplierID')
        ->get(['P.PlotNumber', 'P.LastPaymentDate', 'P.LastBillDueDate', 'P.CurrentBalance', 'P.PhysicalAddress']);
      return View::make('land.pay', ['property' => $property ]);

    }

    public function invoice($custId) {
      # require customer id :landOwner
      if(is_null(ServiceHeader::where('ServiceID', 1606)->where('CustomerID', $custId)->get()->first())){
       dd('you found something that does not exist');
      }

      $inv = DB::table('ServiceHeader as S')
        ->where('S.CustomerID', $custId)
        ->where('S.ServiceID', 1606)
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
          'ColumnID.19' => 'required|numeric',
          'ColumnID.20' => 'required|numeric',
          'ColumnID.21' => 'required|string',
          'ColumnID.22' => 'required|string',
          'ColumnID.23' => 'required|string',
          'ColumnID.24' => 'required|string'
      ];
      $msgs = [
        'ColumnID.13.required' => 'Plot Number is required.',
        'ColumnID.13.numeric' => 'Plot Number may only contain numeric digits.',
        'ColumnID.17.required' => 'Division/Zone is required.',
        'ColumnID.17.string' => 'Division/Zone may only contain letters.',
        'ColumnID.18.required' => 'Physical Local/Market/Trading Center is required.',
        'ColumnID.18.string' => 'Physical Local/Market/Trading Center may only contain letters.',
        'ColumnID.19.required' => 'Measurements is required.',
        'ColumnID.19.numeric' => 'Measurements may only contain numbers.',
        'ColumnID.20.required' => 'Area is required.',
        'ColumnID.20.numeric' => 'Area may only contain numbers.',
        'ColumnID.21.required' => 'Units Of Measure is required.',
        'ColumnID.21.string' => 'Units Of Measure may only contain letters.',
        'ColumnID.22.required' => 'Roll Type is required.',
        'ColumnID.22.string' => 'Roll Type may only contain letters.',
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
      $app->CustomerID = Auth::id();
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

      Session::flash('success_msg','Application sent successfully!');
      return Redirect::route('portal.dashboard');
    }

}
