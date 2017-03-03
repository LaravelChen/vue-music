<template>
    <div class="table-responsive">
        <mu-popup position="top" :overlay="false" popupClass="demo-popup-top" :open="collect">
            <span style="color:#03a9f4">已添加到播放列表中</span>
        </mu-popup>
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
            <tr @click="playsong(list.id,list.name,list.ar[0].name,list.al.name)" v-for="list in songlist">
                <td><a><i class="fa fa-play-circle-o"></i></a></td>
                <td>{{list.name}}</td>
                <td>
                    <span v-if="list.ar.length >= 1">{{list.ar[0].name}}</span>
                    <span v-if="list.ar.length >= 2">/ {{list.ar[1].name}}</span>
                    <span v-if="list.ar.length >= 3">/ {{list.ar[2].name}}</span>
                    <span v-if="list.ar.length >= 4">/ {{list.ar[3].name}}</span>
                </td>
                <td class="hidden-sm">{{ '《' +list.al.name+ '》'}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<style lang="css">
    .demo-popup-top {
        width: 100%;
        opacity: .8;
        height: 48px;
        line-height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 375px;
    }
</style>
<script>
    export default{
        props:['songlist'],
         data () {
            return {
              collect: false,
              cancollect:true,
            }
        },
        watch: {
            collect (val) {
                if (val) {
                    setTimeout(() => {
                      this.collect = false;
                      this.cancollect=true
                    }, 2000)
                  }
            },
          },
        methods:{
              //播放歌曲并且收藏在列表中
            playsong(songid,songtitle,songer,album){
                 this.$store.dispatch('playsong',{songid:songid});
                 var _this=this;
                 this.$store.state.songlist.find(function(val){
                     if(val.songid==songid){
                            _this.cancollect=false;
                     }
                 });
                 if(this.cancollect){
                       this.$store.state.songlist.push({
                              songtitle:songtitle,
                              songer:songer,
                              album:album,
                              songid:songid,
                       });
                       this.collect=true;
                };
            },
        }
    }

</script>
