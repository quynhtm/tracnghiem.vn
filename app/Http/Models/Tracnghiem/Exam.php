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

use App\Library\AdminFunction\Memcache;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Exam extends BaseModel
{
    protected $table = TABLE_EXAM;
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = array('exam_name', 'question_exam_id','school_year','school_block_id','school_block_name', 'subjects_id', 'subjects_name', 'time_to_do', 'total_question',
        'total_point', 'created_at', 'updated_at', 'user_id_creater', 'user_name_creater', 'user_id_update', 'user_name_update');

    public function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, $is_total = true)
    {
        try {
            $query = Exam::where('id', '>', 0);
            if (isset($dataSearch['question_name']) && $dataSearch['question_name'] != '') {
                $query->where('question_name', 'LIKE', '%' . $dataSearch['question_name'] . '%');
            }
            if (isset($dataSearch['define_code']) && $dataSearch['define_code'] != '') {
                $query->where('define_code', $dataSearch['define_code']);
            }
            if (isset($dataSearch['question_approved']) && $dataSearch['question_approved'] > -1) {
                $query->where('question_approved', $dataSearch['question_approved']);
            }
            if (isset($dataSearch['question_type']) && $dataSearch['question_type'] > 0) {
                $query->where('question_type', $dataSearch['question_type']);
            }
            $total = ($is_total) ? $query->count() : 0;

            $query->orderBy('id', 'asc');

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
            $item = new Exam();
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
        $data = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_QUESTION_EXAM_ID . $id) : false;
        if (!$data) {
            $data = Exam::find($id);
            if ($data) {
                Cache::put(Memcache::CACHE_QUESTION_EXAM_ID . $id, $data, CACHE_THREE_MONTH);
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
            Cache::forget(Memcache::CACHE_QUESTION_EXAM_ID . $id);
        }
    }
}
