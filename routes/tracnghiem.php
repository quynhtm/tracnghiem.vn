<?php

//Quản lý câu hỏi trắc nghiệm
Route::get('question',array('as' => 'tracnghiem.questionView','uses' => TracNghiem.'\QuestionController@view'));
Route::get('question/edit/{id?}', array('as' => 'tracnghiem.questionEdit','uses' => TracNghiem.'\QuestionController@getItem'));
Route::post('question/edit/{id?}', array('as' => 'tracnghiem.questionEdit','uses' => TracNghiem.'\QuestionController@postItem'));
Route::post('question/deleteItem', array('as' => 'tracnghiem.deleteItem','uses' => TracNghiem.'\QuestionController@deleteItem'));//ajax

//Define common
Route::match(['GET','POST'],'defineSchoolBlock', array('as' => 'tracnghiem.schoolBlock','uses' => TracNghiem.'\TracNghiemDefineController@schoolBlock'));//khối học
Route::match(['GET','POST'],'defineSubjects', array('as' => 'tracnghiem.subjects','uses' => TracNghiem.'\TracNghiemDefineController@subjects'));//môn học
Route::match(['GET','POST'],'defineThematic', array('as' => 'tracnghiem.thematic','uses' => TracNghiem.'\TracNghiemDefineController@thematic'));//chuyên đề
Route::match(['GET','POST'],'definePosition', array('as' => 'tracnghiem.position','uses' => TracNghiem.'\TracNghiemDefineController@position'));//chức vụ
Route::post('defineTracNghiem/post/{id?}', array('as' => 'tracnghiem.getDefine','uses' => TracNghiem.'\TracNghiemDefineController@postItem'))->where('id', '[0-9]+');
Route::get('defineTracNghiem/delete',array('as' => 'tracnghiem.deleteDefine','uses' => TracNghiem.'\TracNghiemDefineController@deleteItem'));
Route::post('defineTracNghiem/ajaxLoad', array('as' => 'tracnghiem.ajaxDefine','uses' => TracNghiem.'\TracNghiemDefineController@ajaxLoadForm'));