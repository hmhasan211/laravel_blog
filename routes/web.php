<?php


use App\Category;
use Illuminate\Support\Facades\Route;

Auth::routes();

//frontend
Route::get('/', 'HomeController@index')->name('home');
Route::get('post/{slug}','PostController@details')->name('post.details');

//category & tag based post
Route::get('/category/{slug}','PostController@postByCategory')->name('category.posts');
Route::get('/tag/{slug}','PostController@postByTag')->name('tag.posts');

//post Author
Route::get('post/author/{username}','AuthorController@profile')->name('post.author.profile');
//frontend subscriber
Route::post('subscriber','SubscriberController@store')->name('subscriber.store');
// search
Route::get('/search','SearchController@search')->name('search');

// Authorize favourite and comment list Controller
Route::group(['middleware'=>'auth'],function (){
    Route::post('favourite/{post}/add','FavouriteController@add')->name('post.favourite');
    Route::post('comment/{post}','CommentController@store')->name('comment.store');
});

//admin Routes
Route::group(['prefix' => 'admin','namespace'=>'Admin','as'=>'admin.','middleware'=>['admin','auth']], function () {
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    //setting controller
    Route::get('settings','SettingsController@index')->name('settings');
    Route::put('profile-update','SettingsController@updateProfile')->name('update.profile');
    Route::put('password-update','SettingsController@updatePassword')->name('update.password');

    Route::resource('tag','TagController');
    Route::resource('category','CategoryController');
    Route::resource('post','PostController');

    Route::get('pending/post','PostController@pending')->name('post.pending');
    Route::put('/post/{id}/approve','PostController@approval')->name('post.approve');
    //favourite list in admin
    Route::get('/favourite','FavouriteController@index')->name('favourite.index');

    //manage comment
    Route::get('/comments','CommentController@index')->name('comments.index');
    Route::delete('comments/{id}','CommentController@destroy')->name('comments.destroy');

    Route::get('subscriber','SubscriberController@index')->name('subscriber.index');
    Route::delete('subscriber/{id}','SubscriberController@destroy')->name('subscriber.destroy');

    //author management
    Route::get('authors','AuthorController@index')->name('authors.index');
    Route::delete('authors/{id}','AuthorController@destroy')->name('authors.destroy');
});

//Author Routes
Route::group(['prefix' => 'author','namespace'=>'Author','as'=>'author.','middleware'=>['author','auth']], function () {
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    //setting controller
    Route::get('settings','SettingsController@index')->name('settings');
    Route::put('profile-update','SettingsController@updateProfile')->name('update.profile');
    Route::put('password-update','SettingsController@updatePassword')->name('update.password');

    Route::resource('post','PostController');
    //favourite list in author
    Route::get('/favourite','FavouriteController@index')->name('favourite.index');
    //manage comment
    Route::get('/comments','CommentController@index')->name('comments.index');
    Route::delete('comments/{id}','CommentController@destroy')->name('comments.destroy');
});


View::composer('layouts.frontend.partials.footer', function ($view){
    $categories = Category::all();
    $view->with('categories',$categories);
});
