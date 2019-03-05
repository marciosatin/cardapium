<?php

use Phinx\Migration\AbstractMigration;

class ChangeIdMenuItems extends AbstractMigration
{
    public function up()
    {
        $refTable = $this->table('menu_items');
        $refTable->changeColumn('id', 'integer', [
            'limit' => 22,
            'identity' => true
            ])
                ->save();
    }
    public function down()
    {
        $refTable = $this->table('menu_items');
        $refTable->changeColumn('id', 'integer', ['limit' => 11, 'identity' => true])
                ->save();
    }
}
