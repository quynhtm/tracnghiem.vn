<?php

//Quản lý câu hỏi trắc nghiệm
Route::get('question',array('as' => 'tracnghiem.questionView','uses' => TracNghiem.'\QuestionController@view'));
Route::get('question/edit/{id?}', array('as' => 'tracnghiem.questionEdit','uses' => TracNghiem.'\QuestionController@getItem'));
Route::post('question/edit/{id?}', array('as' => 'tracnghiem.questionEdit','uses' => TracNghiem.'\QuestionController@postItem'));
Route::post('question/deleteItem', array('as' => 'tracnghiem.deleteItem','uses' => TracNghiem.'\QuestionController@deleteItem'));//ajax
