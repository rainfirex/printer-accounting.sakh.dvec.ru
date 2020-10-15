<?php

use Illuminate\Database\Seeder;

class ActionEvent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('action_events')->insert([
            [
                'event' => 'all',
                'title' => 'Все записи'
            ],
            [
                'event' => 'add',
                'title' => 'Добавленные записи',
            ],
            [
                'event' => 'edit',
                'title' => 'Редактированные записи',
            ],
            [
                'event' => 'remove',
                'title' => 'Удаленные записи',
            ]
        ]);
    }
}
