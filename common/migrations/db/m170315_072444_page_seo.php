<?php

use yii\db\Migration;

class m170315_072444_page_seo extends Migration
{
    public function up()
    {
        $this->addColumn('{{%page}}', 'page_title', $this->string(255)->null());
        $this->addColumn('{{%page}}', 'page_keywords', $this->string(255)->null());
        $this->addColumn('{{%page}}', 'page_description', $this->string(255)->null());
    }

    public function down()
    {
        $this->dropColumn('{{%page}}', 'page_title');
        $this->dropColumn('{{%page}}', 'page_keywords');
        $this->dropColumn('{{%page}}', 'page_description');
    }
}
