<?php

use yii\db\Migration;

class m180703_143200_create_user_point extends Migration {

    public function up() {
        $table = '{{%user_point}}';
        $userTable = '{{%user}}';
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT="用户积分表"';
        }
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(),
            'direct' => $this->smallInteger(),
            'num' => $this->integer(),
            'content' => $this->string(),
            'note' => $this->string(),
            'created_at' => $this->integer(),
            "FOREIGN KEY ([[uid]]) REFERENCES {$userTable}([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%user_point}}');
    }

}
