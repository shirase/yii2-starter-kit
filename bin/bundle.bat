cd "%~dp0"
CALL ..\console\yii asset ..\backend\config\assets\compress.php ..\backend\config\assets\_bundles.php
CALL ..\console\yii asset ..\frontend\config\assets\compress.php ..\frontend\config\assets\_bundles.php
