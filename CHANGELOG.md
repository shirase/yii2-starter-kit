Yii Starter Kit Change Log
==========================

3.0.27-dev
------
- SeoUrlRule

3.0.26
------
- Webpack and gulp config for vue
- common/models/DynamicModel
- Not unique `pid_pos` index for page migration
- Fix sourcemap for gulp scss
- Use css for frontend and backend assets
- gulp rollup cache fix

3.0.25
------
- Use language for article
- Changes in `webpack.config.js`
- Fix DbMenu absolute url
- Fix gulp sass sourcemap
- Fix tests for mysql-5.7
- Fix page moveTo bug
- Update shirase55/yii2-tree-behavior
- Use postMessage for backend -> frontend events

3.0.24
------
- Use default for `kartik\grid\GridView::toggleData`
- composer: disable fxp-asset
- `common/behaviors/UriBehavior::uriRelation` can be empty
- request csrfParam
- gallery changes
- article index published only
- `common/components/WidgetBuilder::end` method
- static `common/components/WidgetBuilder::class`
- `common/components/helpers/Url::image` use `::storage` for svg
- index seo
- Bug: `backend/site/settings` allowed for all and change global
- docs/installation.md
- symlink.php
- `yiisoft/yii2:2.0.14`
- page/view language condition
- ContextBlockController update by id
- site/lang action
- ajax contact form on main page

3.0.23.1
--------
- Bug: Bad iframe popup close background size for Edge browser

3.0.23
------
- Fix version of `ckeditor/ckeditor: 4.7.1` for editor style bug
- Change ::className() to ::class
- Menu check visibility of items
- `ActiveQueryTrait::getAlias`
- Fix: `codeception/codeception:2.3.7` tests compatibility
- Google plus emails are inside an array. So we need to check that and use first one.
- fix readFromPhpInput on ExtendedMessageController

3.0.22
------
- Request baseUrl configuration
- npm move dependencies to devDependencies
- Changed rollup target folder on `frontend/web/bundle`
- jquery migrate

3.0.21.1
--------
- Bug: CKEditor disableAutoInline pos ready

3.0.21
------
- Mailer uses file transport for dev
- Contact form recapcha
- Remove intervention/image
- `yiisoft/yii2` 2.0.13
- bundles

3.0.20
------
- iframe popup classes
- composer.lock and bundles

3.0.19
------
- Gulp scss extension fix
- Creating page use parent language
- Article title use title
- Article itemprop description
- Article design

3.0.18
------
- console/controllers/AssetController, generate bundle with sourcePath
- Uncomment bundles config for prod
- Bundle generator slash fix
- AssetManager publish directory hash, without base
- Asset console config
- Bundle for fix `yii\widgets\PjaxAsset` end semicolon bug

3.0.17
------
- Comment using bundles
- jquery min by default

3.0.16
------
- Enable bundle for prod
- `frontend/widgets/InlineEditor::content`
- InlineEditorBuilder
- SEO by key
- Remove deprecated namespace

3.0.15
------
- commandBus backgroundHandlerBinary
- Backed page body editor only for new record
- Disable production email target log
- `common/components/web/UriRule::externalParams`
- Add page as external params for `common\components\web\UriRule`
- `common/components/web/UriRule::targetRoute`
- Add yiisoft/yii2-queue
- Glide jpeg default quality 80
- Replace less to sass
- `common/components/web/UriRule::targetParams`

3.0.14
------
- Base for gulp less
- Article query category
- Gulp rollup external jquery
- Pjax defaults
- Backend GridView defaults toggleData to false
- UrlRule use pathInfo
- Backend article delete, is ajax check
- Article dropdown status
- Article default status is published
- Backend breadcrumb h1 fix
- `kartik\dialog\DialogAsset` removed from backend bundle
- Backend js `parent != window` check
- Travis `composer global require` fixes

