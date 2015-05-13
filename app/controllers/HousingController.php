<?php
class HousingController extends BaseController{

    public function services() {
      return Redirect::route('housing.home');
    }

    public function home() {

      $formID = 5;
      $form = ServiceForm::findOrFail($formID);
      return View::make('housing.home', ['form'=> $form ]);
    }

    public function stall() {

      $formID = 13;
      $form = ServiceForm::findOrFail($formID);
      return View::make('housing.stall', ['form'=> $form ]);
    }

    public function applications() {

      $data = DB::table('ServiceHeader')
        ->select(['ServiceHeader.ServiceHeaderID',
              'ServiceHeader.PermitNo as No',
              'Services.ServiceName',
              'ServiceHeader.CreatedDate as Date',
              'ServiceStatus.ServiceStatusDisplay'])
        ->where('ServiceHeader.CustomerID', Auth::id())
        ->where('Services.ServiceCategoryID', 80)
        ->join('Customer','Customer.CustomerID','=','ServiceHeader.CustomerID')
        ->join('Services','Services.ServiceID','=','ServiceHeader.ServiceID')
        ->join('ServiceStatus','ServiceStatus.ServiceStatusID','=','ServiceHeader.ServiceStatusID')
        ->get();
      return View::make('housing.applications', ['applications'=> $data]);
    }

    public function submitApproval() {
      $input = Input::all();

      $rules = [
          'form'=>'required:exits:Form,FormID',
          'ServiceNo'=>'required|exists:Services,ServiceID',
          'CustomerID'=>'required|exists:Customer,CustomerID',
          'ColumnID.44' => 'required|string',
          'ColumnID.45' => 'required|string',
          'ColumnID.46' => 'required|string',
          'ColumnID.47' => 'required|string',
          'ColumnID.48' => 'required|numeric',
          'ColumnID.50' => 'required|string',
          'ColumnID.51' => 'required|numeric'
      ];
      $msgs = [
        'ColumnID.44.required' => 'What is your Occupation now? is required.',
        'ColumnID.44.string' => 'What is your Occupation now? may only contain letters.',
        'ColumnID.45.required' => 'Who is your employer? is required.',
        'ColumnID.45.string' => 'Who is your employer? may only contain letters.',
        'ColumnID.46.required' => 'If employed what is your designation? is required.',
        'ColumnID.46.string' => 'If employed what is your designation? may only contain letters.',
        'ColumnID.47.required' => 'Where is your Accomodation Now? is required.',
        'ColumnID.47.string' => 'Where is your Accomodation Now? may only contain letters.',
        'ColumnID.48.required' => 'What rent are you paying per Month is required.',
        'ColumnID.48.numeric' => 'What rent are you paying per Month may only contain numeric digits.',
        'ColumnID.50.required' => 'Who is to pay Rent? is required.',
        'ColumnID.50.string' => 'Who is to pay Rent? may only contain letters.',
        'ColumnID.51.required' => 'How long have you lived in Uasin Gishu county? is required.',
        'ColumnID.51.numeric' => 'How long have you lived in Uasin Gishu county? may only contain numeric digits.'
      ];
      
      $valid = Validator::make(Input::all(),$rules, $msgs);
      if ($valid->fails()){
          return Redirect::back()->withErrors($valid);
      }

      $app = new Application();

      $app->FormID = 10;
      $app->ServiceID = 510;
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

      Session::flash('success_msg','Application sent successfully');
      return Redirect::route('list.departments');
    }

}
