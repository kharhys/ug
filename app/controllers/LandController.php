<?php
class LandController extends BaseController{

    public function index() {
      $land = House::where('ServiceID', 389)->lists('HouseNo','HouseID');
      return View::make('landrates', [ 'land'=> $land ]);
    }

    public function register() {
        $rules = [
            'form'=>'required:exits:Form,FormID',
            'ServiceNo'=>'required|exists:Services,ServiceID'
        ];
        $valid = Validator::make(Input::all(),$rules);
        if ($valid->fails()){
            return Redirect::route('list.departments');
        }
        $id = Input::get('form');


        $form = ServiceForm::findOrFail(intval($id));
        //dd($form->sections());
        //$myBusiness = Business::MyBusinesses(Auth::user()->CustomerProfileID)->lists('CustomerName','CustomerID');

        return View::make('land.register',[ 'ServiceID'=>Input::get('ServiceNo'), 'FormID'=>$id, 'form'=>$form ]);
    }

    public function submitRegistration() {
      $input = Input::all();
      //dd($input);
      //return Response::json($input);

      $rules = [
          'FormID'=>'required:exits:Form,FormID',
          'ServiceID'=>'required|exists:Services,ServiceID',
          'CustomerID'=>'required|exists:Customer,CustomerID',
          'ColumnID.134' => 'required|numeric',
          'ColumnID.135' => 'required|numeric',
          'ColumnID.136' => 'string',
          'ColumnID.137' => 'required|string',
          'ColumnID.138' => 'required|string',
          'ColumnID.139' => 'required|numeric',
          'ColumnID.140' => 'required|numeric',
          'ColumnID.141' => 'required|numeric',
          'ColumnID.142' => 'required|numeric',
          'ColumnID.143' => 'required|email'
      ];
      $msgs = [
        'ColumnID.134.required' => 'Title Number is required.',
        'ColumnID.134.numeric' => 'Title Number may only contain numeric digits.',
        'ColumnID.135.required' => 'Approximate Area (Square Meters) is required.',
        'ColumnID.135.string' => 'Approximate Area (Square Meters) may only contain numeric digits.',
        'ColumnID.136.string' => 'Registry Map Street (If Applicable) may only contain letters.',
        'ColumnID.137.required' => 'Names are required.',
        'ColumnID.137.string' => 'Names may only contain letters.',
        'ColumnID.138.required' => 'ID/Passport/Certificate of registratio is required.',
        'ColumnID.138.string' => 'ID/Passport/Certificate of registratio may only contain letters.',
        'ColumnID.139.required' => 'KRA PIN is required.',
        'ColumnID.139.numeric' => 'KRA PIN may only contain numeric digits.',
        'ColumnID.140.required' => 'Postal Address is required.',
        'ColumnID.140.numeric' => 'Postal Address may only contain numeric digits.',
        'ColumnID.141.required' => 'Postal Code is required.',
        'ColumnID.141.numeric' => 'Postal Code may only contain numeric digits.',
        'ColumnID.142.required' => 'Mobile Phone Number is required.',
        'ColumnID.142.numeric' => 'Mobile Phone Number may only contain numeric digits.',
        'ColumnID.143.required' => 'Email is required.',
        'ColumnID.143.email' => 'Email should be a valid email address.'
      ];
      $valid = Validator::make(Input::all(),$rules, $msgs);
      if ($valid->fails()){
          return Redirect::back()
              ->withErrors($valid);
          //dd($input);
          //return Redirect::route('list.departments');
      }

      $app = new Application();
      $app->CustomerID = Input::get('CustomerID');
      $app->ServiceID = Input::get('ServiceNo');
      $app->FormID = Input::get('form');
      $app->SubmissionDate = date('Y-m-d H:i:s');
      $app->ServiceStatusID = 1;
      $app->save();

      $columns = Input::get('ColumnID');

      foreach($columns as $key => $value)
      {
          $params['ServiceHeaderID'] = $app->id();
          $params['ColumnID'] = $key;
          $params['Value'] = $value;

          Api::AddFormData($params);

      }

      if (Input::hasFile('ServiceDocument')){
          $files = Input::file('ServiceDocument');
          foreach ($files as $key=> $value){
              $path =false;
              $doc = FormDocument::find($key);
              $params['file'] = $value;
              $params['path'] = Application::$url;
              $params['name'] = $doc->type;
              $path = Api::upload($value,$params);

              if ($path){
                  $upload = new ServiceDocument();
                  $upload->ServiceDocumentName = $doc->type;
                  $upload->ServiceHeaderID = $app->id();
                  $upload->FileName = $path;
                  $upload->CreatedDate = date('Y-m-d H:i:s');
                  $upload->CreatedBy = Auth::id();
                  $upload->save();
              }
          }
      }

      Session::flash('success_msg','Application sent successfully');
      return Redirect::route('list.departments');
    }

}
