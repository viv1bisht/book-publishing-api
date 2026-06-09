<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required',
            'title' => 'required'
        ]);

        $chapter = Chapter::create([
            'book_id' => $request->book_id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Chapter created successfully',
            'chapter' => $chapter
        ]);
    }

    public function index($book_id)
    {
        $chapters = Chapter::where('book_id', $book_id)->get();

        return response()->json([
            'status' => true,
            'chapters' => $chapters
        ]);
    }

    public function update(Request $request, $id)
{
    $chapter = Chapter::findOrFail($id);

    $chapter->update([
        'title' => $request->title,
        'description' => $request->description
    ]);

    return response()->json([
        'status' => true,
        'chapter' => $chapter
    ]);
}

public function destroy($id)
{
    $chapter = Chapter::findOrFail($id);

    $chapter->delete();

    return response()->json([
        'status' => true,
        'message' => 'Chapter deleted'
    ]);
}
}
