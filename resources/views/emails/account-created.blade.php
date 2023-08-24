<!DOCTYPE html>
<html>
<head>
    <title>Hesap Oluşturuldu</title>
</head>
<body>
    <p>Merhaba {{ $name }},</p>
    <br>
    <p>Sibelco-Üretim için hesabın oluşturuldu. Hesap bilgilerin şu şekilde:</p>
    <ul>
        <li>Hesap Tipi: <b>{{ $accountType }}</b></li>
        <li>Kullanıcı adın: <b>{{ $username }}</b></li>
        <li>Şifren: <b>{{ $password }}</b></li>
    </ul>
    <p>Lütfen ilk girişinde şifreni değiştirmeyi unutma.</p>
    <br>
    <p>Bu e-posta haricinde şifren hiçbir yerde tutulmuyor. Yöneticilerin ve geliştirici ekip dahil kimse senin şifreni bilmiyor. Lütfen bu e-postayı sil ve yeni bir şifre belirle. Şifre güvenliğinin kendi sorumluluğunda olduğunu unutma.</p>
</body>
</html>
