<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function apply(Request $r)
    {
        $r->validate([
            'phone' => [
                'required',
                'unique:clients,phone',
                'regex:/^[1-9]\d*$/', // التأكد من أن الرقم لا يبدأ بصفر
            ],
            'name' => ['required', 'regex:/^[\pL\s]+$/u', 'min:4'], // التحقق من الاسم الرباعي
            'n_shares' => 'required',
            'area' => 'required',
            'city' => 'required',
            'email' => ['required', 'email'], // التحقق من صحة البريد الإلكتروني
        ]);

        $nameWords = explode(' ', trim($r->name));
        if (count($nameWords) < 4) {
            return back()->withErrors(['name' => 'يجب إدخال الاسم الرباعي.']);
        }
        $client = new Client;

        $client->phone = $r->code.$r->phone;
        $client->name = $r->name;
        $client->email = $r->email;
        $client->n_shares = $r->n_shares;
        $client->area_id = $r->area;
        $client->city_id = $r->city;
        $client->status = 'طلب جديد';

        $client->save();

        return back()->with([
            'message' => 'تم التقديم بنجاح',
        ]);
    }

    public function apply_contract(Request $r, Client $client)
    {

        $r->validate([
            'fullname' => 'required',
            'identity' => 'required',
            'iban' => 'required',
            'bank' => 'required',
            'profession' => 'required',
            'birth' => 'required',
            'n_shares' => 'required',
        ]);

        $client->fullname = $r->fullname;
        $client->identity = $r->identity;
        $client->iban = $r->iban;
        $client->bank = $r->bank;
        $client->profession = $r->profession;
        $client->birth = $r->birth;
        $client->n_shares = $r->n_shares;

        $client->save();
    }
}
