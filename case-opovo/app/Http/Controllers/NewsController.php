<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsType;
use App\Models\Journalist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NewsController extends Controller
{
    public function showAll()
    {
        $journalist = Journalist::find(Auth::id());
        $news = $journalist->news;

        return response()->json([
            'status' => 'success',
            'news' => $news,
        ]);
    }

    public function showAllByType($type_id)
    {
        try {
            $journalist = Journalist::find(Auth::id());

            $newsType = NewsType::findOrFail($type_id);

            $news = $journalist->news()->where('news_type_id', $type_id)->get();
            return response()->json([
                'status' => 'success',
                'news' => $news,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'News Type not found.'
            ], 404);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'news_type_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10|max:10000',
            'content' => 'required|string|min:10|max:10000',
            'thumbnail' => 'nullable|string',
        ]);

        $news = News::create([
            'journalist_id' => Auth::id(),
            'news_type_id' => intval($request->news_type_id),
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'thumbnail' => $request->thumbnail,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'News Type created successfully',
            'news' => $news,
        ]);
    }

    public function update(Request $request, $news_id)
    {
        try {
            $validated = $request->validate([
                'news_type_id' => 'nullable|integer',
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string|min:10|max:10000',
                'content' => 'nullable|string|min:10|max:10000',
                'thumbnail' => 'nullable|string',
            ]);

            if (!$request->anyFilled(['news_type_id', 'title', 'description', 'content', 'thumbnail'])) {
                return response()->json([
                    'error' => 'At least one of the fields (news_type_id, title, description, content or thumbnail) must be filled in.'
                ], 422);
            }

            // Throw an exception if not find
            if ($request->filled('news_type_id')) {
                $newsType = NewsType::findOrFail($request->news_type_id);
            }

            $news = News::findOrFail($news_id);
            $news->journalist_id = Auth::id();
            $news->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'News updated successfully',
                'news' => $news,
            ]);
        } catch (ModelNotFoundException $e) {
            if (strpos($e->getMessage(), 'App\Models\NewsType') !== false) {
                return response()->json([
                    'error' => 'News Type not found with ID: '
                ], 404);
            } elseif (strpos($e->getMessage(), 'App\Models\News') !== false) {
                return response()->json([
                    'error' => 'News not found with ID: '
                ], 404);
            }

            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function delete($news_id)
    {
        try {
            $news = News::findOrFail($news_id);

            $news->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'News deleted successfully',
                'news' => $news,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'News not found.'
            ], 404);
        }
    }
}
