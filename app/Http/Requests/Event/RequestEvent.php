<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class RequestEvent extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max: 255',
            'description' => 'max:1000',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at' => 'required|date|after_or_equal:start_at|after_or_equal:now',
            'thumbnail' => 'required|mimes:jpeg,png,jpg|max:10000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống',
            'name.max' => 'Tên không được lớn hơn 255 ký tự',
            'start_at.before_or_equal' => 'Thời gian bắt đầu không được nhỏ hơn thời gian kết thúc',
            'end_at.after_or_equal:start_at' => 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu',
            'end_at.after_or_equal' => 'Thời gian kết thúc phải lớn hơn thời điểm hiện tại',
        ];
    }
}
