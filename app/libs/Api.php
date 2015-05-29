<?php
/**
 * Created by PhpStorm.
 * User: SSL
 * Date: 2/24/2015
 * Time: 2:58 PM
 */


class Api {
    /**
     * @param array $params
     * @return mixed|static
     */
    public static function CustomerProfileID($params = array())
    {
        if (Auth::id()){
            return Auth::user()->CustomerProfileID;
        }else{
            $status = CustomerProfileStatus::findOrFail(1);
            $profile = new CustomerProfile();
            $profile->CreatedBy = $params['CreatedBy'];
            $profile->CustomerProfileStatusID = $status->id();

            $profile->save();
            #dd($profile);

            return $profile->id();
        }


    }

    /**
     *
     * Find user by key
     * @param $key
     * @param $value
     * @return bool
     */

    public static function FindUserBy($key,$value)
    {
        $user = User::where($key ,'=',$value)->first();

        if ($user){
            return $user;
        }

        return false;
    }

    /**
     * upload given file to specific destination
     * @param $file
     * @param array $params
     * @return bool|string
     */

    public static function upload($file,$params = array())
    {
        if(isset($file)){
          $extension = $file->getClientOriginalExtension();
          $name = Auth::id().'-'.Api::clean($params['name']).'.'.$extension;
          if ($file->move(public_path().$params['path'], $name)){
              return $params['path'].'/'.$name;
          }

          return false;
        }
    }

    /**
     * Remove unwanted characters from string
     * @param $string
     * @return mixed
     */
    public static function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    /**
     * Send mail
     * @param $template
     * @param $data
     */
    public static function sendMail($template,$data)
    {
        Mail::queue('emails.'.$template, $data, function($m) use ($data) {
            $m->to($data['email'])
                ->subject($data['subject']);
        });
    }

    /**
     * Diplay status label
     * @param $var
     * @param $true
     * @param $false
     * @return string
     */
    public static function status($var,$true,$false){
        if ($var){
            return '<span class="label label-sm label-success">'.$true.'</span>';

        }

        return '<span class="label label-sm label-warning">'.$false.'</span>';
    }

    public static function RandomBackgroundColor(){
        $colors = [
            'lime','green','emerald','teal','cyan','cobalt','indigo','violet',
            'pink','magenta','crimson','red','orange','amber','yellow','brown','olive','steel',
            'mauve','taupe','gray','dark','darker','darkBrown','darkCrimson','darkMagenta',
            'darkIndigo','darkCyan','darkCobalt','darkTeal','darkEmerald','darkGreen','darkOrange','darkRed','darkPink','darkViolet',
            'darkBlue','lightBlue','lightTeal','lightOlive','lightOrange','lightPink','lightRed','lightGreen'
        ];
        $max = count($colors);

        $index =  rand(0,$max -1);

        return $colors[$index];
    }

    public static function FormFieldTemplate($label,$columnWidth,$fieldClass,$field){
        echo  "
            <div class='form-group'>
                <label class='label'>$label</label>
                <div class='input-control $fieldClass'>
                    $field
                </div>
            </div>
        ";
    }

    public static function FieldTemplate($label,$columnWidth,$fieldClass,$field){
        echo  "
            <div class='field'>
                <label>$label</label>
                $field
            </div>
        ";
    }

