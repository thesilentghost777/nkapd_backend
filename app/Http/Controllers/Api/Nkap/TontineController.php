<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\TontineService;
use Illuminate\Http\Request;

class TontineController extends Controller
{
    public function __construct(private TontineService $service) {}

    public function creer(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'prix' => 'required|numeric|min:1000',
            'nombre_membres' => 'required|integer|min:2|max:100',
        ]);

        return response()->json($this->service->creer($request->user(), $data));
    }

    public function rejoindre(Request $request)
    {
        $data = $request->validate(['code' => 'required|string']);
        return response()->json($this->service->rejoindre($request->user(), $data['code']));
    }

    public function rechercher($code)
    {
        return response()->json($this->service->rechercher($code));
    }

    public function mesCreations(Request $request)
    {
        return response()->json($this->service->mesTontinesCreees($request->user()));
    }

    public function mesAdhesions(Request $request)
    {
        return response()->json($this->service->mesTontinesRejointes($request->user()));
    }

    public function details($id, Request $request)
    {
        return response()->json($this->service->details($id, $request->user()));
    }
}
