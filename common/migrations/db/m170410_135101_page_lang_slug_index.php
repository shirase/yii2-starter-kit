<?php

use yii\db\Migration;

class m170410_135101_page_lang_slug_index extends Migration
{
    public function up()
    {
        $this->dropIndex('slug', '{{%page}}');
        $this->createIndex('slug', '{{%page}}', ['slug(100)', 'language'], true);
    }

    public function down()
    {
        echo "m170410_135101_page_lang_slug_index cannot be reverted.\n";

        return false;
    }
}
