<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\Semester\SemesterStoreRequest;
use App\Http\Requests\MasterData\Semester\SemesterUpdateRequest;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesters = Semester::query()->latest()->paginate(10)->withQueryString();
        return view('pages.master-data.semester.index', compact('semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SemesterStoreRequest $request)
    {
        $requestData = $request->validated();
        if (isset($request->is_active_checkbox)) {
            $currentActive = Semester::where('is_active', true)->first();
            if (isset($currentActive)) {
                $currentActive->update(['is_active' => false]);
            }
            $requestData['is_active'] = true;
        }
        Semester::create($requestData);
        toastr()->success('Berhasil membuat semester baru');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $semester = Semester::findOrFail($id);
        return view('pages.master-data.semester.edit', compact('semester'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SemesterUpdateRequest $request, string $id)
    {
        $requestData = $request->Validated();
        $semester = Semester::findOrFail($id);
        if (isset($request->is_active_checkbox)) {
            $currentActive = Semester::where('is_active', true)->first();
            if (isset($currentActive)) {
                $currentActive->update(['is_active' => false]);
            }
            $requestData['is_active'] = true;
        }
        $semester->update($requestData);
        toastr()->success('Berhasil memperbarui data semeter');
        return redirect()->route('semesters.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();
        toastr()->success('Berhasil menghapus data semester');
        return back();
    }
}
