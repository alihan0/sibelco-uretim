<!DOCTYPE html>
<html>
<head>
    <title>Şifren Değiştirildi</title>
</head>
<body>
    <p>Merhaba {{ $name }},</p>
    <br>
    <p>Bir yönetici tarafından Sibelco Türkiye - Üretim giriş şifren değiştirildi. Artık eski şifrenle giriş yapamayacaksın. Giriş yapabilmen için kullanacağın yeni şifren aşağıdadır.</p>
    <ul>
        <li>Şifren: <b>{{ $password }}</b></li>
    </ul>
    <p>Lütfen ilk girişinde şifreni değiştirmeyi unutma.</p>
    <br>
    <p>Bu e-posta haricinde şifren hiçbir yerde tutulmuyor. Yöneticilerin ve geliştirici ekip dahil kimse senin şifreni bilmiyor. Lütfen bu e-postayı sil ve yeni bir şifre belirle. Şifre güvenliğinin kendi sorumluluğunda olduğunu unutma.</p>
</body>
</html>
