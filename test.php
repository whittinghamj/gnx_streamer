<body>
<section class="text-center">
  <h1>click on image below</h1>
<img data-toggle="modal" data-target="#homeVideo" class="img-responsive" src="http://www.gossettmktg.com/video/dangot.png" onclick="playVid()" />
</section>
</body>

<style>
body {
    background-color: #30b3f2;
}
h1 {
  color: #fff;
}
section {
    padding-top: 2em;
    padding-bottom: 2em;
}
section h1 {
  margin-bottom: 1em;
}
section img {
  border: #ddd solid 1px;
  border-radius: 5px;
}
#homeVideo button.btn.btn-default {
    background: black;
    border-radius: 50%;
    position: absolute;
    right: 0;
    z-index: 5;
    color: white;
}
</style>

<!-- Home Video Modal -->
<div class="modal fade" id="homeVideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button type="button" class="btn btn-default" data-dismiss="modal" onclick="pauseVid()">X</button>
      <div class="embed-responsive embed-responsive-16by9">
        <video id="gossVideo" class="embed-responsive-item" controls="controls" poster="http://www.gossettmktg.com/video/dangot.png">
          <source src="http://www.gossettmktg.com/video/dangot.mp4" type="video/mp4">
          <source src="http://www.gossettmktg.com/video/dangot.webm" type="video/webm">
          <source src="http://www.gossettmktg.com/video/dangot.ogv" type="video/ogg">
          <object type="application/x-shockwave-flash" data="https://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" width="353" height="190">
            <param name="movie" value="https://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
            <param name="allowFullScreen" value="true">		<param name="wmode" value="transparent">
            <param name="flashVars" value="config={'playlist':['http%3A%2F%2Fwww.gossettmktg.com%2Fvideo%2Fdangot.png',{'url':'http%3A%2F%2Fwww.gossettmktg.com%2Fvideo%2Fdangot.mp4','autoPlay':false}]}">
            <img alt="Big Buck Bunny" src="http://www.gossettmktg.com/video/dangot.png" width="353" height="190" title="No video playback capabilities, please download the video below">
          </object>
        </video>
      </div>
    </div>
  </div>
</div>

<script>
	var vid = document.getElementById("gossVideo"); 

function playVid() { 
    vid.play(); 
} 

function pauseVid() { 
    vid.pause(); 
} 
</script>