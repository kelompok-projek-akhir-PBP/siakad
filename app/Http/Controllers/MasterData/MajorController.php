<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\Major\MajorStoreRequest;
use App\Http\Requests\MasterData\Major\MajorUpdateRequest;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $majors = Major::query()->when($request->input('search'), function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        })->latest()->paginate(10)->withQueryString();

        return view('pages.master-data.major.index', compact('majors'));
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
    public function store(MajorStoreRequest $request)
    {
        $requestData = $request->validated();
        $requestData['is_active'] = isset($request->is_active_checkbox);
        Major::create($requestData);
        toastr()->success('Berhasil menambahkan data jurusan');
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
        $major = Major::findOrFail($id);
        return view('pages.master-data.major.edit', compact('major'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MajorUpdateRequest $request, string $id)
    {
        $requestData = $request->validated();
        $major = Major::findOrFail($id);
        $requestData['is_active'] = isset($request->is_active_checkbox);
        $major->update($requestData);
        toastr()->success('Berhasil memperbarui data jurusan');
        return redirect()->route('majors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $major = Major::findOrFail($id);
        $major->delete();
        toastr()->success('Berhasil menghapus data jurusan');
        return back();
    }
}
