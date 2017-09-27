<?php

use Phinx\Migration\AbstractMigration;

class CreateMenusTable extends AbstractMigration
{

    public function up()
    {
        $this->table('menus')
                ->addColumn('name', 'string')
                ->addColumn('type_id', 'integer')
                ->addColumn('dt_start', 'date')
                ->addColumn('dt_end', 'date')
                ->addColumn('created_at', 'datetime')
                ->addColumn('updated_at', 'datetime')
                ->save();
    }

    public function down()
    {
        $this->dropTable('menus');
    }

}
