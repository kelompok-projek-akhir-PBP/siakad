<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\AcademicYear\AcademicYearStoreRequest;
use App\Http\Requests\MasterData\AcademicYear\AcademicYearUpdateRequest;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $academicYears = AcademicYear::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            })
            ->latest()->paginate(10)->withQueryString();

        return view('pages.master-data.academic-year.index', compact('academicYears'));
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
    public function store(AcademicYearStoreRequest $request)
    {
        $requestData = $request->validated();
        if (isset($request->is_active_checkbox)) {
            $currentActive = AcademicYear::where('is_active', true)->first();
            if (isset($currentActive)) {
                $currentActive->update(['is_active' => false]);
            }
            $requestData['is_active'] = true;
        }
        AcademicYear::create($requestData);
        toastr()->success('Berhasil membuat tahun ajaran baru');
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
        $accademicYear = AcademicYear::findOrFail($id);
        return view('pages.master-data.academic-year.edit', compact('accademicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicYearUpdateRequest $request, string $id)
    {
        $requestData = $request->validated();
        $academicYear = AcademicYear::findOrFail($id);
        if (isset($request->is_active_checkbox)) {
            $currentActive = AcademicYear::where('is_active', true)->first();
            if (isset($currentActive)) {
                $currentActive->update(['is_active' => false]);
            }
            $requestData['is_active'] = true;
        }
        $academicYear->update($requestData);
        toastr()->success('Berhasil memperbarui data tahun ajaran');
        return redirect()->route('academic-years.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->delete();
        toastr()->success('Berhasil menghapus data tahun ajaran');
        return back();
    }
}
