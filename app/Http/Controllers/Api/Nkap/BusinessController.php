<?php

namespace App\Http\Controllers\Api\Nkap;

use App\Http\Controllers\Controller;
use App\Services\Nkap\BusinessService;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function __construct(private BusinessService $service) {}

    public function liste(Request $request)
    {
        try {
            return response()->json(
                $this->service->listeProduits($request->all())
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des produits',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function creer(Request $request)
    {
        try {
            $result = $this->service->creerProduit($request->user(), $request->all());
            $status = $result['success'] ? 201 : 400;
            return response()->json($result, $status);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function details($id)
    {
        try {
            $result = $this->service->detailsProduit($id);
            $status = $result['success'] ? 200 : 404;
            return response()->json($result, $status);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function modifier($id, Request $request)
    {
        try {
            $result = $this->service->modifierProduit($request->user(), $id, $request->all());
            $status = $result['success'] ? 200 : 400;
            return response()->json($result, $status);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function supprimer($id, Request $request)
    {
        try {
            $result = $this->service->supprimerProduit($request->user(), $id);
            $status = $result['success'] ? 200 : 400;
            return response()->json($result, $status);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function mesProduits(Request $request)
    {
        try {
            return response()->json(
                $this->service->mesProduits($request->user())
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de vos produits',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function marquerVendu($id, Request $request)
    {
        try {
            $result = $this->service->marquerVendu($request->user(), $id);
            $status = $result['success'] ? 200 : 400;
            return response()->json($result, $status);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du marquage du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}