<template>
    <div class="col-md-8 col-md-offset-2" style="padding-top:160px;padding-bottom:30px">
        <mu-card>
            <mu-card-header title="薛之谦" subTitle="我的愿望是世界和平">
                <mu-avatar src="http://p3.music.126.net/qpvBqYIqkRhO9Ry2qOCdJQ==/2942293117852634.jpg" slot="avatar"/>
            </mu-card-header>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th style="width:70px" class="jin">#</th>
                        <th>歌曲名</th>
                        <th>歌手</th>
                        <th>专辑</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="list in songlist" @click="playsong(list.id)">
                        <td><i class="fa fa-play"></i></td>
                        <td>{{list.name}}</td>
                        <td>
                            <span v-if="list.ar.length >= 1">{{list.ar[0].name}}</span>
                            <span v-if="list.ar.length >= 2">/ {{list.ar[1].name}}</span>
                            <span v-if="list.ar.length >= 3">/ {{list.ar[2].name}}</span>
                            <span v-if="list.ar.length >= 4">/ {{list.ar[3].name}}</span>
                        </td>
                        <td>{{ '《' +list.al.name+ '》'}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 col-md-offset-3" v-if="!isshow" style="padding:20px 0 70px 0">
                <mu-pagination :defaultPageSize="20" :total="total" :current="current" @pageChange="handleClick">
                </mu-pagination>
            </div>
        </mu-card>
    </div>
</template>
<style>
.mu-avatar {
    height: 55px;
    width: 55px;
}

.mu-card-title{
    padding-bottom:10px;
}
</style>
<script>
    export default{
        data(){
            return {
                songlist:[],
                total:800,
                current:1,
                isshow:true,
            }
        },
        mounted(){
            axios.post('/lovesong',{'offset':0}).then((response)=>{
                this.isshow=false;
                this.songlist=response.data.result.songs;
            });
        },
        methods:{
            playsong(id){
                 this.$store.dispatch('playsong',{songid:id});
            },
            handleClick (newIndex) {
                 axios.post('/lovesong',{'content':this.value,'offset':newIndex}).then((response)=>{
                    this.songlist=response.data.result.songs;
                    document.body.scrollTop = 0;
                });
            }
        },
    }

</script>
