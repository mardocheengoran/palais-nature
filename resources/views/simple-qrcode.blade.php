<!DOCTYPE html>
<html>
<head>
	<title>Simple Qrcode</title>
</head>
<body>
	<!-- On affiche le code QR au format SVG -->
	{{-- {{ $qrcode }} --}}

    <img src="data:image/png;base64,{!! base64_encode(
        QrCode::format('png')->generate("https://akilischool.com/cours/laravel-generer-un-qr-code-avec-simple-qrcode")
    ) !!}" alt="">
</body>
</html>
