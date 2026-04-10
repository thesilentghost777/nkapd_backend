<?php

namespace App\Http\Controllers\BrFinal;

use App\Http\Controllers\Controller;
use App\Models\BrFinal\BusinessItem;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $items = BusinessItem::where('actif', true)->with('user')->latest()->paginate(12);
        $categories = BusinessItem::where('actif', true)->distinct()->pluck('categorie');
        $mesItems = auth('brfinal')->user()->businessItems()->latest()->get();
        return view('br-final.membre.business.index', compact('items', 'categories', 'mesItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'nullable|numeric|min:0',
            'categorie' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'whatsapp' => 'nullable|string',
        ]);

        $data = $request->only('titre', 'description', 'prix', 'categorie', 'whatsapp');
        $data['user_id'] = auth('brfinal')->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('br-business', 'public');
        }

        BusinessItem::create($data);
        return back()->with('success', 'Publication créée.');
    }

    public function show(BusinessItem $item)
    {
        $item->increment('vues');
        $item->load('user');
        $similaires = BusinessItem::where('categorie', $item->categorie)->where('id', '!=', $item->id)->where('actif', true)->take(4)->get();
        return view('br-final.membre.business.show', compact('item', 'similaires'));
    }

    public function destroy(BusinessItem $item)
    {
        if ($item->user_id !== auth('brfinal')->id()) abort(403);
        $item->delete();
        return back()->with('success', 'Publication supprimée.');
    }
}
