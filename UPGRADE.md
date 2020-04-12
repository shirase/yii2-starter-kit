Upgrading Instructions
======================

dev
---
Change api location

3.0.24
------
Gallery rename parameter gallery to gallery_id 

3.0.23
------
Update `shirase55/yii2-helpers:3.0` break BC pull `3.0.23-bc` release for BC

3.0.22
------
New `.env` variables (use current host if empty)
```
FRONTEND_HOST =
BACKEND_HOST =
STORAGE_HOST = 
```

Changed rollup target folder on `frontend/web/bundle`, check frontend asset config

3.0.16
------
Removed deprecated namespace, pull 3.0.16-bc for BC

3.0.15
------
Pull 3.0.15-bc

3.0.11
------
Pull 3.0.11-bc

3.0.10
------
Set default value `page_type_content.template_id=1`

3.0.9
-----
Remove global `fxp/composer-asset-plugin` or comment changing aliases in `common\components\Bootstrap` for using `fxp/composer-asset-plugin`

3.0.7
-----
Update your page type plugins, use new `PageTypePlugin` interface

3.0.6
-----
Now backend and frontend css files ignored and has removed from git
Upgrade to 3.0.5.1 before

3.0.3
-----
Upgrade to 3.0.2.1 before
