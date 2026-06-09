<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'chapter_id' => 'required',
            'title' => 'required',
            'content' => 'required'
        ]);

        $page = Page::create([
            'chapter_id' => $request->chapter_id,
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Page created successfully',
            'page' => $page
        ]);
    }

    public function index($chapter_id)
    {
        $pages = Page::where('chapter_id', $chapter_id)->get();

        return response()->json([
            'status' => true,
            'pages' => $pages
        ]);
    }

    public function update(Request $request, $id)
{
    $page = Page::findOrFail($id);

    $page->update([
        'title' => $request->title,
        'content' => $request->content
    ]);

    return response()->json([
        'status' => true,
        'page' => $page
    ]);
}

public function destroy($id)
{
    $page = Page::findOrFail($id);

    $page->delete();

    return response()->json([
        'status' => true,
        'message' => 'Page deleted'
    ]);
}
}
