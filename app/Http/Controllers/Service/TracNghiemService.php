<?php
/**
 * Created by IntelliJ IDEA.
 * User: namnv
 * Date: 6/6/18
 * Time: 8:17 PM
 */

namespace App\Http\Controllers\Service;

use App\Http\Models\Tracnghiem\Question;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class TracNghiemService
{
    public function getListQuestion($seach = [])
    {
        $arrField = ['id', 'question_name', 'answer_1', 'answer_2', 'answer_3', 'answer_4', 'answer_5', 'answer_6', 'correct_answer'];
        $data = Question::where('id', '>', 0)->get($arrField);
        $dataTron = [];
        if ($data) {
            foreach ($data->toArray() as $v) {
                $list_dap_an = [];
                for ($i = 1; $i <= 6; $i++) {
                    $key_q = 'answer_' . $i;
                    if (isset($v[$key_q]) && trim($v[$key_q]) != '') {
                        $list_dap_an[$key_q] = trim($v[$key_q]);
                    }
                }
                $v['list_answer'] = $list_dap_an;
                $dataTron[$v['id']] = $v;
            }
        }
    }

    public function mixAutoQuestion($data = [])
    {
        $total = count($data);
        $result = [];
        if ($total > 0) {
            for ($i = 1; $i <= $total; $i++) {
                $random_keys = array_rand($data, 1);
                $question = $data[$random_keys];
                //answer
                if (isset($question['list_answer'])) {
                    $question['list_answer'] = self::mixAutoAnswer($question['list_answer']);
                }
                $result[$random_keys] = $question;
                unset($data[$random_keys]);
            }
        }
        return $result;
    }

    public function mixAutoAnswer($answer = [])
    {
        $total = count($answer);
        $result = [];
        if ($total > 0) {
            for ($i = 1; $i <= $total; $i++) {
                $random_keys = array_rand($answer, 1);
                $result[$random_keys] = $answer[$random_keys];
                unset($answer[$random_keys]);
            }
        }
        return $result;
    }
}