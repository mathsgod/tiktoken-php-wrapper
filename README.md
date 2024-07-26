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

$enc = OpenAI\Tiktoken::EncodingForModel("gpt-4o");
$tokens = $enc->encode("hello world!");

```


### Decoding

```php
use OpenAI\Tiktoken;

$enc = OpenAI\Tiktoken::EncodingForModel("gpt-4o");
$text = $enc->decode([24912,2375]);
```


