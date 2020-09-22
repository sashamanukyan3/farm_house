<?php

use yii\db\Migration;

class m190612_093940_en extends Migration
{
    public function up()
    {
        $this->addColumn('contact', 'content_en', $this->text());

        $this->addColumn('faq', 'title_en', $this->string());
        $this->addColumn('faq', 'content_en', $this->text());

        $this->addColumn('instructions', 'content_en', $this->text());

        $this->addColumn('news', 'title_en', $this->string());
        $this->addColumn('news', 'teaser_en', $this->text());
        $this->addColumn('news', 'content_en', $this->text());

        $this->addColumn('chat', 'lang', $this->string());
    }

    public function down()
    {
        echo "m190612_093940_en cannot be reverted.\n";

        return false;
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
