<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\PostBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $pages = Page::all();
        $selectedPageId = $request->query('page_id');
        return view('admin.pages.components.posts.create', compact('pages', 'selectedPageId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'blocks.*.title' => 'nullable|string|max:255',
            'blocks.*.content' => 'nullable|string',
            'blocks.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle main post image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($validated);

        // Handle blocks
        if ($request->has('blocks')) {
            foreach ($request->blocks as $blockData) {
                if (isset($blockData['image']) && is_file($blockData['image'])) {
                    $blockData['image'] = $blockData['image']->store('blocks', 'public');
                }
                $post->blocks()->create($blockData);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function index()
    {
        $posts = Post::with('page')->get(); // Récupère tous les posts avec leurs pages associées
        return view('admin.pages.components.posts.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with('blocks')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id); // Récupère le post par son ID
        $pages = Page::all(); // Récupère toutes les pages
        return view('admin.pages.components.posts.edit', compact('post', 'pages'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'page_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'blocks.*.id' => 'nullable|integer|exists:post_blocks,id',
            'blocks.*.title' => 'nullable|string|max:255',
            'blocks.*.content' => 'nullable|string',
            'blocks.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle main post image upload
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        // Handle blocks
        if ($request->has('blocks')) {
            foreach ($request->blocks as $blockData) {
                if (isset($blockData['id'])) {
                    $block = $post->blocks()->find($blockData['id']);
                    if ($block) {
                        // Handle block image upload
                        if (isset($blockData['image']) && $blockData['image'] instanceof \Illuminate\Http\UploadedFile) {
                            if ($block->image) {
                                Storage::disk('public')->delete($block->image);
                            }
                            $blockData['image'] = $blockData['image']->store('blocks', 'public');
                        } else {
                            $blockData['image'] = $block->image; // Keep the existing image if no new image is uploaded
                        }

                        // Update block with new data
                        $block->update([
                            'title' => $blockData['title'] ?? $block->title,
                            'content' => $blockData['content'] ?? $block->content,
                            'image' => $blockData['image'],
                        ]);
                    }
                } else {
                    // Handle new block creation
                    if (isset($blockData['image']) && $blockData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $blockData['image'] = $blockData['image']->store('blocks', 'public');
                    }
                    $post->blocks()->create($blockData);
                }
            }
        }

        return redirect()->route('posts.edit', $post->id)->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id); // Récupère le post par son ID
        $post->delete(); // Supprime le post
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