3.0.13
------
- Add rollup support
- Compress bundle exclude frontend and backend assets
- Flex layout
- Body has class is-frame-dialog when loaded by j-frame-dialog
- Manager can view hidden page
- Frontend j-frame-dialog expand button
- Frontend j-frame-dialog add sidebar-collapse class
- Set SQL timezone on connect

3.0.12
------
- `plugins/page_type/article/Plugin::getTypeId`
- `common/components/validators/DateValidator`
- Article changes
- Check content visibility form backend left menu
- User module, edit profile together
- Article, hide categories when one

3.0.11
------
- Page type plugin, empty model
- Config bower, npm aliases
- Update migrations

3.0.10
------
- Seed data migration remove user, manager
- Use gulp for bundle css compressor
- Remove yiisoft/yii2-codeception
- Fix: Call to undefined method `common\plugins\page_type\article\Plugin::getId()`
- Remove webpack
- Composer fxp-asset installer-paths
- Page type plugin, empty model

3.0.9
-----
- Use asset-packagist.org, remove `fxp/composer-asset-plugin` for speedup
- Add nodejs to docker
- Backend iframe events
- Backend iframe dialog
- Gulp cssnano off zindex
- Article search box
- `mdm\admin\Module` layout config
- `mdm\admin\Module` disable user menu

3.0.8
-----
- Block module
- Remove text widgets
- Add context blocks
- Page block template
- Fix: `frontend/widgets/InlineEditor` broken saveUrl when complex action name
- Carousel widget rename to gallery
- CKEditor own styles
- CKEditor block widgets
- `CKEditorAsset` table dialog user friendly

3.0.7
-----
- Page type plugin, interface changes
- Save validation behavior
- `common\components\helpers\TreeHelper::tab` fixes
- Page slug ensure unique

3.0.6
-----
- Ignore css files
- Use common user for frontend and backend
- Npm less script
- Webpack support
- Breadcrumbs getActiveUrls, checkActive methods
- DbMenu add level param
- DbMenu activeUrls
- Page template
- Uri behaviour fix

3.0.5
-----
- Merge trntv/yii2-starter-kit master
- Using gulp for frontend and backend less compilation
- Gulp watch task
- Frontend and backend css files in git now

3.0.4
-----
- Inspect code
- shirase55/ckeditor-inlinesave
- shirase55/ckeditor-image

3.0.3.1
-------
- Fix InlineEditor image dependency bug

3.0.3
-----
- Switfmailer base64contentencoder bootstrap dependency
- SendEmailCommand use mailer->compose
- InlineEditor extraAllowedContent
- Imperavi off replaceDivs
- Page slug unique as slug-language

3.0.2.1
-------
- Forward compatibility, page migration

3.0.0
-----
- Hierarchical pages
- Pages create a site structure
- Articles link to pages
- SEO url (automatic redirection and canonical)
- Gii templates
- Carousel widget backend design
- Krajee Yii Extensions
- X-editable support

