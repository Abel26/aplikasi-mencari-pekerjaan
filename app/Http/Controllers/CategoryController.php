<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // mengambil data dari model
        $categories = Category::orderByDesc('id')->paginate(10);

        return view('super_admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            if ($request->hasFile('icon')) {
                // untuk menyimpan alamat icon di db
                $iconPath = $request->file('icon')->store('icons', 'public');
                $validated['icon'] = $iconPath;
            }

            // untuk membuat slug berdasarakan name
            $validated['slug'] = Str::slug($validated['name']);

            $newData = Category::create($validated);
        });

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('super_admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        DB::transaction(function () use ($request, $category) {
            $validated = $request->validated();
            if ($request->hasFile('icon')) {
                // untuk menyimpan alamat icon di db
                $iconPath = $request->file('icon')->store('icons/'.date('Y/m/d'), 'public');
                $validated['icon'] = $iconPath;
            }

            // untuk membuat slug berdasarakan name
            $validated['slug'] = Str::slug($validated['name']);
            // update data ke $category berdasarkan $validated
            $category->update($validated);
        });

        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::transaction(function () use ($category) {
            $category->delete();
        });

        return redirect()->route('admin.categories.index');
    }
}
