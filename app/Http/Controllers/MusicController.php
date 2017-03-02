<?php

namespace App\Http\Controllers;

use App\Repository\MusicAPI;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public $music;

    /**
     * MusicController constructor.
     * @param $music
     */
    public function __construct(MusicAPI $music)
    {
        $this->music = $music;
    }

    /**
     * 设置分页的偏移量
     * @param $offset
     * @return Request|int
     */
    public function offset($offset)
    {
        if ($offset) {
            $result = (request('offset') - 1) * 20;
        } else {
            $result = 0;
        }
        return $result;
    }

    /**
     * 搜索所有歌曲的列表
     * @return \App\Repository\JSON
     */
    public function findallsong()
    {
        $result = $this->music->search(request('content'), 20, $this->offset(request('offset')));
        return $result;
    }

    /**
     * 播放单独一首歌曲
     * @return \App\Repository\JSON
     */
    public function playsong()
    {
        $result1 = $this->music->mp3url(request('songid'));
        $result2 = $this->music->search(request('songid'));
        return response()->json([
            'songinfo' => $result2,
            'songurl' => $result1,
        ]);
    }

    /**
     * @return \App\Repository\JSON
     */
    public function hotlist()
    {
        return $this->music->search('全部歌单', 20, $this->offset(request('offset')), 1000);
    }

    /**
     * 热门歌手单曲的列表
     * @return \App\Repository\JSON
     */
    public function lovesong()
    {
        return $this->music->search('薛之谦', 20, $this->offset(request('offset')));
    }

    /**
     * 显示歌单的所有歌曲
     * @return \App\Repository\JSON
     */
    public function songlist()
    {
        return $this->music->playlist(request('id'));
    }

    /**
     * 获取歌词
     * @return \App\Repository\JSON
     */
    public function getlyrics()
    {
        return $this->music->lyric(request('songid'));
//        $lyrics = "[00:00.00] 作曲 : 薛之谦\n[00:01.00] 作词 : 薛之谦\n[00:10.160]制作 : 薛之谦\n[00:11.160]配唱制作人 : 赵英俊\n[00:12.160]编曲 : 周以力\n[00:13.160]吉他 : 张凇\n[00:14.160]鼓 : 陈志昆\n[00:15.160]大提琴 : 吴牧\n[00:16.160]录音/混音 : 鲍锐\n[00:17.160]录音助理 : 王晓海\n[00:18.160]和你有关观后无感\n[00:25.940]若是真的敢问作者何来罪恶\n[00:33.520]劝人离散有多为难\n[00:41.340]若美丽的故事来得太晚\n[00:47.110]\n[00:49.090]所以到哪里都像快乐被燃起\n[00:56.580]就好像你曾在我隔壁的班级\n[01:04.320]人们把难言的爱都埋入土壤里\n[01:11.950]袖手旁观着别人尽力撇清自己\n[01:17.560]\n[01:21.030]我听见了你的声音\n[01:28.960]也藏着颗不敢见的心\n[01:36.760]我躲进挑剔的人群\n[01:44.320]夜一深就找那颗星星\n[01:49.670]\n[02:21.480]我以为旅人将我热情都燃尽\n[02:29.270]你却像一张情书感觉很初级\n[02:36.930]人们把晚来的爱都锁在密码里\n[02:44.660]字正腔圆的演说撇清所有关系\n[02:51.680]\n[02:55.350]我听见了你的声音\n[03:03.500]也藏着颗不敢见的心\n[03:11.300]我躲进挑剔的人群\n[03:19.020]夜一深就找那颗星星\n[03:26.910]你听不到我的声音\n[03:34.680]怕脱口而出是你姓名\n[03:42.480]像确定我要遇见你\n[03:50.350]就像曾经交换过眼睛\n[03:56.820]\n[03:58.220]我好像在哪见过你\n[04:05.740]我好像在哪见过你\n[04:13.680]我好像在哪见过你\n[04:21.290]我在劝我该忘了你\n[04:32.900]\n";
//        $arr= explode("\n",$lyrics);
//        $pattern='/\[(\d{2}):(\d{2})\.(\d{2,3})]/';
//        return preg_match($pattern,$arr[0]);
    }
}
