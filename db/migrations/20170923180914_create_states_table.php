<?php

use Phinx\Migration\AbstractMigration;

class CreateStatesTable extends AbstractMigration
{

    public function up()
    {
        $this->table('states')
                ->addColumn('name', 'string')
                ->addColumn('created_at', 'datetime')
                ->addColumn('updated_at', 'datetime')
                ->save();
    }

    public function down()
    {
        $this->dropTable('states');
    }

}
