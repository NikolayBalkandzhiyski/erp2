<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Tasks;

class TasksRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        static $dates;

        $tasks = Tasks::all('task_date');

        foreach ($tasks as $task) {
            $dates .= $task->task_date . ',';
        }

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'task_date' => 'required|not_in:' . $dates
                ];
            }
            case 'PUT':
            case 'PATCH': {

            }
            default:
                break;
        }

//        $rules = [
//            'task_date' => 'required|not_in:'.$dates
//        ];
//
//        return $rules;
    }
}
