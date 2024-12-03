<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(oficinaSeeder::class);
        $this->call(codcontSeeder::class);
        $this->call(ResponsableSeeder::class);
        $this->call(ActualSeeder::class);
        $this->call(AuxiliarSeeder::class);
        $this->call(BackupSeeder::class);
        $this->call(BajaSeeder::class);
        $this->call(BajasSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(ConfigSeeder::class);
        $this->call(CtaparSeeder::class);
        $this->call(EntidadesSeeder::class);
        $this->call(EstentSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(MesSeeder::class);
        $this->call(objgastoSeeder::class);
        $this->call(organismoSeeder::class);
        //$this->call(orguserSeeder::class);
        $this->call(UnidadSeeder::class);
    }
}
