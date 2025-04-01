<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsType;
use App\Models\Journalist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NewsTypeController extends Controller
{
    public function showAll()
    {
        $newsTypes = NewsType::all();
        return response()->json([
            'status' => 'success',
            'news_types' => $newsTypes,
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $newsType = NewsType::create([
            'journalist_id' => Auth::id(),
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'News Type created successfully',
            'news_type' => $newsType,
        ]);
    }

    public function update(Request $request, $type_id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $newsType = NewsType::findOrFail($type_id);
            $newsType->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'News Type updated successfully',
                'news_type' => $newsType,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'News Type not found.'
            ], 404);
        }
    }

    public function delete($type_id)
    {
        try {
            $newsType = NewsType::findOrFail($type_id);

            if ($newsType->news()->exists()) {
                throw new HttpResponseException(
                    response()->json([
                        'error' => 'This news type cannot be deleted because there are news articles associated with it.'
                    ], 409)
                );
            }

            $newsType->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'News Type deleted successfully',
                'news_type' => $newsType,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'News Type not found.'
            ], 404);
        }
    }
}
