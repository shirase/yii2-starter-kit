<?php

use yii\db\Migration;

class m160512_194404_page_type extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page_type}}', [
            'id' => $this->primaryKey(),
            'pos' => $this->integer(),
            'name' => $this->string(100)->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'plugin' => $this->string(100),
        ], $tableOptions);

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
        $this->insert('{{%page_type}}', ['pos'=>1, 'name'=>'Текстовая страница', 'plugin'=>'common\plugins\page_type\content\Plugin']);

        $this->createTable('{{%page_type_page}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer(),
            'canonical' => $this->smallInteger(1),
        ], $tableOptions);
        $this->addForeignKey('fk_page_type_page_id', '{{%page_type_page}}', 'id', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_page_type_page_page', '{{%page_type_page}}', 'page_id', '{{%page}}', 'id', 'RESTRICT', 'CASCADE');
        $this->insert('{{%page_type}}', ['pos'=>2, 'name'=>'Ссылка на страницу', 'plugin'=>'common\plugins\page_type\page\Plugin']);

        $this->createTable('{{%page_type_link}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string(255),
        ], $tableOptions);
        $this->addForeignKey('fk_page_type_link_id', '{{%page_type_link}}', 'id', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
        $this->insert('{{%page_type}}', ['pos'=>3, 'name'=>'Произвольная ссылка', 'plugin'=>'common\plugins\page_type\link\Plugin']);

        $this->createTable('{{%page_type_article}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
        ], $tableOptions);
        $this->addForeignKey('fk_page_type_article_id', '{{%page_type_article}}', 'id', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
        $this->insert('{{%page_type}}', ['pos'=>4, 'name'=>'Статьи', 'plugin'=>'common\plugins\page_type\article\Plugin']);

        $this->addColumn('{{%page}}', 'type_id', $this->integer()->defaultValue(1)->notNull());
        $this->createIndex('type_bpath', '{{%page}}', array('type_id', 'bpath(100)'), true);
        $this->addForeignKey('fk_page_type', '{{%page}}', 'type_id', '{{%page_type}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%page_type_content}}');
        $this->dropTable('{{%page_type_page}}');
        $this->dropTable('{{%page_type_link}}');
        $this->dropTable('{{%page_type_article}}');

        $this->dropTable('{{%page_template}}');

        $this->dropForeignKey('fk_page_type', '{{%page}}');
        $this->dropColumn('{{%page}}', 'type_id');
        $this->dropTable('{{%page_type}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
