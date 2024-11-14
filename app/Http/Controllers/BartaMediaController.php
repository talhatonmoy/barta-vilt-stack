<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BartaMediaController extends Controller
{
    /**
     * Deleting Media by ID
     */
    public function destroy($id){
        $media = Media::findOrFail($id);
        $media->delete();
    }
}
