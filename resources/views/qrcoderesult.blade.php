<html lang="it">
<head>
    <style>
        @page {
            size: 30mm 70mm;
            margin: 0;
        }
    </style>
    <title>QRCode</title>
</head>
<body>
<div style="border-width: 3px;border-style: solid;border-color:black;height: 30mm;width: 70mm;">
    <div style="display: flex;margin:2%;">
        <img id='barcode'
             src="https://api.qrserver.com/v1/create-qr-code/?data={{$alias.';'.$scadenza.';'.$lotto}}&amp;size=100x100"
             alt="QRCode" title="QRCode" width="100" height="100"/>
        <div style="display:flex;flex-direction:column;">
            <div style="padding:8%;padding-left: 50%!important;"><a style="font-weight: bolder;">{{$alias}}</a></div>
            <div style="padding:8%;padding-left: 50%!important;"><a style="font-weight: bolder;">{{$scadenza}}</a></div>
            <div style="padding:8%;padding-left: 50%!important;"><a style="font-weight: bolder;">{{$lotto}}</a></div>
        </div>
    </div>
</div>
</body>
</html>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', (event) => {
        window.print();
        window.onafterprint = function () {
            top.location.href = '/qrcode';
        };
    });
</script>
