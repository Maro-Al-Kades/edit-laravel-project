<?php

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

# Client Pages
Route::get('apply' , function(){
    $areas = \App\Models\Area::all();
    $codes  = \App\Models\Code::all();
    return view('client.apply' , [
        'areas' => $areas,
        'codes' => $codes,
    ]);
});

Route::post('apply' , [ClientController::class , 'apply'])->name('apply');

Route::get('apply/applying/{client:phone}' , function(Client $client){
    if($client->status != 'طلب جديد')
        return redirect()->route('homepage');
    return view('client.apply-applying' , ['client' => $client]);
})->name('apply.applying');

Route::get('apply/progress/{client:phone}' , function(Client $client){
    if($client->status != 'تحت المتابعة')
        return redirect()->route('homepage');
    return view('client.apply-progress' , ['client' => $client]);
})->name('apply.progress');

Route::get('apply/contract/{client:phone}' , function(Client $client){
    if($client->status != 'إنشاء عقد')
        return redirect()->route('homepage');
    return view('client.apply-contract' , ['client' => $client]);
})->name('apply.contract');

Route::post('apply/contract/{client:phone}' , [ClientController::class , 'apply_contract'])->name('apply-contract');

Route::get('apply/success/{client:phone}' , function(Client $client){
    if($client->status != 'تم التعاقد')
        return redirect()->route('homepage');
    return view('client.apply-success' , ['client' => $client]);
})->name('apply.success');

Route::get('apply/transfer/{client:phone}' , function(Client $client){
    if($client->status != '⁠عميل متمم')
        return redirect()->route('homepage');
    return view('client.apply-transfer' , ['client' => $client]);
})->name('apply.transfer');

Route::post('client/progress' , function(Request $r){
    $r->validate([
        'phone' => 'required|exists:clients,phone'
    ]);

    $client = \App\Models\Client::where('phone' , $r->phone)->first();

    switch($client->status){
        case 'طلب جديد':
            return redirect()->route('apply.applying' , ['client' => $client]);
            break;
        case 'تحت المتابعة':
            return redirect()->route('apply.progress' , ['client' => $client]);
            break;
        case 'إنشاء عقد':
            return redirect()->route('apply.contract' , ['client' => $client]);
            break;
        case 'تم التعاقد':
            return redirect()->route('apply.success' , ['client' => $client]);
            break;
        case '⁠عميل متمم':
            return redirect()->route('apply.transfer' , ['client' => $client]);
            break;
    }

})->name('client.progress');


# Redirect To Whatsapp
Route::get('whatsapp-admin' , function($phone , $msg){
    return 'Done';
})->name('whatsapp-admin');


// Api
Route::get('cities/{area}' , function($area){
    $html = "<option value='' @selected(null == old('city'))>اختر المدينة</option>";
    $cities = \App\Models\City::where('area_id' , $area)->get();

    foreach($cities as $city){
        $html .= "<option value='{$city->id}'>" . $city->name . "</option>";
    }
    return $html;
});
