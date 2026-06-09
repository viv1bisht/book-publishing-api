<?php

namespace App\Http\Controllers\Api;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 

class BookController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required'
    ]);

    $user = $request->auth_user;

    $book = Book::create([
        'user_id' => $user->id,
        'title' => $request->title,
        'description' => $request->description,
        'status' => 'draft'
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Book created successfully',
        'book' => $book
    ]);
}

public function index(Request $request)
{
    $user = $request->auth_user;

    $books = Book::where('user_id', $user->id)->get();

    return response()->json([
        'status' => true,
        'books' => $books
    ]);
}

///Update
public function update(Request $request, $id)
{
    $user = $request->auth_user;

    $book = Book::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

    if (!$book) {
        return response()->json([
            'status' => false,
            'message' => 'Book not found'
        ], 404);
    }
    if ($book->status == 'published') {
    return response()->json([
        'status' => false,
        'message' => 'Published books are read only'
    ], 403);
}

    $book->update([
        'title' => $request->title ?? $book->title,
        'description' => $request->description ?? $book->description,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Book updated successfully',
        'book' => $book
    ]);

 
}


//delete
public function destroy(Request $request, $id)
{
    $user = $request->auth_user;

    $book = Book::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

    if (!$book) {
        return response()->json([
            'status' => false,
            'message' => 'Book not found'
        ], 404);
    }

    if ($book->status == 'published') {
    return response()->json([
        'status' => false,
        'message' => 'Published books cannot be deleted'
    ], 403);
}

    $book->delete();

    return response()->json([
        'status' => true,
        'message' => 'Book deleted successfully'
    ]);
     
}


////single book
public function show(Request $request, $id)
{
    $user = $request->auth_user;

    $book = Book::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

    if (!$book) {
        return response()->json([
            'status' => false,
            'message' => 'Book not found'
        ]);
    }

    return response()->json([
        'status' => true,
        'book' => $book
    ]);
}


///submit
public function submit(Request $request, $id)
{
    $user = $request->auth_user;

    if ($user->role != 'author') {
        return response()->json([
            'status' => false,
            'message' => 'Only authors can submit books'
        ], 403);
    }

    $book = Book::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

    if (!$book) {
        return response()->json([
            'status' => false,
            'message' => 'Book not found'
        ], 404);
    }

    // Moderation Check
    $content = strtolower($book->title . ' ' . $book->description);

    $profanityWords = [
        'badword',
        'abuse',
        'stupid'
    ];

    $restrictedWords = [
        'terrorist',
        'bomb',
        'drugs'
    ];

    foreach ($profanityWords as $word) {
        if (str_contains($content, strtolower($word))) {
            return response()->json([
                'status' => false,
                'message' => "Profanity detected: {$word}"
            ], 422);
        }
    }

    foreach ($restrictedWords as $word) {
        if (str_contains($content, strtolower($word))) {
            return response()->json([
                'status' => false,
                'message' => "Restricted word detected: {$word}"
            ], 422);
        }
    }

    $book->status = 'under_review';
    $book->save();

    return response()->json([
        'status' => true,
        'message' => 'Book sent for review',
        'book' => $book
    ]);
}

///approve
public function approve(Request $request, $id)
{
    $user = $request->auth_user;

    if ($user->role != 'reviewer') {
        return response()->json([
            'status' => false,
            'message' => 'Access denied'
        ], 403);
    }

    $book = Book::findOrFail($id);

    if ($book->status != 'under_review') {
    return response()->json([
        'status' => false,
        'message' => 'Book must be under review first'
    ], 422);
}

    $book->status = 'approved';
    $book->save();

    return response()->json([
        'status' => true,
        'book' => $book
    ]);
}


///Reject
public function reject(Request $request, $id)
{
    $user = $request->auth_user;

    if ($user->role != 'reviewer') {
        return response()->json([
            'status' => false,
            'message' => 'Only reviewers can reject books'
        ], 403);
    }

    $book = Book::find($id);

    if (!$book) {
        return response()->json([
            'status' => false,
            'message' => 'Book not found'
        ], 404);
    }

    if ($book->status != 'under_review') {
        return response()->json([
            'status' => false,
            'message' => 'Book is not under review'
        ], 422);
    }

    $book->status = 'rejected';
    $book->save();

    return response()->json([
        'status' => true,
        'message' => 'Book rejected successfully',
        'book' => $book
    ]);
}

///publish
public function publish(Request $request, $id)
{
    $user = $request->auth_user;

    if ($user->role != 'admin') {
        return response()->json([
            'status' => false,
            'message' => 'Only admins can publish books'
        ], 403);
    }

    $book = Book::find($id);

    if (!$book) {
        return response()->json([
            'status' => false,
            'message' => 'Book not found'
        ], 404);
    }

    if ($book->status != 'approved') {
        return response()->json([
            'status' => false,
            'message' => 'Only approved books can be published'
        ], 422);
    }

    $book->status = 'published';
    $book->save();

    return response()->json([
        'status' => true,
        'message' => 'Book published successfully',
        'book' => $book
    ]);
}

 ///upload

public function upload(Request $request, $id)
{
    $request->validate([
    'file' => 'required|mimes:doc,docx,pdf,jpg,jpeg,png'
]);

    $book = Book::findOrFail($id);

    $file = $request->file('file');

    $filename = time().'_'.$file->getClientOriginalName();

    $file->move(public_path('uploads'), $filename);

    return response()->json([
        'status' => true,
        'message' => 'Document uploaded successfully',
        'file' => $filename
    ]);
}


}
