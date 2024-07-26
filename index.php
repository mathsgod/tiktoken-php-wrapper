<?php

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $enc = OpenAI\Tiktoken::EncodingForModel("gpt-4o");

    $tokens = $enc->encode("hello world aaaaa");
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}


print_R($tokens);

echo $enc->decode($tokens);

die();



//$content = file_get_contents("https://www.npmjs.com/package/tiktoken");

//file_put_contents("content.html", $content);

$file = __DIR__ . "/content.html";

$process = new Process(["node", __DIR__ . "/bin/tittoken.cjs", "encode", "gpt-4o", $file]);

echo "run";
$process->run();
if (!$process->isSuccessful()) {
    throw new ProcessFailedException($process);
}

unlink($file);
echo $process->getOutput();
