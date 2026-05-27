<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment...</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f8f9fa; }
        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto 20px auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .message { text-align: center; color: #333; }
    </style>
</head>
<body onload="document.getElementById('ccavenue_form').submit();">
    <div class="message">
        <div class="loader"></div>
        <h2>Please wait...</h2>
        <p>Redirecting to secure payment gateway.</p>
    </div>
    <form id="ccavenue_form" method="POST" action="{{ $url }}">
        <input type="hidden" name="encRequest" value="{{ $encRequest }}">
        <input type="hidden" name="access_code" value="{{ $access_code }}">
    </form>
</body>
</html>
