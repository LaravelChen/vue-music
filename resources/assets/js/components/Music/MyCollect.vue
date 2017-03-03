<template>
    <div class="col-md-8 col-md-offset-2" style="padding-top:160px;padding-bottom:30px">
        <mu-card>
            <mu-card-header title="收藏列表" subTitle="选择你喜欢的歌曲点击收藏">
                <mu-avatar src="http://p1.music.126.net/A0YVJKVw8b6TcrNZk3YZ0w==/1364493973497799.jpg" slot="avatar"/>
            </mu-card-header>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th style="width:70px" class="jin">#</th>
                        <th>歌曲名</th>
                        <th>歌手</th>
                        <th style="padding-left:32px">专辑</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="list in songlist" @click="playsong(list.songid)">
                        <td><i class="fa fa-play-circle-o"></i></td>
                        <td>{{list.songtitle}}</td>
                        <td>
                            <span>{{list.songer}}</span>
                        </td>
                        <td>{{'《'+list.album+'》'}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </mu-card>
    </div>
</template>
<script>
    export default{
        data(){
            return {
            //初始化收藏列表
               songlist:this.$store.state.songlist,
            }
        },
        methods:{
            playsong(id){
                this.$store.dispatch('playsong',{songid:id});
            },
        }
    }
</script>
