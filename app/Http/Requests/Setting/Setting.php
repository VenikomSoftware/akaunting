<?php

namespace App\Http\Requests\Setting;

use App\Abstracts\Http\FormRequest;
use Illuminate\Support\Str;

class Setting extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        $prefix = $this->request->get('_prefix', null);

        switch ($prefix) {
            case 'company':
                $logo = 'mimes:'.config('filesystems.mimes')
                        .'|between:0,'.config('filesystems.max_size') * 1024
                        .'|dimensions:max_width='.config('filesystems.max_width').',max_height='.config('filesystems.max_height');

                $rules = [
                    'name' => 'required|string',
                    'email' => 'required|email',
                    'logo' => $logo,
                ];

                break;
            case 'default':
                $rules = [
                    'currency' => 'required|string|currency',
                    'locale' => 'required|string',
                    'payment_method' => 'required|string',
                ];

                break;
        }

        return $rules;
    }

    public function messages()
    {
        $logo_dimensions = trans('validation.custom.invalid_dimension', [
            'attribute' => Str::lower(trans('settings.company.logo')),
            'width' => config('filesystems.max_width'),
            'height' => config('filesystems.max_height'),
        ]);

        return [
            'logo.dimensions' => $logo_dimensions,
        ];
    }
}
