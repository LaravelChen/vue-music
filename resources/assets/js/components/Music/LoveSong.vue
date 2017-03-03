<template>
    <div class="col-md-8 col-md-offset-2" style="padding-top:160px;padding-bottom:30px">
        <mu-card>
            <mu-card-header title="薛之谦" subTitle="我的愿望是世界和平">
                <mu-avatar src="http://p3.music.126.net/qpvBqYIqkRhO9Ry2qOCdJQ==/2942293117852634.jpg" slot="avatar"/>
            </mu-card-header>
             <mytable :songlist="songlist"></mytable>
            <div class="col-md-6 col-md-offset-3" v-if="!isshow" style="padding:20px 0 70px 0">
                <mu-pagination :defaultPageSize="20" :total="total" :current="current" @pageChange="handleClick">
                </mu-pagination>
            </div>
        </mu-card>
    </div>
</template>
<style>
a{
    color:#212121;
}
a:hover{
    color:#03a9f4;
}
.mu-avatar {
    height: 55px;
    width: 55px;
}

.mu-card-title{
    padding-bottom:10px;
}
</style>
<script>
import mytable from '../Public/Table.vue'
    export default{
       components:{
            mytable,
        },
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
            handleClick (newIndex) {
                 axios.post('/lovesong',{'content':this.value,'offset':newIndex}).then((response)=>{
                    this.songlist=response.data.result.songs;
                    document.body.scrollTop = 0;
                });
            },
        },
    }

</script>
