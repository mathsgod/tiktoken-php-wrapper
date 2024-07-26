<?php

namespace OpenAI;

use OpenAI\Tiktoken\Encoder;

class Tiktoken
{

    public static function EncodingForModel(string $model)
    {

        return new Encoder($model);
    }
}
