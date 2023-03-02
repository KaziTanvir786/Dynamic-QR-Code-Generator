@extends('user.frame')
@section('content')

<style>
.list_show_button{
    width: 250px;
    height: 50px;
    background-color: green;
    border: none;
    color: white;
    border-radius: 15px;
    transition: .1s;
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>

<div id="qr-code-full">
<!-- <p class="card-text">Input : {{ $qr->user_input }}</p> -->

    @if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif

<div class="full-container">
    <div class="left-container">
        <!-- <label id="dynamic-link-label" for="dynamic-link">Dynamic Link</label> -->

        <div class="qr-hit">
            <!-- <h3 class="qr-hit-title">QR Hit</h3> -->
            <div class="hit-count"><span style="font-size: 20px;">QR HIT</span><span>{{$qr_hit}}</span></div>
        </div>

        <div class="link-container">
            <div class="dynamic-link-title-container">
                <h3 class="dynamic-link-title"><i style="margin-right: 10px" class="fa-solid fa-globe"></i>Your Generated Link</h3>
            </div>
            <!-- <input id="dynamic-link" type="text" class="form-control" disabled placeholder=""> -->
            <h3 class="dynamic-link"><?php echo $qr->dynamic_link; ?></h3>
        </div>
        
        <div class="alert alert-warning mt-3" role="alert">
            You will be redirected to <span style="color: #1974d2;"><?php echo $qr->input_text; ?></span> by visiting this generated dynamic link.
        </div>
        <a href="{{route('qr-list')}}"><button class="list_show_button">Go to your QR List</button></a>
    </div>
    <div class="preview-qr-container">
        <div class="new-qr-area" id="new_qrcode">
            <!-- <img src="https://i.ibb.co/QJsTLmR/frame.png" alt=""> -->
        </div>
        <div class="sizing-container">
            <div class="size-label-container">
                <span class="size-label">Low</span>
                <span style="text-align: center;" class="size-label">Medium</span>
                <span style="text-align: end;" class="size-label">High</span>
            </div>
            <input onchange="setSize()" type="range" id="range-picker" class="form-range range-input" min="1" max="5" id="rangePicker">
            <span id="image-resolution">(250px &#215 250px)</span>
            <button onclick="downloadQR()" type="button" class="qr-download-button">Download</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
      $(".counter").counterUp({
        delay: 10,
        time: 1000
      });
    });
  </script>

<script>

    var new_qrcode;
    var rangeButton = document.getElementById('range-picker');

    var new_element = document.getElementById('new_qrcode');
    new_element.innerHTML = '';

    var new_userInput = "<?php echo $qr->user_input; ?>";
    var new_userInput = "<?php echo $qr->user_input; ?>";
    var logoName = "<?php echo $qr->logo_name; ?>";
    var new_image;
    
    if(logoName.length == 0){
        new_image = null;
    }
    else{
        new_image = "{{ asset('') }}" + 'qr_icon/<?php echo $qr->user_id; ?>/<?php echo $qr->id; ?>/<?php echo $qr->logo_name; ?>';
    }
    console.log(new_image);
    var new_inputDotColor = "<?php echo $qr->dot_color; ?>";
    var new_inputEyeColor = "<?php echo $qr->eye_color; ?>";
    var new_inputDotStyle = "<?php echo $qr->dot_style; ?>";
    var new_inputEyeStyle = "<?php echo $qr->eye_style; ?>";
    var new_dynamicLink = "<?php echo $qr->dynamic_link; ?>";
    var givenWidth = 200;
    var givenHeight = 200;
    var picResolution = document.getElementById('image-resolution');

    function setSize(){
        var rangeValue = rangeButton.value;
        switch(rangeValue){
            case '1':
                givenWidth = 250;
                givenHeight = 250;
                picResolution.innerHTML = ('(250px &#215 250px)');
                break;
            case '2':
                givenWidth = 400;
                givenHeight = 400;
                picResolution.innerHTML = ('(400px &#215 400px)');
                break;
            case '3':
                givenWidth = 800;
                givenHeight = 800;
                picResolution.innerHTML = ('(800px &#215 800px)');
                break;
            case '4':
                givenWidth = 1000;
                givenHeight = 1000;
                picResolution.innerHTML = ('(1000px &#215 1000px)');
                break;
            case '5':
                givenWidth = 1600;
                givenHeight = 1600;
                picResolution.innerHTML = ('(1600px &#215 1600px)');
                break;
            default:
                givenWidth = 250;
                givenHeight = 250;
                picResolution.innerHTML = ('(250px &#215 250px)');
                break;
        }

        DownloadQRGenerator(new_element, givenWidth, givenHeight, new_dynamicLink, new_image, new_inputDotColor, new_inputEyeColor, new_inputDotStyle, new_inputEyeStyle);

        // alert(givenWidth);
    };

    window.onload = function () {
        newAttractiveQRGenerator(new_element, new_dynamicLink, new_image, new_inputDotColor, new_inputEyeColor, new_inputDotStyle, new_inputEyeStyle);
        setSize();
    }
    
    function newAttractiveQRGenerator(new_element, new_dynamicLink, new_image, new_inputDotColor, new_inputEyeColor, new_inputDotStyle, new_inputEyeStyle) {
        new_qrcode = new QRCodeStyling({
        width: 300,
        height: 300,
        data: new_dynamicLink,
        type: 'svg',
        margin: 10,
        image: new_image ? new_image : null,
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
    

function DownloadQRGenerator(new_element, givenWidth, givenHeight, new_dynamicLink, new_image, new_inputDotColor, new_inputEyeColor, new_inputDotStyle, new_inputEyeStyle) {
        downloadable_qrcode = new QRCodeStyling({
        width: givenWidth,
        height: givenHeight,
        data: new_dynamicLink,
        type: 'svg',
        margin: 10,
        image: new_image ? new_image : null,
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

@endsection