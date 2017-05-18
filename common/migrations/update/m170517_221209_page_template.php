<?php

use yii\db\Migration;

class m170517_221209_page_template extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page_template}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'template' => $this->string(100),
        ], $tableOptions);
        $this->insert('{{%page_template}}', ['id'=>1, 'name'=>'Default', 'template'=>'view']);

        $this->createTable('{{%page_type_content}}', [
            'id' => $this->primaryKey(),
            'template_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_page_type_content_id', '{{%page_type_content}}', 'id', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_page_type_content_template', '{{%page_type_content}}', 'template_id', '{{%page_template}}', 'id', 'RESTRICT', 'CASCADE');

        $this->dropForeignKey('fk_page_type', '{{%page}}');
        $this->db->createCommand('UPDATE {{%page_type}} SET id=id+1, pos=pos+1 ORDER BY id DESC')->execute();
        $this->insert('{{%page_type}}', ['id'=>1, 'pos'=>1, 'name'=>'Текстовая страница', 'plugin'=>'common\plugins\page_type\content\Plugin']);
        $this->update('{{%page}}', ['type_id' => new \yii\db\Expression('type_id+1')]);
        $this->update('{{%page}}', ['type_id' => 1], ['type_id' => null]);
        $this->alterColumn('{{%page}}', 'type_id', $this->integer()->defaultValue(1)->notNull());
        $this->addForeignKey('fk_page_type', '{{%page}}', 'type_id', '{{%page_type}}', 'id', 'RESTRICT', 'CASCADE');
    }

    public function down()
    {
        $this->alterColumn('{{%page}}', 'type_id', $this->integer()->null());
        $this->update('{{%page}}', ['type_id' => null], ['type_id' => 1]);
        $this->db->createCommand('UPDATE {{%page_type}} SET id=id-1, pos=pos-1 ORDER BY id ASC')->execute();
        $this->dropTable('{{%page_type_content}}');
        $this->dropTable('{{%page_template}}');
    }
}
