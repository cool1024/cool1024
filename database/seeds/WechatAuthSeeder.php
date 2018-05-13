<?php

use Illuminate\Database\Seeder;
use App\Http\WechatAuth\Models\SmallRoutine;

class WechatAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Http\WechatAuth\Models\WechatUser::class, 50)->create();
        SmallRoutine::create([
            'store_id' => 1,
            'is_active' => 1,
            'config' => '{"appId":"wxdf65835c38ed456b","appSecret":"7e68fd7551f9fe873ebf4ee9a25adf5e"}'
        ]);
    }
}
