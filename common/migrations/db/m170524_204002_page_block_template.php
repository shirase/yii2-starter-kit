<?php

use yii\db\Migration;

class m170524_204002_page_block_template extends Migration
{
    public function up()
    {
        $this->insert('{{%page_template}}', [
            'name' => 'Block',
            'template' => 'block',
        ]);
    }

    public function down()
    {
        $this->delete('{{%page_template}}', ['template' => 'block']);
    }
}
