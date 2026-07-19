<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ExtracurricularController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        $ekskuls = Extracurricular::latest()->get();
        return view('dashboard.extracurriculars.index', compact('setting', 'ekskuls'));
    }

    public function create()
    {
        return view('dashboard.extracurriculars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048', // Batas 2MB
            'image' => 'nullable|image|max:5120', // Batas 5MB
            'description' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('ekskul/logos', 'public');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('ekskul/images', 'public');
        }

        Extracurricular::create($data);

        return redirect()->route('extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan!');
    }

    public function edit(Extracurricular $extracurricular)
    {
        return view('dashboard.extracurriculars.edit', compact('extracurricular'));
    }

    public function update(Request $request, Extracurricular $extracurricular)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:5120',
            'description' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($extracurricular->logo) Storage::disk('public')->delete($extracurricular->logo);
            $data['logo'] = $request->file('logo')->store('ekskul/logos', 'public');
        }

        if ($request->hasFile('image')) {
            if ($extracurricular->image) Storage::disk('public')->delete($extracurricular->image);
            $data['image'] = $request->file('image')->store('ekskul/images', 'public');
        }

        $extracurricular->update($data);

        return redirect()->route('extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil diperbarui!');
    }

    public function destroy(Extracurricular $extracurricular)
    {
        if ($extracurricular->logo) Storage::disk('public')->delete($extracurricular->logo);
        if ($extracurricular->image) Storage::disk('public')->delete($extracurricular->image);
        
        $extracurricular->delete();

        return redirect()->route('dashboard.extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil dihapus!');
    }
}