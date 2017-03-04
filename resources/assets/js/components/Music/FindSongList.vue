<template>
    <div class="col-md-8 col-md-offset-2" style="padding-top:160px;padding-bottom:30px">
        <div class="text-center" v-if="isshow">
            <mu-circular-progress :size="60" :strokeWidth="5"/>
        </div>
        <div class="row" v-for="lists in songlist">
            <div v-for="list in lists" @click="handleclick(list.id)" class="col-md-3">
                <mu-card>
                    <mu-card-media :title="list.creator.nickname">
                        <img :src="list.coverImgUrl"/>
                    </mu-card-media>
                    <mu-card-text>
                        {{list.name}}
                    </mu-card-text>
                </mu-card>
            </div>
        </div>
        <div class="col-md-6 col-md-offset-3" v-if="!isshow" style="padding:20px 0 70px 0">
            <mu-pagination :defaultPageSize="20" :total="total" :current="current" @pageChange="handleClick">
            </mu-pagination>
        </div>
    </div>
</template>
<style>
.row {
    display:block;
}
.mu-card-text{
    padding:10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.mu-card{
    margin-bottom:20px;
}
.mu-card:hover{
    cursor:pointer;
}
@media screen and (min-width: 991px){
    .mu-card-media-title {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        padding:0;
        background-color: rgba(0,0,0,.54);
    }
}
@media screen and (min-width: 768px){
    .mu-card-media-title .mu-card-title {
        font-size: 10px;
        color: hsla(0,0%,100%,.87);
        line-height: 36px;
        text-align: center;
    }
}

@media screen and (max-width: 768px){
  .col-md-6{
    position:static;
  }
}



</style>
<script>
import chunk from '../../publicjs/chunk'
export default {
    data(){
        return {
            songlist:[],
            total: 198,
            current: 1,
            isshow:true,
        }
    },
    mounted(){
         axios.post('/hotlist',{'offset':0}).then((response)=>{
            this.total=response.data.result.playlistCount;
            this.songlist=chunk(response.data.result.playlists,4);
            this.isshow=false;
        });
    },
    methods:{
        handleclick(id){
            this.$router.push({name:'songlist',params:{songlistId:id}});
        },
        handleClick (newIndex) {
            axios.post('/hotlist',{'offset':newIndex}).then((response)=>{
                  this.songlist=chunk(response.data.result.playlists,4);
                  document.body.scrollTop = 0;
            });
         }
    }
}

</script>
