<?php

use yii\db\Migration;

class m160329_154532_page_tree extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%page}}', 'pid', $this->integer());
        $this->addColumn('{{%page}}', 'pos', $this->integer());
        $this->update('{{%page}}', ['pos'=>new \yii\db\Expression('id')]);
    }

    public function safeDown()
    {
        $this->dropColumn('{{%page}}', 'pid');
        $this->dropColumn('{{%page}}', 'pos');
    }
}
