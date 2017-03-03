<template>
    <div class="col-md-8 col-md-offset-2" style="padding-top:220px;padding-bottom:30px">
        <div  id="lyricWrapper" class="site-branding text-center">
            <div v-if="lyric.length != 0" id="lyricContainer">
                <p v-for="(lrc, index) in lyric" :id="'line-'+index">{{lrc[1]}}</p>
            </div>
        </div>
    </div>
</template>
<style>
#lyricWrapper {
    display: block;
    height: 440px;
    overflow: hidden;
    position: relative;
    top: -20px;
    color: #fff;
}
#lyricContainer {
    position: relative;
    top: 100px;
    width: 100%;
}
#lyricContainer .current-line {
    color: #03a9f4;
    font-size: 18px;
}
#lyricContainer p {
    margin: 1.1em auto;
    width: 100%;
    font-size: 16px;
    color: #9e9e9e;
    text-align: center;
    -webkit-transition: color .5s linear;
    -moz-transition: color .5s linear;
    -o-transition: color .5s linear;
    transition: color .5s linear;
}
 .site-branding {
    max-width: 100%;
    padding: 100px 45px;
    position: relative;
    text-align: center;
}
</style>
<script>
    export default{
        data(){
            return {
                 lyric:[],
            }
        },
        mounted(){
              axios.post('/lyrics',{songid:this.$route.params.songid}).then((response)=>{
                  this.$store.state.audio.addEventListener("timeupdate", this.updateLyric);
                  this.parseLyric(response.data.lrc.lyric)
              });
        },
        methods:{
           parseLyric(text) {
              var lyric = text.split('\n'), //先按行分割
                    pattern = /\[(\d{2}):(\d{2})\.(\d{2,3})]/g,
                    result = [],
                    offset = this.getOffset(text); //调用歌词偏移
                while (!pattern.test(lyric[0])) {
                    lyric = lyric.slice(1);
                }
                lyric[lyric.length - 1].length === 0 && lyric.pop();
                lyric.forEach(function(v, i, a) {
                    var time = v.match(pattern),
                        value = v.replace(pattern, '');
                    time.forEach(function(v1, i1, a1) {
                        var t = v1.slice(1, -1).split(':');
                        result.push([parseInt(t[0], 10) * 60 + parseFloat(t[1]) + parseInt(offset) / 1000, value]);
                    });
                });
                result.sort(function(a, b) {
                    return a[0] - b[0];
                });
                this.lyric = result; //赋值给data里面的lyric用于显示歌词
            },
            //滚动歌词
           updateLyric: function() {
                if (this.lyric.length === 0 || '') return false;
                var lyricContainer = document.querySelector('#lyricContainer');
                for (var i = 0, l = this.lyric.length; i < l; i++) {
                    if (this.$store.state.audio.currentTime > this.lyric[i][0] - 0.50) {
                        var line = document.getElementById('line-' + i),
                            prevLine = document.getElementById('line-' + (i > 0 ? i - 1 : i));
                         if(line && lyricContainer && prevLine){
                                prevLine.className = 'current-other';
                                line.className = 'current-line';
                                lyricContainer.style.top = 110 - line.offsetTop + 'px';
                         }
                    }
                }
             },
            //歌词偏移
            getOffset(text) {
                var offset = 0;
                try {
                    var offsetPattern = /\[offset:\-?\+?\d+\]/g,
                        offset_line = text.match(offsetPattern)[0],
                        offset_str = offset_line.split(':')[1];
                    offset = parseInt(offset_str);
                }
                catch (err) {
                    offset = 0;
                }
                return offset;
             },
         }
    }

</script>
