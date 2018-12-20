<?php

use Phinx\Migration\AbstractMigration;

class AddMealRecipeLinkMeal extends AbstractMigration
{

    public function up()
    {
        $refTable = $this->table('meals');
        $refTable->addColumn('meal_recipe_link', 'string', [
            'null' => true,
            'after' => 'name'
        ])->save();
    }

    public function down()
    {
        $table = $this->table('meals');
        $table->removeColumn('meal_recipe_link')
                ->save();
    }

}
