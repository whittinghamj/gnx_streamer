<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Streaming</title>
    <link href="//vjs.zencdn.net/5.8/video-js.min.css" rel="stylesheet">
    <script src="//vjs.zencdn.net/5.8/video.min.js"></script>
</head>
<body>
<video id="player" class="video-js vjs-default-skin" height="360" width="640" controls preload="none">
    <source src="http://192.168.1.50:9000/hls/video0.m3u8" type="application/x-mpegURL" />
</video>
<script>
    var player = videojs('#player');
</script>
</body>
</html>