<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $date = \Carbon\Carbon::now();

        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = [
                'name' => 'user' . $i,
                'email' => 'user' . $i . '@mail.loc',
                'password' => 'password',
                'created_at' => $date,
                'updated_at' => $date
            ];
        }

        DB::table('users')->insert($users);
    }
}
