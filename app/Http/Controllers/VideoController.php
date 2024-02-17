<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->paginate(3);
        return view('video.index', compact('videos'))->with('i', (request()->input('page', 1) - 1) * 3);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('video.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->get('id');
        if($id){
            $videos = Video::find($id);
        } else {
            $videos = new Video;
        }
        if($request->hasFile('video')){
            $video = $request->file('video');
            $request->validate([
                'video' => 'required|file|mimes:mp4,jpeg,png,jpg,gif|max:10048',
                'caption' => 'required|max:100',
            ]);
            $videoName = time() . '.' .$video->getClientOriginalExtension();
            $destinationPath = 'video/';
            $video->move($destinationPath, $videoName);
            $videos->video = $videoName;
        }
        $videos->created_by = $request->created_by;
        $videos->caption = $request->caption;
        $videos->save();
        return redirect()->route('vidio.index')->with('success', 'Video Berhasil di Unggah!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = Video::find($id);
        
        if (!$video) {
            return redirect()->route('vidio.index')->with('error', 'Video tidak ditemukan.');
        }

        // Hapus video dari penyimpanan sebelum menghapus data dari database
        if ($video->video) {
            Storage::delete($video->video);
        }

        if ($video->delete()) {
            return redirect()->route('vidio.index')->with('success', 'Video berhasil dihapus!');
        }

        return redirect()->route('vidio.index')->with('error', 'Gagal menghapus video.');
    }
}
