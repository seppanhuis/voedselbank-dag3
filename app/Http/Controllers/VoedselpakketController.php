<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gezin;

class VoedselpakketController extends Controller
{
    public function index(Request $request)
    {
        $eetwens = $request->input('eetwens');
        $gezinnen = Gezin::getGezinnenMetVoedselpakketten($eetwens);
        return view('voedselpakket.index', compact('gezinnen', 'eetwens'));
    }
}
