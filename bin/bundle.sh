#!/bin/bash
cd ${0%/*}
../console/yii asset ../backend/config/assets/compress.php ../backend/config/assets/_bundles.php
../console/yii asset ../frontend/config/assets/compress.php ../frontend/config/assets/_bundles.php
