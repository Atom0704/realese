<?php

Route::get('/', ['as' => 'branches', 'uses' => 'CommentsController@index']);

Route::get('/comment/branch/{id}', ['as' => 'branch', 'uses' => 'CommentsController@getBranch']);

Route::post('/comment/rating', ['as' => 'comment.rating', 'uses' => 'CommentsController@rating']);

Route::post('/comment/delete', ['as' => 'comment.delete', 'uses' => 'CommentsController@delete']);

Route::post('/comment/edit', ['as' => 'comment.edit', 'uses' => 'CommentsController@edit']);

Route::post('/comment/insert', ['as' => 'comment.insert', 'uses' => 'CommentsController@insert']);

Auth::routes();
