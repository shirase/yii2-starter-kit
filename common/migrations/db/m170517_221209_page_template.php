<?php

use yii\db\Migration;

class m170517_221209_page_template extends Migration
{
    public function up()
    {
        $this->addColumn('{{%page}}', 'template', $this->string(100));
    }

    public function down()
    {
        $this->dropColumn('{{%page}}', 'template');
    }
}
