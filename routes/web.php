<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as' => 'home.index',
    'uses' => 'HomeController@index'
]);


Route::get('404', function() {
    return view('404');
});

// like
Route::group(['prefix'=>'anime', 'middleware'=>'auth'], function() {
    Route::post('like/{id}/movie/{movie_id}', [
        'as' => 'episode.like',
        'uses' => 'LikeController@like'
    ]);
    Route::delete('unlike/{id}/episode/{epsiode_id}/movie/{movie_id}', [
        'as' => 'episode.unlike',
        'uses' => 'LikeController@unlike'
    ]);
});


// search
Route::get('search', [
    'as' => 'search.show',
    'uses' => 'Home\SearchController@show'
]);

// watch anime
Route::get('anime/{id}/episode/{episodeId}', [
    'as' => 'page.index',
    'uses' => 'PageController@index'
]);

Route::group(['prefix'=>'genre'], function() {
    Route::get('', [
        'as' => 'genrepage.index',
        'uses' => 'Home\GenrePageController@index'
    ]);
    Route::get('anime/{id}', [
        'as' => 'genrepage.show',
        'uses' => 'Home\GenrePageController@show'
    ]);
});

Route::group(['prefix'=>'producer'], function() {
    Route::get('', [
        'as' => 'producerpage.index',
        'uses' => 'Home\ProducerPageController@index'
    ]);
    Route::get('anime/{id}', [
        'as' => 'producerpage.show',
        'uses' => 'Home\ProducerPageController@show'
    ]);
});

Route::group(['prefix'=>'year'], function() {
    Route::get('', [
        'as' => 'yearpage.index',
        'uses' => 'Home\YearPageController@index'
    ]);
    Route::get('anime/{id}', [
        'as' => 'yearpage.show',
        'uses' => 'Home\YearPageController@show'
    ]);
});

Route::group(['prefix'=>'keyword'], function() {
    Route::get('', [
        'as' => 'keywordpage.index',
        'uses' => 'Home\KeywordPageController@index'
    ]);
    Route::get('anime/{id}', [
        'as' => 'keywordpage.show',
        'uses' => 'Home\KeywordPageController@show'
    ]);
});

Route::group(['prefix'=>'fansub'], function() {
    Route::get('', [
        'as' => 'fansubpage.index',
        'uses' => 'Home\FansubPageController@index'
    ]);
    Route::get('anime/{id}', [
        'as' => 'fansubpage.show',
        'uses' => 'Home\FansubPageController@show'
    ]);
});

// member routes
Route::group(['prefix'=>'member','middleware'=>['auth']], function() {
    Route::group(['prefix'=>'myaccount'], function() {
        Route::get('', [
            'as' => 'myaccount.index',
            'uses' => 'Member\MyAccountController@index'
        ]);
        Route::get('{id}/edit', [
            'as' => 'myaccount.edit',
            'uses' => 'Member\MyAccountController@edit'
        ]);
        Route::put('{id}', [
            'as' => 'myaccount.update',
            'uses' => 'Member\MyAccountController@update'
        ]);

        Route::get('{id}/editPassword', [
            'as' => 'myaccount.editPassword',
            'uses' => 'Member\MyAccountController@editPassword'
        ]);
        Route::put('{id}/updatePassword', [
            'as' => 'myaccount.updatePassword',
            'uses' => 'Member\MyAccountController@updatePassword'
        ]);
    });
    
});


// admin routes
Route::get('admin', function() {
    return view('admin.year.index');
});

Route::group(['prefix'=>'admin', 'middleware'=>'admin'], function() {
    Route::resource('year', 'YearController');
    Route::resource('season', 'SeasonController');
    Route::resource('genre', 'GenreController');
    Route::resource('keyword', 'KeywordController');
    Route::resource('producer', 'ProducerController');
    Route::resource('fansub', 'FansubController');
    Route::resource('movie', 'MovieController');
    // Route::resource('episode', 'EpisodeController');
    Route::group(['prefix'=>'episode'], function() {
        Route::get('movie/{id}', [
            'as' => 'episode.index',
            'uses' => 'EpisodeController@index'
        ]);
        Route::get('create/{id}', [
            'as' => 'episode.create',
            'uses' => 'EpisodeController@create'
        ]);
        Route::post('', [
            'as' => 'episode.store',
            'uses' => 'EpisodeController@store'
        ]);
        Route::get('{id}', [
            'as' => 'episode.show',
            'uses' => 'EpisodeController@show'
        ]);
        Route::get('{id}/edit', [
            'as' => 'episode.edit',
            'uses' => 'EpisodeController@edit'
        ]);
        Route::put('{id}', [
            'as' => 'episode.update',
            'uses' => 'EpisodeController@update'
        ]);
        Route::delete('{id}/{movieId}', [
            'as' => 'episode.destroy',
            'uses' => 'EpisodeController@destroy'
        ]);
    });
    Route::resource('user', 'UserController');
});

// Authentication routes
Route::Auth();