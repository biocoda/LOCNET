var qrcode = window.qrcode;

var video = document.createElement("video");
var canvasElement = document.getElementById("qr-canvas");
var canvas = canvasElement.getContext("2d");

var qrResult = document.getElementById("qr-result");
var outputData = document.getElementById("outputData");
var btnScanQR = document.getElementById("btn-scan-qr");

var scanning = false;

qrcode.callback = res => {
    if (res) {
      outputData.innerText = res;
      scanning = false;

      video.srcObject.getTracks().forEach(track => {
        track.stop();
      });

      canvasElement.hidden = true;
      btnScanQR.hidden = false;

      function remoteClick() {

          $(document).ready(function(){

              setTimeout(function(){

                  console.log('remote click func fired');

                  $("#hiddenPostBtn").click();


              },1);

          });
      }
    
      $('#assetID').val(outputData.innerText);

      remoteClick();
    }
}

btnScanQR.onclick = () => {
  navigator.mediaDevices
    .getUserMedia({ video: { facingMode: "environment" } })
    .then(function(stream) {
      scanning = true;
      qrResult.hidden = true;
      btnScanQR.hidden = true;
      canvasElement.hidden = false;
      video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
      video.srcObject = stream;
      video.play();
      tick();
      scan();
    });
};

function tick() {
  canvasElement.height = video.videoHeight;
  canvasElement.width = video.videoWidth;
  canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

  scanning && requestAnimationFrame(tick);
}

function scan() {
  try {
    qrcode.decode();
  } catch (e) {
    setTimeout(scan, 300); 
  }
}