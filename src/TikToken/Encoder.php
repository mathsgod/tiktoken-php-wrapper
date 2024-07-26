<?php

namespace OpenAI\Tiktoken;

use Exception;
use Symfony\Component\Process\Process;

class Encoder
{
    protected string $includePath = '$PATH:/usr/local/bin:/opt/homebrew/bin';

    private string $model;
    public function __construct(string $model)
    {
        $this->model = $model;
    }

    protected function getNodePathCommand(string $nodeBinary): string
    {
        return 'NODE_PATH=`npm root -g`';
    }

    protected function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    public function decode(array $tokens): string
    {
        //write to file
        $file = tempnam(sys_get_temp_dir(), 'tiktoken');
        file_put_contents($file, json_encode($tokens));

        if ($this->isWindows()) {
            $process = new Process([
                "node",
                __DIR__ . "/../../bin/tiktoken.cjs",
                "-m", $this->model,
                "-f", $file,
                "-d"
            ]);
        } else {
            $setIncludePath = "PATH={$this->includePath}";

            $process = Process::fromShellCommandline(
                $setIncludePath . ' ' .
                    $this->getNodePathCommand('node') . ' ' .
                    'node ' .
                    escapeshellarg(__DIR__ . "/../../bin/tiktoken.cjs") .
                    ' -m ' . escapeshellarg($this->model) .
                    ' -f ' . escapeshellarg($file) .
                    ' -d'
            );
        }

        $process->run();
        unlink($file);

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

        if ($this->isWindows()) {
            $process = new Process([
                "node",
                __DIR__ . "/../../bin/tiktoken.cjs",
                "-m", $this->model,
                "-f", $file,
                "-e"
            ]);
        } else {

            $setIncludePath = "PATH={$this->includePath}";

            Process::fromShellCommandline(
                $setIncludePath . ' ' .
                    $this->getNodePathCommand('node') . ' ' .
                    'node ' .
                    escapeshellarg(__DIR__ . "/../../bin/tiktoken.cjs") .
                    ' -m ' . escapeshellarg($this->model) .
                    ' -f ' . escapeshellarg($file) .
                    ' -e'
            )->run();
        }


        $process->run();
        unlink($file);

        if (!$process->isSuccessful()) {
            throw new Exception($process->getErrorOutput());
        }


        return json_decode($process->getOutput(), true);
    }
}
