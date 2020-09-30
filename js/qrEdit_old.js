var qrcode = window.qrcode;

var video = document.createElement("video");
var canvasElement = document.getElementById("qr-canvas");
var canvas = canvasElement.getContext("2d");

var qrResult = document.getElementById("qr-result");
var outputData = document.getElementById("outputData");

var btnScanAddSteamQR = document.getElementById("btn-scan-addSteam-qr");
var btnScanRemSteamQR = document.getElementById("btn-scan-remSteam-qr");

var btnScanAddWaterQR = document.getElementById("btn-scan-addWater-qr");
var btnScanRemWaterQR = document.getElementById("btn-scan-remWater-qr");

var btnScanAddCdaQR = document.getElementById("btn-scan-addCda-qr");
var btnScanRemCdaQR = document.getElementById("btn-scan-remCda-qr");

var btnScanAddElecQR = document.getElementById("btn-scan-addElec-qr");
var btnScanRemElecQR = document.getElementById("btn-scan-remElec-qr");

var sourceToIsolate;

var scanning = false;

qrcode.callback = res => {
    if (res) {
		outputData.innerText = res;
		scanning = false;

		video.srcObject.getTracks().forEach(track => {
			track.stop();
		});

		canvasElement.hidden = true;      

        switch (sourceToIsolate) {

            case 'btn-scan-addSteam-qr':
                $('#steamDeviceID').val(outputData.innerText);
                $('#addRemDev').val('add');
                btnScanAddSteamQR.hidden = false;
                $("#hiddenSteamPostBtn").click();
                break;
            case 'btn-scan-remSteam-qr':
                $('#steamDeviceID').val(outputData.innerText);
                $('#addRemDev').val('remove');
                btnScanRemSteamQR.hidden = false;
                $("#hiddenSteamPostBtn").click();
                break;
            case 'btn-scan-addWater-qr':
                $('#waterDeviceID').val(outputData.innerText);
                $('#addRemDev').val('add');
                btnScanAddWaterQR.hidden = false;
                $("#hiddenWaterPostBtn").click();
                break;
            case 'btn-scan-remWater-qr':
                $('#waterDeviceID').val(outputData.innerText);
                $('#addRemDev').val('remove');
                btnScanRemWaterQR.hidden = false;
                $("#hiddenWaterPostBtn").click();
                break;
            case 'btn-scan-addCda-qr':
                $('#cdaDeviceID').val(outputData.innerText);
                $('#addRemDev').val('add');
                btnScanAddCdaQR.hidden = false;
                $("#hiddenCdaPostBtn").click();
                break;
            case 'btn-scan-remCda-qr':
                $('#cdaDeviceID').val(outputData.innerText);
                $('#addRemDev').val('remove');
                btnScanRemCdaQR.hidden = false;
                $("#hiddenCdaPostBtn").click();
                break;
            case 'btn-scan-addElec-qr':
                $('#elecDeviceID').val(outputData.innerText);
                $('#addRemDev').val('add');
                btnScanAddElecQR.hidden = false;
                $("#hiddenElecPostBtn").click();
                break;
            case 'btn-scan-remElec-qr':
                $('#elecDeviceID').val(outputData.innerText);
                $('#addRemDev').val('remove');
                btnScanRemElecQR.hidden = false;
                $("#hiddenElecPostBtn").click();
                break;
        }
    }
}

function btnScanAdd(btnClickedId) {

    sourceToIsolate = btnClickedId;

    var btnRem;

    switch (btnClickedId) {
        case 'btn-scan-addSteam-qr':
            $('#qr-canvas').prependTo('#steamCanvasPH');
            $('#addRemDev').prependTo('#steamDeviceID');
            btnRem = btnScanAddSteamQR;
            break;
        case 'btn-scan-addWater-qr':
            $('#qr-canvas').prependTo('#waterCanvasPH');
            $('#addRemDev').prependTo('#waterDeviceID');
            btnRem = btnScanAddWaterQR;
            break;
        case 'btn-scan-addCda-qr':
            $('#qr-canvas').prependTo('#cdaCanvasPH');
            $('#addRemDev').prependTo('#cdaDeviceID');
            btnRem = btnScanAddCdaQR;
            break;
        case 'btn-scan-addElec-qr':
            $('#qr-canvas').prependTo('#elecCanvasPH');
            $('#addRemDev').prependTo('#elecDeviceID');
            btnRem = btnScanAddElecQR;
            console.log('eis button clicked');
            break;
    }

    navigator.mediaDevices
    .getUserMedia({ video: { facingMode: "environment" } })
    .then(function(stream) {
        scanning = true;
        qrResult.hidden = true;
        btnRem.hidden = true
        canvasElement.hidden = false;
        video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
        video.srcObject = stream;
        video.play();
        tick();
        scan();
    });
}


function btnScanRemove(btnClickedId) {

    sourceToIsolate = btnClickedId;

    var btnRem;

    switch (btnClickedId) {
        case 'btn-scan-remSteam-qr':
            $('#qr-canvas').prependTo('#steamCanvasPH');
            $('#addRemDev').prependTo('#steamDeviceID');
            btnRem = btnScanRemSteamQR;
            break;
        case 'btn-scan-remWater-qr':
            $('#qr-canvas').prependTo('#waterCanvasPH');
            $('#addRemDev').prependTo('#waterDeviceID');
            btnRem = btnScanRemWaterQR;
            break;
        case 'btn-scan-remCda-qr':
            $('#qr-canvas').prependTo('#cdaCanvasPH');
            $('#addRemDev').prependTo('#cdaDeviceID');
            btnRem = btnScanRemCdaQR;
            break;
        case 'btn-scan-remElec-qr':
            $('#qr-canvas').prependTo('#elecCanvasPH');
            $('#addRemDev').prependTo('#elecDeviceID');
            btnRem = btnScanRemElecQR;
            break;
    }

    navigator.mediaDevices
    .getUserMedia({ video: { facingMode: "environment" } })
    .then(function(stream) {
        scanning = true;
        qrResult.hidden = true;
        btnRem.hidden = true
        canvasElement.hidden = false;
        video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
        video.srcObject = stream;
        video.play();
        tick();
        scan();
    });
}

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
    	setTimeout(scan, 300); // was 300
  	}
}