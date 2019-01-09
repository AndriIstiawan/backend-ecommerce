<?php

use Illuminate\Database\Seeder;

use App\Saldo;
use App\Member;
class SaldoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Saldo::truncate();
        $member = Member::get();
        foreach ($member as $value) {
            $saldo = Saldo::create([
                'member_id' => $value->id,
                'status' => 'waiting', // approved, reject, waiting
                'description' => 'Top up',
                'nominal' => 10000,
            ]);
        }
    }
}
