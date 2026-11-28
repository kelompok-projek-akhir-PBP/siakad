<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\Subject\SubjectStoreRequest;
use App\Http\Requests\MasterData\Subject\SubjectUpdateRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subjects = Subject::query()->when($request->input('search'), function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        })->latest()->paginate(10)->withQueryString();

        return view('pages.master-data.subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectStoreRequest $request)
    {
        $requestData = $request->validated();
        $requestData['is_active'] = isset($request->is_active_checkbox);
        Subject::create($requestData);
        toastr()->success('Berhasil menambahkan data mata pelajaran');
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
        $subject = Subject::findOrFail($id);
        return view('pages.master-data.subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectUpdateRequest $request, string $id)
    {
        $requestData = $request->validated();
        $subject = Subject::findOrFail($id);
        $requestData['is_active'] = isset($request->is_active_checkbox);
        $subject->update($requestData);
        toastr()->success('Berhasil memperbarui data mata pelajaran');
        return redirect()->route('subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        toastr()->success('Berhasil mengapus data mata pelajara');
        return back();
    }
}
