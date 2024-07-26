# Tiktoken PHP

This is a PHP library for the Tiktok API. It wrap the npm package [tiktoken](https://www.npmjs.com/package/tiktoken) to PHP.

## Installation

```bash
composer require mathsgod/tiktoken-php-wrapper
```

```
npm i tiktoken 
```

## Usage

### Encoding

```php

use OpenAI\Tiktoken;

try {
    $enc = OpenAI\Tiktoken::EncodingForModel("gpt-4o");

    $tokens = $enc->encode("hello world!");
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

```
