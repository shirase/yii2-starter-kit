# INSTALLATION

## TABLE OF CONTENTS
- [Before you begin](#before-you-begin)
- [Manual installation](#manual-installation)
    - [Requirements](#requirements)
    - [Setup application](#setup-application)
- [Usual hosting installation](#usual-hosting-installation)
- [Docker installation](#docker-installation)
- [Vagrant installation](#vagrant-installation)
- [Single domain installtion](#single-domain-installation)
- [Demo users](#demo-users)
- [Important-notes](#important-notes)

## Before you begin
1. If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

2. Install NPM or Yarn to build frontend scripts
- [NPM] (https://docs.npmjs.com/getting-started/installing-node)
- Yarn (https://yarnpkg.com/en/docs/install)

### Get source code
#### Download sources
https://github.com/shirase/yii2-starter-kit/archive/master.zip

#### Or clone repository manually
```
git clone https://github.com/shirase/yii2-starter-kit.git
```
#### Install composer dependencies
```
composer install
```

### Get source code via Composer
You can install this application template with `composer` using the following command:

```
composer create-project --prefer-dist --stability=dev shirase/yii2-starter-kit
```

## Manual installation

### REQUIREMENTS
The minimum requirement by this application template that your Web server supports PHP 5.6.0.
Required PHP extensions:
- intl
- gd
- mcrypt
- zip
- com_dotnet (for Windows)

### Setup application
1. Copy `.env.dist` to `.env` in the project root.
2. Adjust settings in `.env` file
	- Set debug mode and your current environment
	```
	YII_DEBUG   = true
	YII_ENV     = dev
	```
	- Set DB configuration
	```
	DB_DSN           = mysql:host=127.0.0.1;port=3306;dbname=yii2-starter-kit
	DB_USERNAME      = user
	DB_PASSWORD      = password
	```

	- Set application urls (for single domain configuration)
	```
	FRONTEND_URL    = /
	BACKEND_URL     = /admin
	STORAGE_URL     = /storage
	FRONTEND_HOST = http://yii2-starter-kit.dev
    BACKEND_HOST = http://yii2-starter-kit.dev
    STORAGE_HOST = http://yii2-starter-kit.dev
	```

	- Set application urls (for multi domain configuration)
	```
	FRONTEND_URL    = 
	BACKEND_URL     = 
	STORAGE_URL     = 
	FRONTEND_HOST = http://yii2-starter-kit.dev
    BACKEND_HOST = http://backend.yii2-starter-kit.dev
    STORAGE_HOST = http://storage.yii2-starter-kit.dev
	```

3. Run in command line
```
php console/yii app/setup
npm install
npm run build
```

## Apache development installation (IMPORTANT! Do not use for production!)
- Use project root as apache webroot directory

## Hosting installation
- Remove `Assets` section from `.gitignore`
- Build assets, run `npm run build` (install npm before)
- Change `style.scss` to `style.css` in `frontend/assets/FrontendAsset.php` and `backend/assets/BackendAsset.php` files
- Build bundle, run `./bin/bundle.sh` (Linux) or `bin\bundle.bat` (Windows)
- Copy all files to hosting, outside of webroot directory, `app` for example. Use `git` if you can.

### If you have ssh access and can make symlink 
- Rename or remove current webroot directory
- Make symlink `frontend/web` to `public_html`
- Make symlink `backend/web` to `public_html/admin`
- Make symlink `storage/web` to `public_html/storage`

### If you have only FTP access
- Upload `symlink.php` to webroot directory, run it like `http://example.com/symlink.php`
- Delete `symlink.php`

#### If not have rights
- Change paths in `index.php` files
- Upload `frontend/web` files to `public_html`
- Upload `backend/web` files to `public_html/admin`
- Upload `storage/web` files to `public_html/storage`

## Docker installation
1. Follow [docker install](https://docs.docker.com/engine/installation/) instruction to install docker
2. Copy `.env.dist` to `.env` in the project root
3. Change `.env` DB_DSN host to "db"
4. Run `docker-compose build`
5. Run `docker-compose up -d`
6. Log into the app container via `docker-compose exec app bash`
7. Install composer per instuctions available at [Composer](https://getcomposer.org/download/)
8. Run `composer install --profile --prefer-dist -o -v`
- If asked for a token aquire one from your [github account](https://github.com/settings/tokens).
9. Setup application with `php ./console/yii app/setup --interactive=0`
10. Run `npm install`
11. Exit the app container by using `exit`
12. That's all - your application is accessible on http://127.0.0.1:81

 * - docker host IP address may vary on Windows and MacOS systems
 
*PS* Also you can use bash inside application container. To do so run `docker-compose exec app bash`

### Docker FAQ
1. How do i run yii console commands from outside a container?

`docker-compose exec app console/yii help`

`docker-compose exec app console/yii migrate`

`docker-compose exec app console/yii rbac-migrate`

2. How to connect to the application database with my workbench, navicat etc?
MySQL is available on `yii2-starter-kit.dev`, port `3306`. User - `root`, password - `root`

## Vagrant installation
If you want, you can use bundled Vagrant instead of installing app to your local machine.

1. Install [Vagrant](https://www.vagrantup.com/)
2. Copy files from `docs/vagrant-files` to application root
3. Copy `./vagrant/vagrant.yml.dist` to `./vagrant/vagrant.yml`
4. Create GitHub [personal API token](https://github.com/blog/1509-personal-api-tokens)
5. Edit values as desired including adding the GitHub personal API token to `./vagrant/vagrant.yml`
6. Run:
```
vagrant plugin install vagrant-hostmanager
vagrant up
```
That`s all. After provision application will be accessible on http://yii2-starter-kit.dev

## Demo data
### Demo Users
```
Login: webmaster
Password: webmaster

Login: manager
Password: manager

Login: user
Password: user
```

## Important notes
- There is a VirtualBox bug related to sendfile that can lead to corrupted files, if not turned-off
Uncomment this in your nginx config if you are using Vagrant:
```sendfile off;```
