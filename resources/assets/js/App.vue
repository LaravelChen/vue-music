<template>
    <div>
        <headerbar></headerbar>
        <router-view></router-view>
        <musicplay></musicplay>
    </div>
</template>
<script>
    import headerbar from './components/Header/Header.vue'
    import musicplay from './components/Footer/MusicPlayer.vue'
    export default{
        components:{
            headerbar,musicplay
        }
    }

</script>
