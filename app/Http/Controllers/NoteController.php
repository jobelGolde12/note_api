<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
     // GET /notes
    public function index()
    {
        try {
            $notes = Note::all();
            return response()->json($notes, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch notes', 'message' => $e->getMessage()], 500);
        }
    }

    // POST /notes
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $note = Note::create($validated);

            return response()->json($note, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create note', 'message' => $e->getMessage()], 500);
        }
    }

    // GET /notes/{id}
    public function show($id)
    {
        try {
            $note = Note::findOrFail($id);
            return response()->json($note, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch note', 'message' => $e->getMessage()], 404);
        }
    }

    // PUT /notes/{id}
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string',
            ]);

            $note = Note::findOrFail($id);
            $note->update($validated);

            return response()->json($note, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update note', 'message' => $e->getMessage()], 500);
        }
    }

    // DELETE /notes/{id}
         public function destroy($id)
        {
            try {
                $note = Note::findOrFail($id);
                $note->delete(); 
                return response()->json(['message' => 'Note deleted successfully']);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Failed to delete note',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        // RESTORE /notes/{id}/restore
        public function restore($id)
        {
            try {
                $note = Note::withTrashed()->findOrFail($id);
                $note->restore();

                return response()->json(['message' => 'Note restored successfully']);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Failed to restore note',
                    'message' => $e->getMessage()
                ], 500);
            }
        }



    // make a favorite
            public function favorite($id)
        {
            try {
                $note = Note::findOrFail($id);
                $note->update(['favorite' => true]);

                return response()->json(['message' => 'Note marked as favorite']);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Failed to favorite note',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

    // remove favorite
        public function unfavorite($id)
    {
        try {
            $note = Note::findOrFail($id);
            $note->update(['favorite' => false]);

            return response()->json(['message' => 'Note removed from favorites']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to unfavorite note',
                'message' => $e->getMessage()
            ], 500);
        }
    }


}
