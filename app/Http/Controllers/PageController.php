<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Movie;
use App\Episode;
use App\Genres;
use App\Like;
use Auth;

class PageController extends Controller
{
    public function mapArray($option, $data) {
        $str = '';
        foreach($data as $d) {
            if($str === '')
                $str = "<span><a href='/".$option."/".$d['id']."'>".$d['name']."</a></span>";
            else
                $str .= ", <span><a href='/".$option."/".$d['id']."'>".$d['name']."</a></span>";
        }

        return $str;
    }

    public function getUserLiked($arrLike, &$likeId) {
        foreach($arrLike as $like) {
            if($like['user_id'] == Auth::id()) {
                $likeId = $like['id'];
                return true;
            }
        }
        return false;
    }

    public function index($id, $episodeId) {
        $movie = Movie::find($id)->toArray();
        $movies = Movie::select('id', 'name', 'thumb', 'views', 'likes')->orderByRaw("RAND()")->limit(10)->orderBy('id', 'DESC')->get()->toArray();

        $episodes = Episode::where('movie_id', $id)->select('id', 'name', 'views', 'likes')->limit(10)->get()->toArray();
        $episode = Episode::find($episodeId)->toArray();

        // get data
        $genres = Movie::find($id)->genre()->get()->toArray();
        $producers = Movie::find($id)->producer()->get()->toArray();
        $keywords = Movie::find($id)->keyword()->get()->toArray();
        $fansubs = Movie::find($id)->fansub()->get()->toArray();
        $links = Episode::find($episodeId)->link()->get()->toArray();

        // convert data to array;
        $arrGenres = $this->mapArray('genre/anime', $genres);
        $arrProducers = $this->mapArray('producer/anime', $producers);
        $arrTags = $this->mapArray('keyword/anime', $keywords);
        $arrFansubs = $this->mapArray('fansub/anime', $fansubs);

        // like
        $like = Like::where('episode_id','=',$episodeId)->get()->toArray();
        $totalLiked = count($like);
        $likeId = 0;
        $isLiked = $this->getUserLiked($like, $likeId);

        return view('home.page', compact('likeId','isLiked','totalLiked','links', 'movie', 'movies', 'episodes', 'episode', 'arrGenres', 'arrProducers', 'arrTags', 'arrFansubs', 'id', 'episodeId'));
        // echo '<pre>';
        // print_r($likeId);
    }
    
}
