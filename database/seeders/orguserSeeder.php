<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class orguserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader(public_path('vsiaf/dbfs/ORGUSER.DBF'),['encoding' => 'cp1252']);
        while ($record = $table->nextRecord()) {
            DB::table('orguser')->insert([
                'ido' => $record->get('id'),
                'type' => $record->get('type'),
                'name' => $record->get('name'),
                'readonly' => $record->get('readonly'),
                'ckval' => $record->get('ckval'),
                'data' => $record->get('data'),
                'updated' => $record->get('updated'),
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
