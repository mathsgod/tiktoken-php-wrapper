<?php

namespace OpenAI\Tiktoken;

use Exception;
use Symfony\Component\Process\Process;

class Encoder
{
    private string $model;
    public function __construct(string $model)
    {
        $this->model = $model;
    }

    public function decode(array $tokens): string
    {
        //write to file
        $file = tempnam(sys_get_temp_dir(), 'tiktoken');
        file_put_contents($file, json_encode($tokens));

        $process = new Process([
            "node",
            __DIR__ . "/../../bin/tiktoken.cjs",
            "-m", $this->model,
            "-f", $file,
            "-d"
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new Exception($process->getErrorOutput());
        }

        return $process->getOutput();
    }

    public function encode(string $text): array
    {
        //write to file
        $file = tempnam(sys_get_temp_dir(), 'tiktoken');
        file_put_contents($file, $text);

        $process = new Process([
            "node",
            __DIR__ . "/../../bin/tiktoken.cjs",
            "-m", $this->model,
            "-f", $file,
            "-e"
        ]);

        $process->run();
        unlink($file);

        if (!$process->isSuccessful()) {
            throw new Exception($process->getErrorOutput());
        }


        return json_decode($process->getOutput(), true);
    }
}
