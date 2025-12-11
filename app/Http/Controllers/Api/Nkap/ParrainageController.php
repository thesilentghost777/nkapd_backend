<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\ParrainageService;
use Illuminate\Http\Request;

class ParrainageController extends Controller
{
    public function __construct(private ParrainageService $service) {}

    public function statistiques(Request $request)
    {
        return response()->json($this->service->statistiques($request->user()));
    }

    public function filleuls(Request $request)
    {
        return response()->json($this->service->listeFilleuls($request->user()));
    }

    public function verifierCode(Request $request)
    {
        $data = $request->validate(['code' => 'required|string']);
        return response()->json($this->service->verifierCode($data['code']));
    }
}
