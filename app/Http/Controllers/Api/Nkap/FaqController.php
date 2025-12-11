<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct(private FaqService $service) {}

    public function poserQuestion(Request $request)
    {
        $data = $request->validate(['question' => 'required|string']);
        return response()->json($this->service->poserQuestion($data['question']));
    }

    public function liste(Request $request)
    {
        return response()->json($this->service->listeParCategorie($request->categorie));
    }
}
