<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/vue/2.1.3/vue.min.js"></script>
</head>
<div id="app">
</div>
<script>
    new Vue({
        el:"#app",
        data:{
            audio:document.createElement('audio'),
        },
        mounted(){
            this.audio.src="https://photo.laravelchen.cn/song%E8%96%9B%E4%B9%8B%E8%B0%A6%20-%20%E6%88%91%E5%A5%BD%E5%83%8F%E5%9C%A8%E5%93%AA%E8%A7%81%E8%BF%87%E4%BD%A0.mp3";
            this.audio.play();
        }
    })
</script>
<body>
</body>
</html>