    public static function ResultArray($q)
    {
        $query = str_replace("#ID","0" ,$q);
        $result = DB::select($query);
        $vars = (array)$result;
        $values[] = [0 => 'select'];
        foreach ($vars as $var){
            //convert object class to array;
            $object = (array)$var;

            //get an array list of the values
            $list = array_values($object);

            //create an array index of values
            $values[] = [$list[0]=>$list[1]];
        }
        //$it = new RecursiveIteratorIterator(new RecursiveArrayIterator($values));
        $vals = [];
        if($values) {
          foreach($values as $v) {
            //array_push($vals, $v);
            foreach($v as $key => $val) {
              $vals[$key] = $val;
            }
          }
        }

        return ($vals);
    }
    public  static function CreateFormField($columnId)
    {
        $col = FormColumns::find($columnId);
        $dataType = $col->dataType;

        switch ($dataType){
            case "Text":
                $field = Form::text("ColumnID[".$col->id()."]",Input::old($col->id()),['class'=>'form-control', 'id' => $col->id()]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'text';
                break;
            case "Number":
                $field = Form::number("ColumnID[".$col->id()."]",Input::old($col->id()),['class'=>'form-control', 'id' => $col->id()]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'number';
                break;
            case 'Option':
                $values = Api::ResultArray($col->Notes);
                $field = Form::select("ColumnID[".$col->id()."]",$values,Input::old($col->id()),['class'=>'form-control', 'id' => $col->id()]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'select';
                break;
            case 'OptionCommaSeparated':
                $values = explode(',',$col->Notes);
                $field = Form::select("ColumnID[".$col->id()."]",$values,Input::old($col->id()),['class'=>'form-control', 'id' => $col->id()]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'select';
                break;
            default:
                $field = Form::text("ColumnID[".$col->id()."]",Input::old($col->id()),['class'=>'form-control', 'id' => $col->id()]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'text';
                break;
        }

        return Api::FormFieldTemplate($label,$width,$class,$field);
    }

    public  static function CustomFormField($columnId)
    {
        $col = FormColumns::find($columnId);
        $dataType = $col->dataType;

        switch ($dataType){
            case "Text":
                $field = Form::text("ColumnID[".$col->id()."]",Input::old($col->id()),['class'=>'', 'id' => $col->id()]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'text';
                break;
            case "Textarea":
                $field = Form::textarea("ColumnID[".$col->id()."]",Input::old($col->id()),['class'=>'', 'id' => $col->id()]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'text';
                break;
            case "Number":
                $field = Form::number("ColumnID[".$col->id()."]",Input::old($col->id()),['class'=>'form-control', 'id' => $col->id()]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'number';
                break;
            case 'Option':
                $listener = '';
                if (!$col->FilterColumnID == null && !$col->FilterColumnID == 0) {
                  $listener = 'filterSelect(this.value,'.$col->FilterColumnID.')';
                }
                $values = Api::ResultArray($col->Notes);
                $field = Form::select("ColumnID[".$col->id()."]",$values,Input::old($col->id()),['class'=>'ui dropdown', 'id' => $col->id(), 'onChange' => $listener ]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'select';
                break;
            case 'OptionCommaSeparated':
                $values = explode(',',$col->Notes);
                $field = Form::select("ColumnID[".$col->id()."]",$values,Input::old($col->id()),['class'=>'form-control', 'id' => $col->id()]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'select';
                break;
            default:
                $field = Form::text("ColumnID[".$col->id()."]",Input::old($col->id()),['class'=>'form-control', 'id' => $col->id()]);
                $label = $col;
                $width = $col->ColumnSize;
                $class = 'text';
                break;
        }

        return Api::FieldTemplate($label,$width,$class,$field);
    }

    public static function AddFormData($params= array())
    {
        $data = new FormData();
        $data->FormColumnID = $params['ColumnID'];
        $data->ServiceHeaderID = $params['ServiceHeaderID'];
        $data->Value = $params['Value'];
        $data->CreatedDate = date('Y-m-d H:i:s');
        $data->CreatedBy = Auth::id();
        $data->save();

        if ($data->FormDataID){
            return true;
        }

        return false;

    }

    public static function showLogo($class=null,$height=100,$width=100)
    {
        return '<img class="'.$class.'" src="'.asset('images/ug-logo.png').'" height="'.$height.'" width="'.$width.'" />';
    }

    public static function stampPaid($class=null,$height = 100,$width=100)
    {
        return '<img class="'.$class.'" src="'.asset('images/stamp-paid.png').'" height="'.$height.'" width="'.$width.'" />';
    }

}
