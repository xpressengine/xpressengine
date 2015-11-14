<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call(UserTableSeeder::class);

        DB::table('config')
            ->insert(
                [
                    ['name' => 'menu', 'vars' => '[]'],
                    ['name' => 'page', 'vars' => '[]'],
                    ['name' => 'comments', 'vars' => '[]'],
                    ['name' => 'manage', 'vars' => '[]'],
                    ['name' => 'member.common', 'vars' => '{"useMailCertify":false,"passwordCost":10,"webmasterName":"webmaster","webmasterEmail":"webmaster@domain.com","secureLevel":"low","joinable":true}'],
                    ['name' => 'member.join', 'vars' => '{"agreement":0,"useCaptcha":false,"fields":[{"fieldName":"nickname","label":"\\ub2c9\\ub124\\uc784","type":"Category","required":true,"used":true},{"fieldName":"photo","label":"\\ud504\\ub85c\\ud544\\uc0ac\\uc9c4","type":"MultiUploader","required":false,"used":true}]}']
                ]
            );

        Model::reguard();
	}

}
