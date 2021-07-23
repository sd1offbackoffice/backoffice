<title>Oops.. Terjadi kesalahan</title>

<body translate="no">
    <div class="full-screen">
        <div class="container">
            <span class="error-num">5</span>
            <div class="eye" style="transform: rotate(94.1339deg);"></div>
            <div class="eye" style="transform: rotate(94.1339deg);"></div>

            <p class="sub-text">Oh eyeballs! Something went wrong. We're <span class="italic">looking</span> to see what happened.</p>
            <a href="{{ url('/') }}">Back to Home</a>
        </div>
    </div>

<style>
    body{
        margin: 0;
    }

    .full-screen {
        background-color: #333333;
        width: 100vw;
        height: 100vh;
        color: white;
        font-family: "Arial Black";
        text-align: center;
    }

    .container {
        padding-top: 4em;
        width: 50%;
        display: block;
        margin: 0 auto;
    }

    .error-num {
        font-size: 8em;
    }

    .eye {
        background: #fff;
        border-radius: 50%;
        display: inline-block;
        height: 100px;
        position: relative;
        width: 100px;
    }
    .eye::after {
        background: #000;
        border-radius: 50%;
        bottom: 56.1px;
        content: " ";
        height: 33px;
        position: absolute;
        right: 33px;
        width: 33px;
    }

    .italic {
        font-style: italic;
    }

    p {
        margin-bottom: 4em;
    }

    a {
        color: white;
        text-decoration: none;
        text-transform: uppercase;
    }
    a:hover {
        color: lightgray;
    }
</style>

<script src={{asset('/js/jquery.js')}}></script>
<script id="rendered-js">
    $(".full-screen").mousemove(function (event) {
        var eye = $(".eye");
        var x = eye.offset().left + eye.width() / 2;
        var y = eye.offset().top + eye.height() / 2;
        var rad = Math.atan2(event.pageX - x, event.pageY - y);
        var rot = rad * (180 / Math.PI) * -1 + 180;
        eye.css({
            '-webkit-transform': 'rotate(' + rot + 'deg)',
            '-moz-transform': 'rotate(' + rot + 'deg)',
            '-ms-transform': 'rotate(' + rot + 'deg)',
            'transform': 'rotate(' + rot + 'deg)' });

    });
</script>







</body></html>
