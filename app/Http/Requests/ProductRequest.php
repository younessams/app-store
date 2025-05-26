<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            //images validation
            'images'          => ['required', 'array', 'min:1'], // Must have at least 1 image
            'images.*.name'   => ['required', 'string', 'max:255'],
            'images.*.size'   => ['required', 'integer', 'max:10240'], // 10MB limit
            'images.*.type'   => ['required', 'in:image/jpeg,image/png,image/jpg'],
            'images.*.file'   => ['required', 'file', 'mimes:png,jpg', 'max:10240'], // File validation
            'images.*.is_primary' => ['required', 'boolean'], // Must be true or false


            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'required|string|max:255',
            'weight' => 'nullable|numeric',
            'gender' => 'required|in:male,female',

            'sizes' => 'required|array',
            'sizes.*' => 'integer|exists:sizes,id', 

            'colors' => 'required|array',
            'colors.*' => 'integer|exists:colors,id',

            'description' => 'required|string',
            'tag_number' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',

            'tags' => 'required|array',
            'tags.*' => 'required|exists:tags,id',

            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',


        ];
    }

    public function messages()
{
    return [
        // Custom message for the 'images' array
        'images.required' => 'At least one image is required.',
        'images.array' => 'The images field must be an array.',
        'images.min' => 'You must provide at least one image.',

        // Custom messages for each image in the 'images.*' array
        'images.*.name.required' => 'Each image must have a name.',
        'images.*.name.string' => 'Each image name must be a string.',
        'images.*.name.max' => 'Each image name cannot be longer than 255 characters.',

        'images.*.size.required' => 'Each image must have a size.',
        'images.*.size.array' => 'The size of each image must be specified as an array.',
        'images.*.size.max' => 'Each image cannot exceed 10MB in size.',

        'images.*.type.required' => 'Each image must have a valid type.',
        'images.*.type.in' => 'The image type must be either PNG or JPG.',

        'images.*.file.required' => 'Each image must be a file.',
        'images.*.file.mimes' => 'Each image must be in PNG or JPG format.',
        'images.*.file.max' => 'Each image cannot exceed 10MB in file size.',

        'images.*.is_primary.required' => 'You must specify if an image is primary.',
        'images.*.is_primary.boolean' => 'The "is_primary" field must be either true or false.',
    ];
}

}
