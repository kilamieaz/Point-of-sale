<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert(array(
            [
                'company_name' => 'Pos', 
                'address' => 'Jl. in aja dulu, Jambi, Kota Jambi',
                'telepon' => '08228100519',
                'logo' => 'logo.png',
                'member_card' => 'card.png',
                'member_discount' => '10',
                'note_type' => '0'
            ]
        ));
    }
}