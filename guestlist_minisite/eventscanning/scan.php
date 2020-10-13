<?php
include('sql.php');
$query = mysqli_query($mysqli, "SELECT * FROM guestlist JOIN guestlist_access ON guestlist.ACCESS = guestlist_access.ACCESSID WHERE EVENTID = '1' ORDER BY FIRSTNAME, LASTNAME ASC");
if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $showsquery[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        if (location.protocol !== 'https:') {
            location.replace(`https:${location.href.substring(location.protocol.length)}`);
        }
    </script>
    <meta charset="utf-8" />
    <title>Scan Tickets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- App css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: 'Ropa Sans', sans-serif;
            color: #333;
            max-width: 640px;
            margin: 0 auto;
            position: relative;
        }

        #githubLink {
            position: absolute;
            right: 0;
            top: 12px;
            color: #2D99FF;
        }

        h1 {
            margin: 10px 0;
            font-size: 40px;
        }

        #loadingMessage {
            text-align: center;
            padding: 40px;
            background-color: #eee;
        }

        #canvas {
            width: 100%;
        }

        #output {
            margin-top: 20px;
            background: #eee;
            padding: 10px;
            padding-bottom: 0;
        }

        #output div {
            padding-bottom: 10px;
            word-wrap: break-word;
        }

        #noQRFound {
            text-align: center;
        }
    </style>
</head>

<body>

<div>
    <div class="col-12">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Scan Tickets</h4>
                        </div>
                    </div>
                </div>
    </div>
                <!-- end page title -->

    <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">

                            <button type="button" id="startBtn" class="btn btn-primary btn-lg" onclick="javascript:startCam();"><span class="fa fa-qrcode fa-lg"></span> Scan Ticket</button>
                            <i class=""></i>


                            <div id="mainTicketDiv"></div>

                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
    </div>
</div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
<script src="assets/js/jsQR.js"></script>
<script type="text/javascript">
    function sendQR(QRCode) {
        var QRCode;
        $.ajax({
            url: "ajax/scannedlistforcheckin.php?QR=" + QRCode,
            method: "GET"
        }).done(function(ajaxReturn) {
            //alert('loaded');
            $("#mainTicketDiv").html(ajaxReturn);
        });
    }

    function stopCam() {
        localstream.getTracks()[0].stop();
        $("#canvas").slideUp();
        $("#startBtn").slideDown();
    }

    function startCam() {
        $("#mainTicketDiv").html('<div id="loadingMessage">Unable to access video stream</div><canvas id="canvas" hidden></canvas><div id="output" hidden><div id="outputMessage">No QR code detected.</div><div hidden><b>Data:</b> <span id="outputData"></span></div></div>');
        $("#canvas").slideDown();
        $("#startBtn").slideUp();

        video = document.createElement("video");
        canvasElement = document.getElementById("canvas");
        canvas = canvasElement.getContext("2d");
        loadingMessage = document.getElementById("loadingMessage");
        outputContainer = document.getElementById("output");
        outputMessage = document.getElementById("outputMessage");
        outputData = document.getElementById("outputData");

        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
            video.srcObject = stream;
            localstream = stream;
            video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
            video.play();
            requestAnimationFrame(tick);
        });
    }




    var video = document.createElement("video");
    var canvasElement = document.getElementById("canvas");
    var canvas = canvasElement.getContext("2d");
    var loadingMessage = document.getElementById("loadingMessage");
    var outputContainer = document.getElementById("output");
    var outputMessage = document.getElementById("outputMessage");
    var outputData = document.getElementById("outputData");

    function drawLine(begin, end, color) {
        canvas.beginPath();
        canvas.moveTo(begin.x, begin.y);
        canvas.lineTo(end.x, end.y);
        canvas.lineWidth = 4;
        canvas.strokeStyle = color;
        canvas.stroke();
    }

    // Use facingMode: environment to attemt to get the front camera on phones
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
        video.srcObject = stream;
        video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
        video.play();
        requestAnimationFrame(tick);
    });

    function tick() {
        loadingMessage.innerText = "⌛ Loading video..."
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            loadingMessage.hidden = true;
            canvasElement.hidden = false;
            outputContainer.hidden = false;

            canvasElement.height = video.videoHeight;
            canvasElement.width = video.videoWidth;
            canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
            var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
            var code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });
            if (code) {
                drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
                drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
                drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
                drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
                outputMessage.hidden = true;
                outputData.parentElement.hidden = false;
                outputData.innerText = code.data;
                stopCam();
                sendQR(code.data);
            } else {
                outputMessage.hidden = false;
                outputData.parentElement.hidden = true;
            }
        }
        requestAnimationFrame(tick);
    }

</script>

<!-- Vendor js -->
<script src="../assets/js/vendor.min.js"></script>



<!-- App js -->
<script src="../assets/js/app.min.js"></script>

</body>
</html>