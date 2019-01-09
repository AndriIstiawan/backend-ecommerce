<?php

use Illuminate\Database\Seeder;

class UpdateMemberLevelName extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = DB::table('members')->get()->toArray();
        $member_update = array_map(function ($member){
            $level = (isset($member['level'])?$member['level']:[]);
            if(count($level) > 0){
                if(!isset($level[0]['name'])){
                    $level = DB::table('levels')->where('_id', $level[0]['_id'])->get();
                    DB::table('members')->where('_id', $member['_id'])->update(['level' => $level->toArray()]);
                }
            }else{
                $level = DB::table('levels')->orderBy('order', 'ASC')->limit(1)->get();
                DB::table('members')->where('_id', $member['_id'])->update(['level' => $level->toArray()]);
            }
        },$members);
    }
}
