<template>
    <div style="position:fixed;width:100%;z-index: 1000;">
        <mu-appbar title="Enjoy Music">
            <mu-icon-button @click="gohome" icon='queue_music' slot="left"/>
            <mu-icon-button  href="https://github.com/LaravelChen/vue-music" slot="right">
                <i class="fa fa-github"></i>
            </mu-icon-button>
        </mu-appbar>
        <mu-paper>
            <mu-bottom-nav :value="bottomNav" @change="handleChange">
                <mu-bottom-nav-item value="findsonglist">
                    <div @click="findsonglist" class="mu-buttom-item-wrapper">
                        <div class="mu-ripple-wrapper"></div>
                        <i class="mu-bottom-item-icon mu-icon material-icons">update</i> <span
                            class="mu-bottom-item-text">热门歌单</span></div>
                </mu-bottom-nav-item>
                <mu-bottom-nav-item value="findlovesong">
                    <div @click="findlovesong" class="mu-buttom-item-wrapper">
                        <div class="mu-ripple-wrapper"></div>
                        <i class="mu-bottom-item-icon mu-icon material-icons">favorite</i> <span
                            class="mu-bottom-item-text">热门歌手单曲</span></div>
                </mu-bottom-nav-item>
                <mu-bottom-nav-item value="searchmusic">
                    <div @click="searchmusic" class="mu-buttom-item-wrapper">
                        <div class="mu-ripple-wrapper"></div>
                        <i class="mu-bottom-item-icon mu-icon material-icons">search</i> <span
                            class="mu-bottom-item-text">搜索歌曲</span></div>
                </mu-bottom-nav-item>
                <mu-bottom-nav-item value="showlyrics">
                    <div @click="showlyrics" class="mu-buttom-item-wrapper">
                        <div class="mu-ripple-wrapper"></div>
                        <i class="mu-bottom-item-icon mu-icon material-icons">visibility</i> <span
                            class="mu-bottom-item-text">显示歌词</span></div>
                </mu-bottom-nav-item>
            </mu-bottom-nav>
        </mu-paper>
    </div>
</template>
<style lang="less">
    .appbar-search-field {
        color: #FFF;
        margin-bottom: 0;
        &.focus-state {
            color: #FFF;
        }
        .mu-text-field-hint {
            color: fade(#FFF, 54%);
        }
        .mu-text-field-input {
            color: #FFF;
        }
        .mu-text-field-focus-line {
            background-color: #FFF;
        }
    }
</style>
<script>
export default {
  data () {
    return {
      bottomNav: 'findsonglist',
    }
  },
  methods: {
    handleChange (val) {
      this.bottomNav = val
    },
    findsonglist(){
        this.$router.push('/');
    },
    findlovesong(){
        this.$router.replace('/findlovesong');
    },
    searchmusic(){
         this.$router.push('/searchmusic');
    },
    showlyrics(){
        this.$router.push({name:'lyrics',params:{songid:this.$store.state.songid}});
    },
    gohome(){
        this.$router.push('/');
    },
  }
}

</script>

