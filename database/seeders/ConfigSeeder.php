<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/config.dbf'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('config')->insert([
                'entidad' => $record->get('entidad'),
                'descent' => $record->get('descent'),
                'unidad' => $record->get('unidad'), 
                'descuni' => $record->get('descuni'), 
                'usuario' => $record->get('usuario'),
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
