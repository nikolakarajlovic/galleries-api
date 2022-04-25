<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateGalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $gallery = $this->route('gallery');
        return $gallery->user_id == Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'title' => 'sometimes|min:2|max:255',
            'description' => 'string|max:1000|nullable',
            'images' => 'sometimes|array',
            'images.*.image_url' => 'sometimes|url|ends_with:png,jpg,jpeg'
        ];
    }
}
