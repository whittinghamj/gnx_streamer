<?php $source = $_GET['source']; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BBC One SD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/functional.css">
    <!-- CSS for this demo -->
    
    <!-- skin -->
   <link rel="stylesheet" href="https://releases.flowplayer.org/7.2.7/skin/skin.css">
   
   <!-- hls.js -->
   <script src="https://cdn.jsdelivr.net/npm/hls.js@0.11.0/dist/hls.light.min.js"></script>
   
   <!-- flowplayer -->
   <script src="https://releases.flowplayer.org/7.2.7/flowplayer.min.js"></script>

    <style>
        .fullscreen-bg {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            overflow: hidden;
            z-index: -100;
        }

        .fullscreen-bg__video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <div id="fp-hlsjs"></div>
    
    <script>
         flowplayer("#fp-hlsjs", {
               ratio: 9/16,
               clip: {
                     autoplay: true,
                     title: "video0 source",
                     sources: [{ type: "application/x-mpegurl",
                           src:  "http://192.168.1.52:9000/hls/<?php echo $source; ?>.m3u8",
                           live: true          
                     }
               ]
           },
           embed: false,
           share: false,
           autoplay: true,
       });
    </script>
        
</body>
</html>
