<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Counters;
use App\Phones;
use App\Currencies;
use App\Email;
use App\ServiceFiles;

class SettingsController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

//  service files settings
    public function serviceFiles()
    {
        $serviceFiles = ServiceFiles::get();
        return view('admin/settings/serviceFiles', ['serviceFiles' => $serviceFiles]);
    }

    public function addServiceFile()
    {
        return view('admin/settings/showServiceFile');
    }

    public function updateServiceFile()
    {
        $input = \Request::all();

        if(isset($input['file']) && $input['file']->getSize() > 0 && $input['file']->getSize() < 8388608){
            $file = array_get($input, 'file');
            $file_uploaded = ServiceFiles::uploadServiceFile($file);
        }else{
            $file_uploaded = false;
        }

        if($input['id']){
            if($file_uploaded){
                $input['filename'] = $input['file']->getClientOriginalName();
            }
            unset($input['file']);
            ServiceFiles::find($input['id'])->update($input);
        }else{
            if($file_uploaded){
                $input['filename'] = $input['file']->getClientOriginalName();
                unset($input['file']);
                ServiceFiles::create($input);
            }
        }

        return \Redirect::action('Admin\SettingsController@serviceFiles');
    }

    public function deleteServiceFile($id)
    {
        if($id){
            $serviceFile = ServiceFiles::find($id);
            if($serviceFile['filename'] && file_exists($_SERVER['DOCUMENT_ROOT'] .'/' .$serviceFile['filename'])){
                unlink($_SERVER['DOCUMENT_ROOT'] .'/' .$serviceFile['filename']);
            }
            ServiceFiles::destroy($id);
        }
        return \Redirect::action('Admin\SettingsController@serviceFiles');
    }
    
//    public function uploadServiceFile()
//    {
//        $input = \Request::all();
//        $serviceFiles = ServiceFiles::get();
//        return view('admin/settings/servicefiles', ['serviceFiles' => $serviceFiles]);
//    }


//    counter settings
    public function counters()
    {
        $counters = Counters::get();
        return view('admin/settings/counters', ['counters' => $counters]);
    }

    public function addCounter()
    {
        return view('admin/settings/showCounter');
    }

    public function showCounter($id)
    {
        if($id){
            $counter = Counters::find($id);
        }
        return view('admin/settings/showCounter', ['counter' => $counter]);
    }

    public function updateCounter()
    {
        $input = \Request::all();

        if ($input['id']) {
            Counters::find($input['id'])->update($input);
//            $counter['id'] = $input['id'];
        } else {
//            $counter['id'] = Counters::create($input);
            Counters::create($input);
        }
        
        return \Redirect::action('Admin\SettingsController@counters');
    }

    public function deleteCounter($id)
    {
        if($id){
            Counters::destroy($id);
        }
        return \Redirect::action('Admin\SettingsController@counters');
    }

    
//    phones settings
    public function phones()
    {
        $phones = Phones::get();
        return view('admin/settings/phones', ['phones' => $phones]);
    }
    
    public function addPhone()
    {
        return view('admin/settings/addPhone');
    }

    public function insertPhone()
    {
        $input = \Request::all();   
        Phones::create($input);
        return \Redirect::action('Admin\SettingsController@phones');
    }

    public function deletePhone($id)
    {
        Phones::destroy($id);
        return \Redirect::action('Admin\SettingsController@phones');

    }


    //    currencies settings
    public function currencies()
    {
        $currencies = Currencies::get();
        return view('admin/settings/currencies', ['currencies' => $currencies]);
    }

    public function addCurrency()
    {
        $currency = [];
        $currency['id'] = '';
        return view('admin/settings/showCurrency', ['currency' => $currency]);
    }

    public function showCurrency($id = '')
    {
        if ($id != '') {
            $currency = Currencies::find($id);
        } else {
            $currency = [];
            $currency['id'] = '';
        }
        return view('admin/settings/showCurrency', ['currency' => $currency]);
    }

    public function updateCurrency()
    {
        $input = \Request::all();

        if ($input['id']) {
            Currencies::find($input['id'])->update($input);
            $currency['id'] = $input['id'];
        } else {
            $currency['id'] = Currencies::create($input);
        }

//        return \Redirect::action('Admin\SettingsController@showCurrency', ['id' => $currency['id']]);
        return \Redirect::action('Admin\SettingsController@currencies');
    }

    public function deleteCurrency($id)
    {
        $currency = Currencies::find($id);
        Currencies::destroy($id);

        if ($currency['default']) {
            Currencies::all()->first()->update(['default' => true]);
        }

        return \Redirect::action('Admin\SettingsController@currencies');
    }

    public function updateDefaultCurrency()
    {
        $input = \Request::all();
        Currencies::where('name', '=', $input['default-currency'])->first()->update(['default' => true]);
        Currencies::where('name', '!=', $input['default-currency'])->update(['default' => false]);

        return \Redirect::action('Admin\SettingsController@currencies');
    }
    
    //    email settings
    public function email()
    {
        $emails = Email::get();
        return view('admin/settings/email', ['emails' => $emails]);
    }

    public function addEmail()
    {
        $email = [];
        $email['id'] = '';
        return view('admin/settings/showEmail', ['email' => $email]);
    }

    public function showEmail($id = '')
    {
        if ($id != '') {
            $email = Email::find($id);
        } else {
            $email = [];
            $email['id'] = '';
        }
        return view('admin/settings/showEmail', ['email' => $email]);
    }

    public function updateEmail()
    {
        $input = \Request::all();

        if ($input['id']) {
            $email = Email::find($input['id'])->update($input);
///            $email['id'] = $input['id'];
        } else {
            Email::create($input);
        }

        return \Redirect::action('Admin\SettingsController@email');
    }

    public function deleteEmail($id)
    {
        Email::destroy($id);
        return \Redirect::action('Admin\SettingsController@email');
    }

    public function getCurrencies()
    {
        $currencies = Currencies::get();

        $arr = [];
        if($currencies->count()){
            foreach($currencies as $value){
                $arr[$value->name] = $value->rate;
            }
        }
        return $arr;
    }


}
