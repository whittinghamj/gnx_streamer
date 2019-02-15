<!doctype html>

<head>

   <!-- player skin -->
   <link rel="stylesheet" href="skin/skin.css">

   <!-- site specific styling -->
   <style>
   body { font: 12px "Myriad Pro", "Lucida Grande", sans-serif; text-align: center; padding-top: 5%; }
   .flowplayer { width: 80%; }
   </style>

   <!-- for video tag based installs flowplayer depends on jQuery 1.7.2+ -->
   <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

   <!-- include flowplayer -->
   <script src="flowplayer.min.js"></script>

</head>

<body>

   <!-- the player -->
   <div class="flowplayer" data-swf="flowplayer.swf" data-ratio="0.4167">
      <video>
         <source type="video/webm" src="http://86.4.171.7:9000/hls/video0.m3u8">
      </video>
   </div>

</body>
