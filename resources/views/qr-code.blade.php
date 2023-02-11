@extends('layout')
@section('content')
@include('header')
<div id="qr-code-full">
<!-- <p class="card-text">Input : {{ $qr->user_input }}</p> -->

<div class="full-container">
    <div class="left-container">
        <!-- <label id="dynamic-link-label" for="dynamic-link">Dynamic Link</label> -->
        <h5 class="modification-title"><i class="fa-solid fa-qrcode mod-icon"></i>Dynamic Link</h5>
        <input id="dynamic-link" type="text" class="form-control" disabled placeholder="<?php echo $qr->user_input; ?>" aria-label="Example text with button addon" aria-describedby="button-addon1">
    </div>
    <div class="preview-qr-container">
        <div class="new-qr-area" id="new_qrcode">
            <!-- <img src="https://i.ibb.co/QJsTLmR/frame.png" alt=""> -->
        </div>
        <div class="sizing-container">
            <input onchange="setSize()" type="range" id="range-picker" class="form-range range-input" min="1" max="5" id="rangePicker">
            <div class="size-label-container">
                <span class="size-label">Low</span>
                <span style="text-align: center;" class="size-label">Medium</span>
                <span style="text-align: end;" class="size-label">High</span>
            </div>
            <button onclick="downloadQR()" type="button" class="download-button">Download</button>
        </div>
    </div>
</div>

<script>

    var new_qrcode;
    var rangeButton = document.getElementById('range-picker');

    var new_element = document.getElementById('new_qrcode');
    new_element.innerHTML = '';

    var new_userInput = "<?php echo $qr->user_input; ?>";
    var new_image = null;
    var new_inputDotColor = "<?php echo $qr->dot_color; ?>";
    var new_inputEyeColor = "<?php echo $qr->eye_color; ?>";
    var new_inputDotStyle = "<?php echo $qr->dot_style; ?>";
    var new_inputEyeStyle = "<?php echo $qr->eye_style; ?>";
    var givenWidth = 200;
    var givenHeight = 200;

    function setSize(){
        var rangeValue = rangeButton.value;
        switch(rangeValue){
            case '1':
                givenWidth = 250;
                givenHeight = 250;
                break;
            case '2':
                givenWidth = 400;
                givenHeight = 400;
                break;
            case '3':
                givenWidth = 800;
                givenHeight = 800;
                break;
            case '4':
                givenWidth = 1000;
                givenHeight = 1000;
                break;
            case '5':
                givenWidth = 1600;
                givenHeight = 1600;
                break;
            default:
                givenWidth = 250;
                givenHeight = 250;
                break;
        }

        DownloadQRGenerator(new_element, givenWidth, givenHeight, new_userInput, new_image, new_inputDotColor, new_inputEyeColor, new_inputDotStyle, new_inputEyeStyle);

        // alert(givenWidth);
    };

    window.onload = function () {
        newAttractiveQRGenerator(new_element, new_userInput, new_image, new_inputDotColor, new_inputEyeColor, new_inputDotStyle, new_inputEyeStyle);
    }
    
    function newAttractiveQRGenerator(new_element, new_userInput, new_image, new_inputDotColor, new_inputEyeColor, new_inputDotStyle, new_inputEyeStyle) {
        new_qrcode = new QRCodeStyling({
        width: 300,
        height: 300,
        data: new_userInput,
        type: 'svg',
        margin: 10,
        image: image ? image : null,
        imageOptions: {
            margin: 4,
            crossOrigin: 'anonymous',
        },
        dotsOptions: {
            color: new_inputDotColor,
            // type: 'square',
            type: new_inputDotStyle,
            // type: 'rounded',
            // type: 'extra-rounded',
            // type: 'classy-rounded',
        },
        cornersSquareOptions: {
            color: new_inputEyeColor,
            // type: 'square',
            type: new_inputEyeStyle,
            // type: 'rounded',
            // type: 'extra-rounded',
            // type: 'classy-rounded',
        }
    });
    //db tasks  to save the informations
    new_qrcode.append(new_element);
}
    

function DownloadQRGenerator(new_element, givenWidth, givenHeight, new_userInput, new_image, new_inputDotColor, new_inputEyeColor, new_inputDotStyle, new_inputEyeStyle) {
        downloadable_qrcode = new QRCodeStyling({
        width: givenWidth,
        height: givenHeight,
        data: new_userInput,
        type: 'svg',
        margin: 10,
        image: image ? image : null,
        imageOptions: {
            margin: 4,
            crossOrigin: 'anonymous',
        },
        dotsOptions: {
            color: new_inputDotColor,
            // type: 'square',
            type: new_inputDotStyle,
            // type: 'rounded',
            // type: 'extra-rounded',
            // type: 'classy-rounded',
        },
        cornersSquareOptions: {
            color: new_inputEyeColor,
            // type: 'square',
            type: new_inputEyeStyle,
            // type: 'rounded',
            // type: 'extra-rounded',
            // type: 'classy-rounded',
        }
    });
    //db tasks  to save the informations
    // new_qrcode.append(new_element);
}

function downloadQR() {
    downloadable_qrcode.download({ name: 'qrcode(' + givenWidth + 'x' + givenHeight + ')', extension: 'png' });
}

</script>
</div>
@include('footer')