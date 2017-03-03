<template>
    <div class="col-md-8 col-md-offset-2" style="padding-top:160px;padding-bottom:30px">
        <h1 class="text-center" style="font-weight:700;font-size:35px; font-family: 'Noto Serif',serif;margin:0">Enjoy
            music
            from there!</h1>
        <form method="POST" style="text-align:center" @submit.prevent="searchmusic" accept-charset="UTF-8" slot="right">
            <mu-text-field label="找寻你最爱的歌曲" v-model="value" labelFloat/>
            <br/>
        </form>
        <div class="text-center" v-if="isshow" style="margin-top:30px">
            <mu-circular-progress :size="60" :strokeWidth="5"/>
        </div>
        <div v-if="songlist.length">
            <p>共有<strong style="color:#616161">{{songcount}}</strong>个结果</p>
            <mytable :songlist="songlist"></mytable>
            <div class="col-md-6 col-md-offset-3" style="padding:20px 0 70px 0">
                <mu-pagination :defaultPageSize="20" :total="total" :current="current" @pageChange="handleClick">
                </mu-pagination>
            </div>
        </div>
    </div>
</template>
<style>
    .mu-list{
       background-color:#f5f5f5;
    }
    p {
        margin: 0 0 11px;
        font-size: 16px;
        color: #999;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
        table-layout:fixed;
    }

    .table >tbody >tr:hover{
        cursor:pointer;
        background-color:#eeeeee;
    }

     .table > thead > tr > th{
        border-bottom:none;
        padding-left:20px
     }

    .table > tbody > tr > td {
        padding: 13px 5px 13px 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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
            value:'',
            songlist:[],
            songcount:'',
            total: '',
            current: 1,
            isshow:false,
          }
        },
        methods:{
         searchmusic(){
                this.isshow=true;
                axios.post('/findallsong',{'content':this.value,'offset':0}).then((response)=>{
                    this.isshow=false;
                    this.songlist=response.data.result.songs;
                    this.songcount=response.data.result.songCount;
                    this.total=this.songcount;
                });
           },
           handleClick (newIndex) {
                 axios.post('/findallsong',{'content':this.value,'offset':newIndex}).then((response)=>{
                    this.songlist=response.data.result.songs;
                    document.body.scrollTop = 0;
                });
            }
        },
    }
</script>
