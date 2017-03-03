<template>
    <div class="col-md-8 col-md-offset-2" style="padding-top:160px;padding-bottom:30px">
        <div class="text-center" v-if="isshow">
            <mu-circular-progress :size="60" :strokeWidth="5"/>
        </div>
        <mu-card v-if="!isshow">
            <mu-card-header :title="creator.nickname" :subTitle="creator.signature">
                <mu-avatar :src="creator.backgroundUrl" slot="avatar"/>
            </mu-card-header>
            <mytable :songlist="songlist"></mytable>
        </mu-card>
    </div>
</template>
<script>
import mytable from '../Public/Table.vue'
    export default{
        components:{
            mytable,
        },
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
    }
</script>
