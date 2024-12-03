<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Feed;
use App\Models\FeedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator; 
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Database\Eloquent\Relations\HasMany;


class FeedController extends Controller
{

    public function index()
{
    $feeds = Feed::with('user', 'images')->get();
    
    // Modificar la ruta de las imágenes para incluir '/storage/'
    $feeds->each(function ($feed) {
        $feed->images->each(function ($image) {
            $image->image_path = '/storage/' . $image->image_path;
        });
    });
    
    // Incluye 'video_link' en la respuesta
    return response(['feeds' => $feeds], 200, [], JSON_NUMERIC_CHECK);
}

public function store(Request $request)
{
    try {
        $request->validate([
            'user_id' => 'required|integer',
            'categoria'=>'required|string',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Imágenes opcionales
            'video_link' => 'nullable|url', // Enlace de video opcional
        ]);

        $feed = Feed::create([
            'categoria' => $request->categoria,
            'content' => $request->content,
            'user_id' => $request->user_id,
            'video_link' => $request->video_link, // Agregar enlace del video si existe
        ]);

        // Procesar las imágenes si se han subido
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('feed_images', 'public'); // Almacena en public/feed_images
                $feed->images()->create(['image_path' => $path]);
            }
        }

        return response(['message' => 'success'], 201);
    } catch (\Exception $e) {
        return response(['message' => 'error', 'error' => $e->getMessage()], 500);
    }
}



    
    public function destroy($id)
    {
        $feed = Feed::find($id);
        if (!$feed) {
            return response(['message' => '404 Not found'], 404);
        }
        $feed->delete();
        return response(['message' => 'deleted'], 200);
    }
}