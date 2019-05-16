<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$admin = User::create([
			'email' => 'admingis@pdam.com',
			'name' => 'Admin GIS',
			'password' => bcrypt('12345678')
		]);

        $admin = User::create([
            'email' => 'admin@gispdam.go.id',
            'name' => 'Admin GIS',
            'password' => bcrypt('12345678')
        ]);
    }
}
