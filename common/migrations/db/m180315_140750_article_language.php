<?php

use yii\db\Migration;

/**
 * Class m180315_140750_article_language
 */
class m180315_140750_article_language extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('article', 'language', $this->string(5)->defaultValue('ru-RU'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180315_140750_article_language cannot be reverted.\n";

        return false;
    }
}
