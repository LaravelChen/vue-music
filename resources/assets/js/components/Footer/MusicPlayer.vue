<template>
    <transition enter-active-class="animated fadeInUp">
        <div class="player-foot" v-if="isshow">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="row">
                    <div class="fontstyle">
                        <a><i class="fa fa-step-backward"></i></a>
                        <a @click="play">
                            <i style="width:20px" v-if="!isplay" class="fa fa-play"></i>
                            <i style="width:20px" v-if="isplay" class="fa fa-pause"></i>
                        </a>
                        <a><i class="fa fa-step-forward"></i></a>
                    </div>
                    <div class="media col-md-6">
                        <div @click="showlyrics" class="media-left">
                            <img :src="picurl" width="40px"
                                 height="40px">
                        </div>
                        <div class="media-body">
                            <p style="margin-bottom:0;color:#757575">{{songtitle}} ~ {{songer}}</p>
                            <mu-slider @change="ChangeProgress" v-model="progress" class="demo-slider"/>
                        </div>
                    </div>
                    <div class="hidden-xl hidden-sm" style="float:left;padding-top:40px">
                        <span>{{showCurrentTime}}/{{showDurationTime}}</span>
                    </div>
                    <div class="hidden-xl hidden-sm" style="float:left;padding-top:40px;margin-left:40px;width:13px">
                        <i class="fa fa-volume-up" v-if="!muted" aria-hidden="true" style="color:#757575"></i>
                        <i class="fa fa-volume-off" v-if="muted" aria-hidden="true" style="color:#757575"></i>
                    </div>
                    <div class="hidden-xl hidden-sm" style="float:left;padding-top:38px;width:80px;margin-left:10px">
                        <mu-slider @change="SetVolume" v-model="volume" class="demo-slider"/>
                    </div>
                    <div class="hidden-xl hidden-sm" style="float:left;padding-top:40px;margin-left:30px">
                        <i class="fa fa-repeat" aria-hidden="true" style="color:#757575"></i>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<style>
    .mu-slider:hover{
        cursor:pointer;
    }
    a:visited{
        text-decoration:none;
    }
    a:hover{
        text-decoration:none;
    }
    .player-foot{
        position:fixed;
        height:70px;
        background-color:#fff;
        bottom:0;
        width:100%;
        box-shadow: 0 -1px 5px 0px #e0e0e0;
    }
    .media, .media-body{
        overflow:inherit;
        padding:0 10px;
    }
    .fontstyle{
        float:left;
        font-size:25px;
        display:block;
        padding:20px 10px
    }
    .fontstyle a{
        padding:0 3px;
    }
    i:hover{
        cursor:pointer;
    }
    img:hover{
         cursor:pointer;
    }


</style>
<script>
    export default{
        data(){
            return {
                isshow:false,
                progress:0,//播放进度的初始化
                volume:100,//音量的初始化
               // $store.state.audio:document.createElement('$store.state.audio'), //获取audio的对象
                isplay:false,//是否播放以显示按钮
                showCurrentTime:'0:00',//当前歌曲时间
                showDurationTime:'0:00',//歌曲总时间
                muted:false,//是否静音
                songid:0,//歌曲id
                songtitle:'我好像在哪见过你',//歌曲名字
                songer:'薛之谦',//歌手名
                picurl:'http://p1.music.126.net/XSbvzcNE5zYFwCEDUgllTQ==/3440371886310532.jpg',//歌曲图片地址
            }
        },
        //初始化一下
        mounted(){
             setInterval(this.getsongid,500);//判断是否选择歌曲
             //this.$store.state.audio.addEventListener("ended",this.autoNextPlay);//监听是否结束
             this.autoplay();//循环播放
        },
        //监听是否选择歌曲
        watch:{
            songid(){
                axios.post('/playsong',{songid:this.songid}).then((response)=>{
                    var songinfo=JSON.parse(response.data.songinfo);//将json字符串转化为json对象
                    var result=songinfo.result.songs[0];//获取歌曲信息
                    var singlesong=JSON.parse(response.data.songurl);//将json字符串转化为json对象
                    this.songtitle=result.name;//获取歌曲名字
                    this.songer=result.ar[0].name;//获取歌手名字
                    this.picurl=result.al.picUrl;//获取歌曲图片
                    this.$store.state.audio.src=singlesong.data[0].url;//获取歌曲地址
                    this.$store.state.audio.play();//开始播放
                    this.isplay=true;//设置播放标志位true
                    setInterval(this.SetProgress,500);//启动进度条
                    this.isshow=true;
                });
            },
        },
        //方法
        methods:{
        //获取歌曲id利用vuex
            getsongid(){
                this.songid=this.$store.state.songid;
            },
        //播放歌曲
            play(){
                if(this.$store.state.audio.paused){
                    this.$store.state.audio.play();
                    this.isplay=true;
                }else{
                    this.$store.state.audio.pause();
                    this.isplay=false;
                }
            },
            //设置播放进度条
            SetProgress(){
                var MM,SS,
                    currentTime=this.$store.state.audio.currentTime, //获取当前的歌曲的时间
                    totalTime=this.$store.state.audio.duration;//获取当前的歌曲的总时间
                MM=parseInt(currentTime/60);
                SS=parseInt(currentTime%60);
                this.showCurrentTime=MM+':'+(SS<10?'0'+SS:SS); //显示进度时间
                MM=parseInt(totalTime/60);
                SS=parseInt(totalTime%60);
                this.showDurationTime=MM+':'+(SS<10?'0'+SS:SS);
                this.progress=currentTime/totalTime*100;
            },
            //改变播放进度
            ChangeProgress(val){
                this.$store.state.audio.currentTime=val/100*this.$store.state.audio.duration;
            },
            //调节音量
            SetVolume(val){
                this.$store.state.audio.volume=val/100;
                if(this.$store.state.audio.volume==0){
                    this.muted=true;
                }else{
                    this.muted=false;
                }
            },
            //循环播放
            autoplay(){
                this.$store.state.audio.loop=true;
            },
            //显示歌词
            showlyrics(){
                this.$router.push({name:'lyrics',params:{songid:this.songid}});
            },
        }
    }

</script>