2.2.1
-----
- Fixed #407: Vagrant provisioning problems 
- Fixed #400: Application initialization bug
- Added some sanitizing in ContactForm (#339)
- env() helper function added
- trntv/yii2-glide and trntv/yii2-command-bus versions updated
- Testing improvements
- PHP7 is now default for Vagrant
- Models are reformatted consistently as per conventions. #365
- Spanish translations was updated
- Fixed #392: The destinator of the mail was missing
- Maintenance mode works equally on all environments (#348)

2.2.0
-----
- Dockerfile based on PHP7
- Travis CI integration

2.1.3
-----
- Ads placing example
- DbText widget changes
- Fixed #368: User form fixes
- Fixed #369: missing field from user table in application tests

2.1.2
-----
- Fixed: Invalid user status validation
- Fixed #363: Remove references to password_reset_token

2.1.1
-----
- Mailcathcer support
- Optional user email activation

2.1.0
-----
- Enh #354: Command Bus implemented with yii2-command-bus extension
- Enh #321: editOwnModel permission
- Fixed #326
- API Fixes
- Fixed: password_confirm not validated
- Enh: Shortcuts file added
- Enh: Assets compression support
- Enh #192: Docker support
- Enh #223: Migrations for RBAC
- Enh #189: Added command bus
- Changed application setup proccess 
- Enh #184: Preserve article attachments file name
- Enh #176: Added ability to set custom view for static pages and articles
- Enh #160: LocaleBehavior::enablePreferredLanguage
- fixes and improvements

2.0.0 
-----
- Enh: Added Spanish locale
- Enh: Frontend Account and Profile actions merged into one
- Enh #146: Added MultiModel for handling multiple models at once
- Enh #145: Added Application settings + FormModel and FormWidget for keyStorage component
- Fixed: KeyStorage::set()
- Enh #147: implemented KeyStorage::has() and KeyStorage::hasAll()
- Enh: EnumColumn now loads enum as filter items
- Enh #37: REST API module example
- Enh #119: Removed default roles
- Enh #128: Articles are available via slugs
- Added Vagrant support
- testing framework configuration
- Imperavi redactor plugins enabled
- Upload Kit updated to 1.0
- AdminLTE updated to 2.0 branch
- PSR2 formatting
- ... fixes and many small changes ...

1.5.1
-----
- fixes

1.5.0
-----
- Enh: ``$cachingDuration`` parameter was added to ``common\components\keyStorage\KeyStorage::get``
- Fix: contact form fix
- Enh: "robot" email now ca be set in .env
- Enh #72: Maintenance mode
- Enh: #79 chosen locale is stored in cookies
- Enh: #84 Article Attachments
- Chg: application structure
- Chg #59: dotenv support
- Enh #61: Backend Cache Controller
- Enh: autocomplete now supports urlManagerFrontend and urlManagerBackend
- Enh #55: `components\grid\EnumColumn` for GridView
- Chng #52: Bower requirements was moved to composer
- Fix: Many `frontend/modules/user` fixes
- Fix: Autocompletion support
- Enh: FileCache now uses same path for all applications
- Enh: common\components\behaviors\CacheInvalidateBehavior
- ... Fixes ...
- Added ability to configure timezone and name of vagrant box

1.4.1
-----
- Cng #34: `Environment` class to configure application environment 
- Chg: message-migrate has moved to console/controllers/ExtendedMessageController - `yii message/migrate @common/config/messages/php.php @common/config/messages/db.php` 
- Eng #30: Tool to change code source language - `yii message/replace-source-language @path language-LOCALE`

1.4.0
-----
- Enh: backend user view page enhancement
- Enh #29: delete button on log record page
- Enh #28: init tool + local config files
- Fix #25: backend user update
- Chg: added utf-8 charset to nginx.conf
- Enh: Added filters for `log` and `file-storage` grids
- Enh: Backend now use `yii\bootstrap\ActiveForm` instead of `yii\widgets\ActiveForm`
- Enh: added `getFullName` for `UserProfile` and `getPublicIdentity` for `User`
- Fix: added some settings to prevent postfix `fatal: usage: sendmail [options]` error
- Enh: Gii Module has separate configs for backend and frontend
- Enh: Added gii templates for backend
- Enh: Time information on "system information" screen
- Fix #12: Locale bug
- Enh: I18N validation rules
- Enh: User backend controller don't available for `manager`
- Enh #11: OAuth authorization
- Fix #13: Article showing fix
- Enh: Xhprof debug panel
- ... many small enhancements and bugfixes ...

1.3.0
-----
- Enh: message configs for db, php and po formats
- Enh: `MessageController` migrate action
- Enh: I18N CRUD module
- Enh: `common\components\action\SetLocale`
- Enh: backendUrlManager, frontendUrlManager, bootstrap application

... enhancements, bugfixes