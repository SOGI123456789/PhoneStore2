
<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
</head>
<body>
    <h2>Đăng ký</h2>
    <form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label>Số điện thoại:</label>
        <input type="text" name="phone_number">
    </div>
    <div>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label>Nhập lại mật khẩu:</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Đăng ký</button>
    @if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
    @endif
    @if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
    @endif
</form>
    <a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập</a>
</body>
</html>