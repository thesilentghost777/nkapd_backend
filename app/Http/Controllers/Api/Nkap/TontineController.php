<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\TontineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TontineController extends Controller
{
    public function __construct(private TontineService $service) {}

    public function creer(Request $request)
    {
        try {
            $data = $request->validate([
                'nom' => 'required|string|max:100',
                'prix' => 'required|numeric|min:1000',
                'nombre_membres' => 'required|integer|min:2|max:100',
            ]);

            $result = $this->service->creer($request->user(), $data);

            return response()->json($result, $result['success'] ? 200 : 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur création tontine', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création',
            ], 500);
        }
    }

    public function rejoindre(Request $request)
    {
        try {
            $data = $request->validate(['code' => 'required|string']);

            Log::info('🔵 Controller rejoindre - Début', [
                'user_id' => $request->user()->id,
                'code' => $data['code'],
            ]);

            $result = $this->service->rejoindre($request->user(), $data['code']);

            Log::info('🟢 Controller rejoindre - Résultat', [
                'success' => $result['success'],
                'message' => $result['message'] ?? '',
            ]);

            return response()->json($result, $result['success'] ? 200 : 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('🔴 Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Code invalide',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('🔴 Erreur rejoindre tontine', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'adhésion: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function rechercher($code)
    {
        try {
            $result = $this->service->rechercher($code);
            return response()->json($result, $result['success'] ? 200 : 404);
        } catch (\Exception $e) {
            Log::error('Erreur recherche tontine', [
                'error' => $e->getMessage(),
                'code' => $code,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche',
            ], 500);
        }
    }

    public function mesCreations(Request $request)
    {
        try {
            $result = $this->service->mesTontinesCreees($request->user());
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Erreur récupération créations', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération',
            ], 500);
        }
    }

    public function mesAdhesions(Request $request)
    {
        try {
            $result = $this->service->mesTontinesRejointes($request->user());
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Erreur récupération adhésions', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération',
            ], 500);
        }
    }

    public function details($id, Request $request)
    {
        try {
            $result = $this->service->details($id, $request->user());
            return response()->json($result, $result['success'] ? 200 : 404);
        } catch (\Exception $e) {
            Log::error('Erreur récupération détails', [
                'error' => $e->getMessage(),
                'tontine_id' => $id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération',
            ], 500);
        }
    }
}
