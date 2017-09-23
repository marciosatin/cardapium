<?php

use Phinx\Migration\AbstractMigration;

class CreateMealsTable extends AbstractMigration
{

    public function up()
    {
        $this->table('meals')
                ->addColumn('name', 'string')
                ->addColumn('created_at', 'datetime')
                ->addColumn('updated_at', 'datetime')
                ->save();
    }

    public function down()
    {
        $this->dropTable('meals');
    }

}
