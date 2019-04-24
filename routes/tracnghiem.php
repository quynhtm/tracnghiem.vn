<?php

//Quản lý câu hỏi trắc nghiệm
Route::get('question',array('as' => 'tracnghiem.questionView','uses' => TracNghiem.'\QuestionController@view'));
Route::get('question/edit/{id?}', array('as' => 'tracnghiem.questionEdit','uses' => TracNghiem.'\QuestionController@getItem'));
Route::post('question/edit/{id?}', array('as' => 'tracnghiem.questionEdit','uses' => TracNghiem.'\QuestionController@postItem'));
Route::post('question/deleteItem', array('as' => 'tracnghiem.deleteItem','uses' => TracNghiem.'\QuestionController@deleteItem'));//ajax

Route::get('question/mixAutoQuestion', array('as' => 'tracnghiem.mixAutoQuestion','uses' => TracNghiem.'\QuestionController@mixAutoQuestion'));

//Quản lý đề thi
Route::get('examQuestion',array('as' => 'tracnghiem.examQuestionView','uses' => TracNghiem.'\ExamQuestionController@view'));
Route::get('examQuestion/edit/{id?}', array('as' => 'tracnghiem.examQuestionEdit','uses' => TracNghiem.'\ExamQuestionController@getItem'));
Route::post('examQuestion/edit/{id?}', array('as' => 'tracnghiem.examQuestionEdit','uses' => TracNghiem.'\ExamQuestionController@postItem'));
Route::post('examQuestion/deleteItem', array('as' => 'tracnghiem.deleteExamQuestion','uses' => TracNghiem.'\ExamQuestionController@deleteItem'));//ajax

//trộn đề
Route::get('mixQuestions',array('as' => 'tracnghiem.mixQuestionsView','uses' => TracNghiem.'\MixQuestionController@view'));
Route::post('mixQuestions/choseQuestion', array('as' => 'tracnghiem.choseQuestion','uses' => TracNghiem.'\MixQuestionController@choseQuestion'));

//Define common
Route::match(['GET','POST'],'defineSchoolBlock', array('as' => 'tracnghiem.schoolBlock','uses' => TracNghiem.'\TracNghiemDefineController@schoolBlock'));//khối học
Route::match(['GET','POST'],'defineSubjects', array('as' => 'tracnghiem.subjects','uses' => TracNghiem.'\TracNghiemDefineController@subjects'));//môn học
Route::match(['GET','POST'],'defineThematic', array('as' => 'tracnghiem.thematic','uses' => TracNghiem.'\TracNghiemDefineController@thematic'));//chuyên đề
Route::match(['GET','POST'],'definePosition', array('as' => 'tracnghiem.position','uses' => TracNghiem.'\TracNghiemDefineController@position'));//chức vụ
Route::post('defineTracNghiem/post/{id?}', array('as' => 'tracnghiem.getDefine','uses' => TracNghiem.'\TracNghiemDefineController@postItem'))->where('id', '[0-9]+');
Route::get('defineTracNghiem/delete',array('as' => 'tracnghiem.deleteDefine','uses' => TracNghiem.'\TracNghiemDefineController@deleteItem'));
Route::post('defineTracNghiem/ajaxLoad', array('as' => 'tracnghiem.ajaxDefine','uses' => TracNghiem.'\TracNghiemDefineController@ajaxLoadForm'));


Route::get('questions-file', array('as' => 'tronNgauNhien.getTronNgauNhien','uses' => TracNghiem.'\TronNgauNhienController@getQuestionFile'));
Route::post('questions-file', array('as' => 'tronNgauNhien.postTronNgauNhien','uses' => TracNghiem.'\TronNgauNhienController@postQuestionFile'));
Route::get('questions-file/edit/{id?}', array('as' => 'tronNgauNhien.suaTronNgauNhien','uses' => TracNghiem.'\TronNgauNhienController@getItem'))->where('id', '[0-9]+');
Route::post('questions-file/edit/{id?}', array('as' => 'tronNgauNhien.suaTronNgauNhien','uses' => TracNghiem.'\TronNgauNhienController@postItem'))->where('id', '[0-9]+');
Route::post('questions-file/delete', array('as' => 'tronNgauNhien.xoaTronNgauNhien','uses' => TracNghiem.'\TronNgauNhienController@delete'));
Route::post('questions-file/approve', array('as' => 'tronNgauNhien.approveTronNgauNhien','uses' => TracNghiem.'\TronNgauNhienController@approve'));




//Link test
Route::get('post/test', array('as' => 'test.post','uses' => TracNghiem.'\TestUpFileController@post'));