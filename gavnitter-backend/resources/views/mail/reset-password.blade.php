<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="{{asset('css/email.css')}}" rel="stylesheet" type="text/css">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset your Password</title>
</head>
<body>
<table
    >
    <tbody>
    <tr>
        <img
            src="{{asset('assets/logo.png')}}"
            alt="logo">
    </tr>
    <tr>
        <p>To reset your password, follow the link to reset your password.</p>
    </tr>
    <tr>
        <td>
            <a href="{{ config('app.url_front') . '/reset-password?token=' . $token . '&email=' . $email }}"
               style="display: block; font-weight: 600; font-size: 14px; line-height: 100%; padding: 16px 24px; --text-opacity: 1; color: #ffffff; color: rgba(255, 255, 255, var(--text-opacity)); text-decoration: none;">Reset Password →</a>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
