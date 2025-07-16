<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::query();
            if (auth()->id() !== 1) {
                $data->where('user_id', auth()->id());
            };
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('blogs.edit', $row->id) . '" class="edit btn btn-primary btn-sm mr-2">Edit</a>';
                    $btn .= '<a onclick="deleteConfirm(' . $row->id . ')" class="edit btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('blog.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:blogs',
            'description' => 'required|min:10',
            'image.*' => 'image|mimes:jpeg,png,jpg',
            'tags' => 'nullable|array',
        ]);

        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imagePaths[] = $image->store('blogs', 'public');
            }
        }

        Blog::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePaths,
            'tags' => $request->tags,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
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
    public function edit(Blog $blog)
    {
        return view('blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|unique:blogs,title,' . $blog->id,
            'description' => 'required|min:10',
            'image.*' => 'image|mimes:jpeg,png,jpg',
            'tags' => 'nullable|array',
        ]);

        $imagePaths = $blog->image ?? [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imagePaths[] = $image->store('blogs', 'public');
            }
        }

        $blog->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePaths,
            'tags' => $request->tags,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        User::findOrFail($blog)->delete();
        return response()->json(['success' => true]);
        // return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
