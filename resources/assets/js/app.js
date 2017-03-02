require('./bootstrap');
import VueRouter from 'vue-router'
import MuseUI from 'muse-ui'
import 'muse-ui/dist/muse-ui.css'
import Vuex from 'vuex'

Vue.use(Vuex)
Vue.use(MuseUI)
Vue.use(VueRouter)

//导入本人所写的组件
import App from './App.vue'
import  LoveSong from './components/Music/LoveSong.vue'
import  FindSongList from './components/Music/FindSongList.vue'
import  SearchMusic from './components/Music/SearchMusic.vue'
import SongList from './components/Music/SongList.vue'
import Lyrics from './components/Music/Lyrics.vue'

//vuerouter路由
const router = new VueRouter({
    routes: [
        {path: '/', component: FindSongList},
        {path: '/findlovesong', component: LoveSong},
        {path: '/searchmusic', component: SearchMusic},
        {path: '/songlist/:songlistId', name: 'songlist', component: SongList},
        {path: '/lyrics/:songid', name: 'lyrics', component: Lyrics},
    ]
})

//vuex的单例模式
const store = new Vuex.Store({
    state: {
        songid: 0, //播放歌曲的id
        audio:document.createElement('audio'),
    },
    mutations: {
        //设置播放歌曲的id
        setsongid(state, payload){
            state.songid = payload.songid;
        }
    },
    actions: {
        //调用mutations的函数
        playsong({commit}, payload){
            commit('setsongid', payload);
        },
    }
})


//初始化
const app = new Vue({
    el: '#app',
    template: '<App/>',
    components: {App},
    router,
    store,
});
