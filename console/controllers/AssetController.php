<?php

namespace console\controllers;

use yii\console\Exception;

class AssetController extends \yii\console\controllers\AssetController
{
    protected function compressCssFiles($inputFiles, $outputFile)
    {
        if (empty($inputFiles)) {
            return;
        }
        $this->stdout("  Compressing CSS files...\n");

        $cwd = getcwd();
        chdir(dirname($outputFile));
        $outputFile = basename($outputFile);

        if (is_string($this->cssCompressor)) {
            $tmpFile = $outputFile . '.tmp';
            $this->combineCssFiles($inputFiles, $tmpFile);
            $this->stdout(shell_exec(strtr($this->cssCompressor, [
                '{from}' => escapeshellarg($tmpFile),
                '{to}' => escapeshellarg($outputFile),
            ])));
            @unlink($tmpFile);
        } else {
            call_user_func($this->cssCompressor, $this, $inputFiles, $outputFile);
        }
        if (!file_exists($outputFile)) {
            throw new Exception("Unable to compress CSS files into '{$outputFile}'.");
        }
        chdir($cwd);
        $this->stdout("  CSS files compressed into '{$outputFile}'.\n");
    }
}