<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\Post; // Add this import

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.components.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.components.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:pages,slug',
            'content' => 'required|string',
            'images.*' => 'nullable|image|max:2048',
            'posts' => 'nullable|array',
            'posts.*.text' => 'nullable|string',
            'posts.*.image' => 'nullable|image|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('pages', 'public'); // Store images in the 'pages' folder
            }
        }

        $page = Page::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? Str::slug($validated['title']),
            'content' => $validated['content'],
            'images' => json_encode($images),
        ]);

        if (!empty($validated['posts'])) {
            foreach ($validated['posts'] as $postData) {
                $postImage = null;
                if (isset($postData['image']) && $postData['image']->isValid()) {
                    $postImage = $postData['image']->store('posts', 'public'); // Store post images in the 'posts' folder
                }

                $page->posts()->create([
                    'text' => $postData['text'] ?? null,
                    'image' => $postImage,
                ]);
            }
        }

        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.components.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
            'posts' => 'nullable|array',
            'posts.*.text' => 'nullable|string',
            'posts.*.image' => 'nullable|image|max:2048',
        ]);

        $images = json_decode($page->images, true) ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('pages', 'public'); // Store images in the 'pages' folder
            }
        }

        $page->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? Str::slug($validated['title']),
            'content' => $validated['content'],
            'images' => json_encode($images),
        ]);

        if (!empty($validated['posts'])) {
            $page->posts()->delete(); // Remove existing posts before adding new ones
            foreach ($validated['posts'] as $postData) {
                $postImage = null;
                if (isset($postData['image']) && $postData['image']->isValid()) {
                    $postImage = $postData['image']->store('posts', 'public'); // Store post images in the 'posts' folder
                }

                $page->posts()->create([
                    'text' => $postData['text'] ?? null,
                    'image' => $postImage,
                ]);
            }
        }

        return redirect()->route('pages.index')->with('success', 'Page Modifier !.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
    }
}
