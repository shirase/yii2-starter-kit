<?php
namespace console\controllers;

use Yii;
use yii\console\Exception;
use yii\helpers\Console;
use yii\helpers\VarDumper;
use yii\web\AssetBundle;

class AssetController extends \yii\console\controllers\AssetController
{
    /**
     * Saves new asset bundles configuration.
     * @param \yii\web\AssetBundle[] $targets list of asset bundles to be saved.
     * @param string $bundleFile output file name.
     * @throws \yii\console\Exception on failure.
     */
    protected function saveTargets($targets, $bundleFile)
    {
        $array = [];
        foreach ($targets as $name => $target) {
            if (isset($this->targets[$name])) {
                $array[$name] = array_merge($this->targets[$name], [
                    'class' => get_class($target),
                    'sourcePath' => null,
                    'basePath' => $this->targets[$name]['basePath'],
                    'baseUrl' => $this->targets[$name]['baseUrl'],
                    'js' => $target->js,
                    'css' => $target->css,
                    'depends' => [],
                ]);
            } else {
                if ($this->isBundleExternal($target)) {
                    $array[$name] = $this->composeBundleConfig($target);
                } else {
                    $sourcePath = $this->checkAliases($target->sourcePath, ['@bower', '@npm', '@yii', '@vendor', '@base']);
                    $array[$name] = [
                        'sourcePath' => $sourcePath,
                        'js' => [],
                        'css' => [],
                        'depends' => $target->depends,
                    ];
                }
            }
        }
        $array = VarDumper::export($array);
        $version = date('Y-m-d H:i:s', time());
        $bundleFileContent = <<<EOD
<?php
/**
 * This file is generated by the "yii {$this->id}" command.
 * DO NOT MODIFY THIS FILE DIRECTLY.
 * @version {$version}
 */
return {$array};
EOD;
        if (!file_put_contents($bundleFile, $bundleFileContent)) {
            throw new Exception("Unable to write output bundle configuration at '{$bundleFile}'.");
        }
        $this->stdout("Output bundle configuration created at '{$bundleFile}'.\n", Console::FG_GREEN);
    }

    /**
     * @param AssetBundle $bundle
     * @return bool whether asset bundle external or not.
     */
    private function isBundleExternal($bundle)
    {
        return (empty($bundle->sourcePath) && empty($bundle->basePath));
    }

    /**
     * @param AssetBundle $bundle asset bundle instance.
     * @return array bundle configuration.
     */
    private function composeBundleConfig($bundle)
    {
        $config = Yii::getObjectVars($bundle);
        $config['class'] = get_class($bundle);
        return $config;
    }

    private function checkAliases($path, $aliases) {
        foreach ($aliases as $alias) {
            $prefix = Yii::getAlias($alias);
            if (strpos($path, $prefix)===0) {
                return $alias.str_replace('\\', '/', substr($path, strlen($prefix)));
            }
        }
        return null;
    }
}