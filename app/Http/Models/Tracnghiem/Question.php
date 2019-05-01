<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Models\Tracnghiem;

use App\Http\Models\Admin\User;
use App\Http\Models\BaseModel;

use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\Memcache;
use Illuminate\Support\Facades\Cache;
use PDOException;

class Question extends BaseModel
{
    protected $table = TABLE_QUESTION;
    protected $primaryKey = 'id';
    public $timestamps = true;
    public static $arrApprove = array(
			STATUS_INT_AM_MOT => '--Chọn duyệt--',
			STATUS_INT_KHONG => 'Chưa duyệt',
			STATUS_INT_MOT =>'Chờ duyệt',
			STATUS_INT_HAI => 'Đã duyệt'
		);

    protected $fillable = array('question_name', 'question_type','question_approved', 'question_status', 'answer_1','answer_2', 'answer_3', 'answer_4', 'answer_5', 'answer_6',
        'correct_answer', 'created_at', 'updated_at', 'user_id_creater', 'user_name_creater', 'user_id_update', 'user_name_update', 'question_school_block', 'question_subject', 'question_thematic');

    public function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, $is_total = true)
    {
        try {
            $query = Question::where('id', '>', 0);
            if (isset($dataSearch['question_name']) && $dataSearch['question_name'] != '') {
                $query->where('question_name', 'LIKE', '%' . $dataSearch['question_name'] . '%');
            }
            if (isset($dataSearch['question_approved']) && $dataSearch['question_approved'] > -1) {
                $query->where('question_approved', $dataSearch['question_approved']);
            }
            if (isset($dataSearch['question_status']) && $dataSearch['question_status'] > -1) {
                $query->where('question_status', $dataSearch['question_status']);
            }
            if (isset($dataSearch['question_type']) && $dataSearch['question_type'] > 0) {
                $query->where('question_type', $dataSearch['question_type']);
            }
            if (isset($dataSearch['question_id']) && !empty($dataSearch['question_id'])) {
                $query->whereIn('id', $dataSearch['question_id']);
            }

            if (isset($dataSearch['list_question_id']) && !empty($dataSearch['list_question_id'])) {
                $query->whereIn('id', explode(',',$dataSearch['list_question_id']));
            }

            if (isset($dataSearch['question_school_block']) && $dataSearch['question_school_block'] > 0) {
                $query->where('question_school_block', $dataSearch['question_school_block']);
            }
            if (isset($dataSearch['question_subject']) && $dataSearch['question_subject'] > 0) {
                $query->where('question_subject', $dataSearch['question_subject']);
            }
            if (isset($dataSearch['question_thematic']) && $dataSearch['question_thematic'] > 0) {
                $query->where('question_thematic', $dataSearch['question_thematic']);
            }

            if(isset($dataSearch['created_at_from']) && isset($dataSearch['created_at_to']) && $dataSearch['created_at_from'] !='' && $dataSearch['created_at_to'] !=''){
                $time_create_from = FunctionLib::convertDate($dataSearch['created_at_from'].' 00:00:00');
                $time_create_to = FunctionLib::convertDate($dataSearch['created_at_to']. ' 23:59:59');
                if($time_create_to >= $time_create_from && $time_create_to > 0){
                    $query->where('created_at', '>=', date('Y-m-d', $time_create_from).' 00:00:00');
                    $query->where('created_at', '<=', date('Y-m-d', $time_create_from).' 23:59:59');
                }
            }

            $total = ($is_total) ? $query->count() : 0;

            $query->orderBy('id', 'desc');

            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result, 'total' => $total];

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function createItem($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = new Question();
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->user_id_creater = app(User::class)->user_id();
                $item->user_name_creater = app(User::class)->user_name();
                $item->save();
                self::removeCache($item->id, $item);
                return $item->id;
            }
            return false;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function updateItem($id, $data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = self::getItemById($id);
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->user_id_update = app(User::class)->user_id();
                $item->user_name_update = app(User::class)->user_name();
                $item->update();
                self::removeCache($item->id, $item);
            }
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function getItemById($id)
    {
        $data = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_QUESTION_ID . $id) : false;
        if (!$data) {
            $data = Question::find($id);
            if ($data) {
                Cache::put(Memcache::CACHE_QUESTION_ID . $id, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= 0) return false;
        try {
            $item = $dataOld = self::getItemById($id);
            if ($item) {
                $item->delete();
                self::removeCache($id, $dataOld);
            }
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
            return false;
        }
    }

    public function removeCache($id = 0, $data = [])
    {
        if ($id > 0) {
            Cache::forget(Memcache::CACHE_QUESTION_ID . $id);
        }
    }
}
