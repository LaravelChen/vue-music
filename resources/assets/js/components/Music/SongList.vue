<template>
    <div class="col-md-8 col-md-offset-2" style="padding-top:160px;padding-bottom:30px">
        <div class="text-center" v-if="isshow">
            <mu-circular-progress :size="60" :strokeWidth="5"/>
        </div>
        <mu-card v-if="!isshow">
            <mu-card-header :title="creator.nickname" :subTitle="creator.signature">
                <mu-avatar :src="creator.backgroundUrl" slot="avatar"/>
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
        </mu-card>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                songlist:[],
                creator:{},
                isshow:true,
            }
        },
        mounted(){
            axios.post('/songlist',{'id':this.$route.params.songlistId}).then((response)=>{
                 this.isshow=false;
                this.songlist=response.data.playlist.tracks;
                this.creator=response.data.playlist.creator;
            });
        },
        methods:{
            playsong(id){
                 this.$store.dispatch('playsong',{songid:id});
            }
        }
    }
</script>
