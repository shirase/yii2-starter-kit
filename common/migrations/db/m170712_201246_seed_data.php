<?php

use yii\db\Migration;

class m170712_201246_seed_data extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'webmaster',
            'email' => 'webmaster@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('webmaster'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'status' => \common\models\User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('{{%user_profile}}', [
            'user_id'=>1,
            'locale'=>Yii::$app->sourceLanguage,
            'firstname' => 'John',
            'lastname' => 'Doe'
        ]);

        $this->insert('{{%page}}', [
            'id'=>1,
            'slug'=>'main-menu',
            'name'=>'Main menu',
            'pid'=>0,
            'pos'=>1,
            'language'=>Yii::$app->language,
            'created_at'=> new \yii\db\Expression('NOW()'),
            'updated_at'=> new \yii\db\Expression('NOW()'),
            'bpath'=>\shirase\tree\TreeBehavior::toBase255(array(1))
        ]);

        $this->insert('{{%page}}', [
            'slug'=>'about',
            'name'=>'About',
            'status'=>1,
            'pid'=>1,
            'pos'=>2,
            'language'=>Yii::$app->language,
            'created_at'=> new \yii\db\Expression('NOW()'),
            'updated_at'=> new \yii\db\Expression('NOW()'),
            'body'=>'Lorem ipsum',
            'bpath'=>\shirase\tree\TreeBehavior::toBase255(array(1, 2))
        ]);

        $this->insert('{{%gallery}}', [
            'id'=>1,
            'key'=>'index',
            'status'=>1
        ]);

        $this->insert('{{%gallery_item}}', [
            'gallery_id'=>1,
            'url'=>'/',
            'path'=>'/img/yii2-starter-kit.gif',
            'status'=>1
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.theme-skin',
            'value' => 'skin-blue',
            'comment' => 'skin-blue, skin-black, skin-purple, skin-green, skin-red, skin-yellow'
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-fixed',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-boxed',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-collapsed-sidebar',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.maintenance',
            'value' => 'disabled',
            'comment' => 'Set it to "true" to turn on maintenance mode'
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%key_storage_item}}', [
            'key' => 'frontend.maintenance'
        ]);

        $this->delete('{{%key_storage_item}}', [
            'key' => [
                'backend.theme-skin',
                'backend.layout-fixed',
                'backend.layout-boxed',
                'backend.layout-collapsed-sidebar',
            ],
        ]);

        $this->delete('{{%gallery_item}}', [
            'carousel_id'=>1
        ]);

        $this->delete('{{%gallery}}', [
            'id'=>1
        ]);

        $this->delete('{{%widget_text}}', [
            'key'=>'backend_welcome'
        ]);

        $this->delete('{{%page}}', [
            'slug' => ['about', 'article', 'main-menu']
        ]);

        $this->delete('{{%user_profile}}', [
            'user_id' => 1
        ]);

        $this->delete('{{%user}}', [
            'id' => 1
        ]);
    }
}
