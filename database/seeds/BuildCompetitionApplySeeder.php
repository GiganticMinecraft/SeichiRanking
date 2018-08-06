<?php

use Illuminate\Database\Seeder;

class BuildCompetitionApplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('build_competition_apply')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array();

        $data = [
            [
                'build_competition_group' => 4,
                'mcid'                    => '19moon#5484',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => '19moon',
                'theme_division_id'       => 1,
                'apply_comment'           => '何気に和風作るの初めてだったりする。がんばルマン(｀・ω・´)',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-4-10',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => '19moon',
                'uuid'                    => '',
                'contact_means'           => 'Discord',
                'title'                   => '',
                'contact_id'              => '19moon#5484',
                'theme_division_id'       => 4,
                'apply_comment'           => '何気に和風作るの初めてだったりする。がんばルマン(｀・ω・´)',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-3-1',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => '19moon',
                'uuid'                    => '',
                'contact_means'           => 'Discord',
                'title'                   => '',
                'contact_id'              => '19moon#5484',
                'theme_division_id'       => 2,
                'apply_comment'           => '何気に和風作るの初めてだったりする。がんばルマン(｀・ω・´)',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-9-3',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => '19moon',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => '19moon#5484',
                'theme_division_id'       => 3,
                'apply_comment'           => '何気に和風作るの初めてだったりする。がんばルマン(｀・ω・´)',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-9-11',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'AFK_Queen',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'AFK_QUEEN#0520',
                'theme_division_id'       => 4,
                'apply_comment'           => 'お忙しい中よろしくお願いします。',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-1-7',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'Ais_Wallenstein3',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'あいずさん#2770',
                'theme_division_id'       => 4,
                'apply_comment'           => '二つ頑張ります！！るくれさんかわいい！',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-1-4',
                'remarks'                 => '',
            ],            [
                'build_competition_group' => 4,
                'mcid'                    => 'Ais_Wallenstein3',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'あいずさん#2770',
                'theme_division_id'       => 3,
                'apply_comment'           => '二つ頑張ります！！るくれさんかわいい！',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-9-10',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'arakoo185',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'あらこー( ´Д｀)=3#8768',
                'theme_division_id'       => 1,
                'apply_comment'           => 'こんにちは！！',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-2-7',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'arakoo185',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'あらこー( ´Д｀)=3#8768',
                'theme_division_id'       => 3,
                'apply_comment'           => 'こんにちは！！',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-7-2',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'aya_Cyber_SC',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'Cyber.T.C#7360',
                'theme_division_id'       => 3,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-9-7',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'GANBAN1024',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => '一丸二四がんばん＃５２０１',
                'theme_division_id'       => 3,
                'apply_comment'           => '現在s2にて城を建築中ですが、そこで培った技術とかも活かしながら頑張っていきたいです。',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-9-8',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'kamikami46',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'kamikami46#1256',
                'theme_division_id'       => 1,
                'apply_comment'           => 'みんなで建築するの楽しいよね',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-1-1',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'kamikami46',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'kamikami46#1256',
                'theme_division_id'       => 4,
                'apply_comment'           => 'みんなで建築するの楽しいよね',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-6-8',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'kamikami46',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'kamikami46#1256',
                'theme_division_id'       => 2,
                'apply_comment'           => 'みんなで建築するの楽しいよね',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-6-5',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'kamikami46',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'kamikami46#1256',
                'theme_division_id'       => 3,
                'apply_comment'           => 'みんなで建築するの楽しいよね',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-7-5',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'kaworuko',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'kaworuko#6955',
                'theme_division_id'       => 4,
                'apply_comment'           => 'イベント開催頑張ってください！！',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-8-8',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'kaworuko',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'kaworuko#6955',
                'theme_division_id'       => 2,
                'apply_comment'           => 'イベント開催頑張ってください！！',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-8-5',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'KNsX_ZepT256',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'irukakunファン倶楽部 部員-KaNoShowwX_256#9699',
                'theme_division_id'       => 3,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-9-5',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'kurikintooooooon',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'kurikichi256#3929',
                'theme_division_id'       => 1,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-3-9',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'kurikintooooooon',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'kurikichi256#3929',
                'theme_division_id'       => 2,
                'apply_comment'           => '3回目の応募',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-9-1',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'kurikintooooooon',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'kurikichi256#3929',
                'theme_division_id'       => 3,
                'apply_comment'           => '二回目の応募',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-9-4',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'kurikintooooooon',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'kurikichi256#3929',
                'theme_division_id'       => 4,
                'apply_comment'           => '3回目の応募',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-1-1',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'lava650',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Twitter',
                'contact_id'              => '@yougannnnn',
                'theme_division_id'       => 4,
                'apply_comment'           => '初参加です。よろしくおねがいします。',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-1-10',
                'remarks'                 => '',
            ],

            [
                'build_competition_group' => 4,
                'mcid'                    => 'lorenzo_SKY',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'lorenzo_SKY#5807',
                'theme_division_id'       => 1,
                'apply_comment'           => '友人と一緒に参加させて頂きます。',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-2-9',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'mimizu_yellow',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'にとろ#2591',
                'theme_division_id'       => 2,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-7-2',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'muse_sekken',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Twitter',
                'contact_id'              => '@muse_syu',
                'theme_division_id'       => 3,
                'apply_comment'           => '大したものは作れませんが、一生懸命がんばります！',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-9-2',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'ranzamu',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => '#7064',
                'theme_division_id'       => 1,
                'apply_comment'           => 'どれか作りたいと思っています　宜しくお願いします　2周年おめでとうございます　これからも運営の方頑張ってください!!',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-5-10',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'ranzamu',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => '#7064',
                'theme_division_id'       => 4,
                'apply_comment'           => 'どれか作りたいと思っています　宜しくお願いします　2周年おめでとうございます　これからも運営の方頑張ってください!!',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-3-2',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'ranzamu',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => '#7064',
                'theme_division_id'       => 2,
                'apply_comment'           => 'どれか作りたいと思っています　宜しくお願いします　2周年おめでとうございます　これからも運営の方頑張ってください!!',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-9-4',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'ranzamu',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => '#7064',
                'theme_division_id'       => 3,
                'apply_comment'           => 'どれか作りたいと思っています　宜しくお願いします　2周年おめでとうございます　これからも運営の方頑張ってください!!',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-7-1',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'riku0745',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'riku0745#8458',
                'theme_division_id'       => 1,
                'apply_comment'           => '整地鯖にも神社の一つや二つあってもいいよねっ！',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-1-10',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'rin256',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'rin#7984',
                'theme_division_id'       => 1,
                'apply_comment'           => 'よろしくお願いします(*- -)(*_ _)ペコリ 建築頑張ります',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-4-9',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'rukure2017',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'rukure2017#3251',
                'theme_division_id'       => 4,
                'apply_comment'           => 'やりますかぁ',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-9-8',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'rukure2017',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'rukure2017#3251',
                'theme_division_id'       => 2,
                'apply_comment'           => 'やりますかぁ',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-8-5',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'rust_mons',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Twitter',
                'contact_id'              => 'rust_mons@magewindviola',
                'theme_division_id'       => 2,
                'apply_comment'           => 'セボン玉な家でも作ろうかと',
                'img_path'                => null,
                'partition_operator'      => '',
                'partition_no'            => 'f-7-4',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 's1no',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'Sino#9482',
                'theme_division_id'       => 1,
                'apply_comment'           => '1回目',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-5-9',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 's1no',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'Sino#9482',
                'theme_division_id'       => 2,
                'apply_comment'           => '2回目',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-7-1',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 's1no',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'Sino#9482',
                'theme_division_id'       => 3,
                'apply_comment'           => '3回目',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-9-6',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 's1no',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'Sino#9482',
                'theme_division_id'       => 4,
                'apply_comment'           => '4回目',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-1-9',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'shirotubu',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'しろつぶ#4655',
                'theme_division_id'       => 1,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-2-1',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'shirotubu',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'しろつぶ#4655',
                'theme_division_id'       => 2,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-9-5',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'shirotubu',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'しろつぶ#4655',
                'theme_division_id'       => 3,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-5-5',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'shirotubu',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'しろつぶ#4655',
                'theme_division_id'       => 4,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-7-8',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'shobon_',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'shobon #3942',
                'theme_division_id'       => 1,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-1-7',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'shobon_',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'shobon #3942',
                'theme_division_id'       => 4,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-1-6',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'sobaaa_Lv20',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'sobaaa#6618',
                'theme_division_id'       => 1,
                'apply_comment'           => '二回目の応募です。',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-2-10',
                'remarks'                 => 'sobaaa→sobaaa_Lv20へＭＣＩＤ変更あり',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'sobaaa_Lv20',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'sobaaa#6618',
                'theme_division_id'       => 2,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-9-2',
                'remarks'                 => 'sobaaa→sobaaa_Lv20へＭＣＩＤ変更あり',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'sobaaa_Lv20',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'sobaaa#6618',
                'theme_division_id'       => 3,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-9-1',
                'remarks'                 => 'sobaaa→sobaaa_Lv20へＭＣＩＤ変更あり',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'sobaaa_Lv20',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'sobaaa#6618',
                'theme_division_id'       => 4,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-1-5',
                'remarks'                 => 'sobaaa→sobaaa_Lv20へＭＣＩＤ変更あり',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'SpecialBoyWaka',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'SpecialBoyWaka#5155',
                'theme_division_id'       => 2,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'f-7-3',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'Syuwa_san',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'Syuwa_san #5528',
                'theme_division_id'       => 1,
                'apply_comment'           => '宜しくお願いします',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-1-9',
                'remarks'                 => 'MCID変更あり。Syuwa_n →Syuwa_san',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'TAMA_EXP',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => '多摩急行#6545',
                'theme_division_id'       => 3,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-9-3',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'TAMA_EXP',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => '多摩急行#6545',
                'theme_division_id'       => 4,
                'apply_comment'           => '2回目の送信',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-1-8',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'tomakura_aren',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'tomakura_aren(スキン変更)#2060',
                'theme_division_id'       => 1,
                'apply_comment'           => 'コメントですか...頑張ります敵な感じですかね?',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'w-3-7',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'tomakura_aren',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'tomakura_aren(スキン変更)#2060',
                'theme_division_id'       => 3,
                'apply_comment'           => 'コメントですか...頑張ります敵な感じですかね?',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'y-7-3',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'tomakura_aren',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'tomakura_aren(スキン変更)#2060',
                'theme_division_id'       => 4,
                'apply_comment'           => 'コメントですか...頑張ります敵な感じですかね?',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm-1-6',
                'remarks'                 => '',
            ],
            [
                'build_competition_group' => 4,
                'mcid'                    => 'tsutitire',
                'uuid'                    => '',
                'title'                   => '',
                'contact_means'           => 'Discord',
                'contact_id'              => 'Tsutitire#3271',
                'theme_division_id'       => 4,
                'apply_comment'           => '',
                'img_path'                => null,
                'partition_operator'      => 'rukure',
                'partition_no'            => 'm1-11',
                'remarks'                 => '',
            ],
        ];

        foreach ($data as $datum) {
            \DB::table('build_competition_apply')->insert([
                'build_competition_group' => $datum['build_competition_group'],
                'mcid'                    => $datum['mcid'],
                'title'                   => $datum['title'],
                'uuid'                    => $datum['uuid'],
                'contact_means'           => $datum['contact_means'],
                'contact_id'              => $datum['contact_id'],
                'theme_division_id'       => $datum['theme_division_id'],
                'apply_comment'           => $datum['apply_comment'],
                'img_path'                => $datum['img_path'],
                'partition_operator'      => $datum['partition_operator'],
                'partition_no'            => $datum['partition_no'],
                'remarks'                 => $datum['remarks'],
            ]);
        }
    }
}
