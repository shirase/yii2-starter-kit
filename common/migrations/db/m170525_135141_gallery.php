<?php

use yii\db\Migration;

class m170525_135141_gallery extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_item_carousel', '{{%widget_carousel_item}}');
        $this->renameTable('{{%widget_carousel_item}}', '{{%gallery_item}}');
        $this->renameColumn('{{%gallery_item}}', 'carousel_id', 'gallery_id');
        $this->renameColumn('{{%gallery_item}}', 'caption', 'title');
        $this->renameTable('{{%widget_carousel}}', '{{%gallery}}');
        $this->addForeignKey('fk_gallery', '{{%gallery_item}}', 'gallery_id', '{{%gallery}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('fk_gallery', '{{%gallery_item}}');
        $this->renameTable('{{%gallery_item}}', '{{%widget_carousel_item}}');
        $this->renameColumn('{{%widget_carousel_item}}', 'gallery_id', 'carousel_id');
        $this->renameColumn('{{%widget_carousel_item}}', 'title', 'caption');
        $this->renameTable('{{%gallery}}', '{{%widget_carousel}}');
        $this->addForeignKey('fk_item_carousel', '{{%widget_carousel_item}}', 'carousel_id', '{{%widget_carousel}}', 'id', 'RESTRICT', 'RESTRICT');
    }
}
