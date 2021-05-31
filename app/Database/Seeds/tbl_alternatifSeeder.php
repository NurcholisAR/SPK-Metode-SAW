<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

class tbl_alternatifSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 2000; $i++) {
            $gender = $faker->randomElement(['laki-laki', 'perempuan']);
            $agama = $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghuchu']);
            $nama = $faker->name($gender);
            $data = [
                'nama_alternatif' => $nama,
                'slug' => url_title($nama, '-', true) .  strtotime(date('Y-m-d H:i:s')),
                'jk_alternatif'  => $gender,
                'agama_alternatif' => $agama,
                'telp_alternatif' => $faker->PhoneNumber,
                'alamat_alternatif' => $faker->address
            ];
            $this->db->table('tbl_alternatif')->insert($data);
        }

        // Simple Queries
        // $this->db->query(
        //     "INSERT INTO users (username, email) VALUES(:username:, :email:)",
        //     $data
        // );

        // Using Query Builder
    }
}
