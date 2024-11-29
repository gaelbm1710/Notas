<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        return Note::paginate(10);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'date_time' => 'required|date',
            'body' => 'required|string',
            'classification' => 'required|string|max:100',
        ], [
            'title.required' => 'El título es obligatorio.',
            'author.required' => 'El autor es obligatorio.',
            'date_time.required' => 'La fecha y hora son obligatorias.',
            'body.required' => 'El cuerpo de la nota es obligatorio.',
            'classification.required' => 'La clasificación es obligatoria.',
        ]);

        try {
            $note = Note::create($validated);
            return response()->json(['message' => 'Nota creada exitosamente.', 'note' => $note], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo crear la nota.', 'details' => $e->getMessage()], 500);
        }
    }

    public function show(Note $note)
    {
        return response()->json(['message' => 'Nota obtenida exitosamente.', 'note' => $note], 200);
    }

    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'date_time' => 'required|date',
            'body' => 'required|string',
            'classification' => 'required|string|max:100',
        ]);

        try {
            $note->update($validated);
            return response()->json(['message' => 'Nota actualizada exitosamente.', 'note' => $note], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo actualizar la nota.', 'details' => $e->getMessage()], 500);
        }
    }

    public function destroy(Note $note)
    {
        try {
            $note->delete();
            return response()->json(['message' => 'Nota eliminada exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo eliminar la nota.', 'details' => $e->getMessage()], 500);
        }
    }
}
