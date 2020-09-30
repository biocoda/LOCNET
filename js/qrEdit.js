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
                btnScanAddSteamQR.hidden = false;
                $("#hdBtnAddSteamId").click();
                break;
            case 'btn-scan-remSteam-qr':
                $('#steamDeviceID').val(outputData.innerText);
                btnScanRemSteamQR.hidden = false;
                $("#hdBtnRemSteamId").click();
                break;
            case 'btn-scan-addWater-qr':
                $('#waterDeviceID').val(outputData.innerText);
                btnScanAddWaterQR.hidden = false;
                $("#hdBtnAddWaterId").click();
                break;
            case 'btn-scan-remWater-qr':
                $('#waterDeviceID').val(outputData.innerText);
                btnScanRemWaterQR.hidden = false;
                $("#hdBtnRemWaterId").click();
                break;
            case 'btn-scan-addCda-qr':
                $('#cdaDeviceID').val(outputData.innerText);
                btnScanAddCdaQR.hidden = false;
                $("#hdBtnAddCdaId").click();
                break;
            case 'btn-scan-remCda-qr':
                $('#cdaDeviceID').val(outputData.innerText);
                btnScanRemCdaQR.hidden = false;
                $("#hdBtnRemCdaId").click();
                break;
            case 'btn-scan-addElec-qr':
                $('#elecDeviceID').val(outputData.innerText);
                btnScanAddElecQR.hidden = false;
                $("#hdBtnAddElecId").click();
                break;
            case 'btn-scan-remElec-qr':
                $('#elecDeviceID').val(outputData.innerText);
                 btnScanRemElecQR.hidden = false;
                $("#hdBtnRemElecId").click();
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
            btnRem = btnScanAddSteamQR;
            break;
        case 'btn-scan-addWater-qr':
            $('#qr-canvas').prependTo('#waterCanvasPH');
            btnRem = btnScanAddWaterQR;
            break;
        case 'btn-scan-addCda-qr':
            $('#qr-canvas').prependTo('#cdaCanvasPH');
            btnRem = btnScanAddCdaQR;
            break;
        case 'btn-scan-addElec-qr':
            $('#qr-canvas').prependTo('#elecCanvasPH');
            btnRem = btnScanAddElecQR;
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
            btnRem = btnScanRemSteamQR;
            break;
        case 'btn-scan-remWater-qr':
            $('#qr-canvas').prependTo('#waterCanvasPH');
            btnRem = btnScanRemWaterQR;
            break;
        case 'btn-scan-remCda-qr':
            $('#qr-canvas').prependTo('#cdaCanvasPH');
            btnRem = btnScanRemCdaQR;
            break;
        case 'btn-scan-remElec-qr':
            $('#qr-canvas').prependTo('#elecCanvasPH');
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
    	setTimeout(scan, 300);
  	}
}