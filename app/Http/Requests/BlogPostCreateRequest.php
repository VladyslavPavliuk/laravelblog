<?php


namespace App\Http\Requests;


class BlogPostCreateRequest extends \Illuminate\Foundation\Http\FormRequest
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
        return [
            'title' => 'required|min:5|max:200|unique:blog_posts',
            'slug' => 'max:200',
            'excerpt' => 'max:500',
            'content_raw' => 'required|string|min:5|max:10000',
            'category_id' => 'required|integer|exists:blog_categories,id',
        ];
    }

    public function messages()
    {
        return [
          'title.requried' => 'Insert title',
          'content_raw.min' => 'Min len of post [:min] symbols',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
        ];
    }
}
