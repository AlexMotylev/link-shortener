<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @property string $url url for redirect
 * @property string $hash hash that is part of the link
 * @property string $secret_key secret key for control link
 */
class Link extends Model
{
    /**
     * Validate url property. If it is not correct, an exception is thrown
     *
     * @throws ValidationException
     */
    public function validate()
    {
        $validator = Validator::make(['url' => $this->url], [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }


}
