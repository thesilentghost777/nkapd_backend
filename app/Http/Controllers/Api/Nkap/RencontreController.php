<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\RencontreService;
use Illuminate\Http\Request;

class RencontreController extends Controller
{
    public function __construct(private RencontreService $service) {}

    public function creerAnnonce(Request $request) { return response()->json($this->service->creerAnnonce($request->user(), $request->all())); }
    public function mesAnnonces(Request $request) { return response()->json($this->service->mesAnnonces($request->user())); }
    public function profilsAmoureuse(Request $request) { return response()->json($this->service->profilsAmoureuse($request->user())); }
    public function annoncesBusiness() { return response()->json($this->service->annoncesBusiness()); }
    public function annoncesAutre() { return response()->json($this->service->annoncesAutre()); }
    public function contacter($userId, Request $request) { return response()->json($this->service->contacter($request->user(), $userId, $request->message)); }
}
