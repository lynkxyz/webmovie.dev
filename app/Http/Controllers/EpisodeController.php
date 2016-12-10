<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Episode;
use App\EpisodeLink;
use App\Movie;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = Movie::find($id)->episode()->orderBy('id','DESC')->get()->toArray();

        return view('admin.episode.index', compact('data','id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {   

        return view('admin.episode.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $episode = new Episode();
        $episode->name = $request->txtName;
        $episode->alias = changeTitle($request->txtName);
        $episode->movie_id = $request->txtMovieId;
        $episode->save();

        for($i = 0; $i < 5; $i++) {
            $link = new EpisodeLink();
            $link->link = $request->txtLink[$i];
            $link->episode_id = $episode->id;
            $link->save();
        }

        return redirect()->route('episode.index', $request->txtMovieId)->with([
            'flash_level'=>'success',
            'flash_message'=>'Episode created succesfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $episode = Episode::find($id)->toArray();
        $links = EpisodeLink::where('episode_id', $id)->get()->toArray();
        return view('admin.episode.edit', compact('episode','links'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $episode = Episode::find($id);
        $episode->name = $request->txtName;
        $episode->alias = changeTitle($request->txtName);
        $episode->save();

        $links = EpisodeLink::where('episode_id', $id)->select('id')->get()->toArray();

        foreach($links as $key => $link) {
            $data = EpisodeLink::find($link['id']);
            $data->link = $request->txtLink[$key];
            $data->save();
        }

        return redirect()->route('episode.index', $episode->movie_id)->with([
            'flash_level'=>'success',
            'flash_message'=>'Episode updated succesfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idMovie = Episode::find($id);
        $episode = Episode::destroy($id);

        return redirect()->route('episode.index', $idMovie->movie_id)->with([
            'flash_level'=>'success',
            'flash_message'=>'Episode deleted succesfully'
        ]);
    }
}