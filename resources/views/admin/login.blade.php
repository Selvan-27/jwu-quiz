<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MyAdmin Login</title>

<style>
:root {
  --primary: linear-gradient(90deg, rgb(110, 29, 253) 60%, rgb(69, 123, 252) 100%);;       /* Brand primary color */
  --primary-dark: #0d47a1;
  --accent: #26a69a;
  --bg: #f4f6f8;
  --text: #333;
}

* {
  box-sizing: border-box;
  font-family: 'Roboto', Arial, sans-serif;
}

body {
  margin: 0;
  height: 100vh;
  background: linear-gradient(90deg, rgb(110, 29, 253) 60%, rgb(69, 123, 252) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-card {
  width: 100%;
  max-width: 360px;
  background: #fff;
  padding: 28px 24px;
  border-radius: 14px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

/* ===== BRAND HEADER ===== */
.brand {
  text-align: center;
  margin-bottom: 24px;
}

.brand-logo {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: var(--primary);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 28px;
  font-weight: bold;
  margin: 0 auto 12px;
}

.brand-name {
  font-size: 20px;
  font-weight: 500;
  color: var(--primary);
}

/* ===== INPUTS ===== */
.field {
  position: relative;
  margin-bottom: 22px;
}

.field input {
  width: 100%;
  padding: 14px 12px;
  border: none;
  border-bottom: 2px solid #ccc;
  font-size: 16px;
  outline: none;
}

.field label {
  position: absolute;
  left: 12px;
  top: 14px;
  color: #777;
  font-size: 14px;
  transition: 0.3s;
  pointer-events: none;
}

.field input:focus {
  border-bottom-color: var(--primary);
}

.field input:focus + label,
.field input:not(:placeholder-shown) + label {
  top: -8px;
  font-size: 12px;
  /*color: var(--primary);*/
  background: #fff;
  padding: 0 4px;
}

/* ===== BUTTON ===== */
.login-btn {
  width: 100%;
  padding: 14px;
  background: var(--primary);
  border: none;
  border-radius: 8px;
  color: #fff;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  transition: 0.3s;
}

.login-btn:hover {
  background: var(--primary-dark);
}

/* ===== FOOTER ===== */
.footer {
  text-align: center;
  font-size: 13px;
  color: #666;
  margin-top: 18px;
}
</style>
</head>

<body>

<div class="login-card">

  <div class="brand">
  
     <!--Replace text with <img src="logo.png"> if you have a logo -->
    <div class="brand-logo">    <img src="jwu.png" width="100px"> </div>
    <div class="brand-name">Quiz Admin Panel</div>
  </div>
 

   <form method="POST" action="{{ route('login') }}">
           @csrf
    <div class="field">
      <input type="text" name="email" class="form-input" value="{{ old('email') }}" required="">
      <label>Admin Username</label>
    </div>

    <div class="field">
      <input type="password"  name="password" class="form-input" required="">
      <label>Password</label>
    </div>
  @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    
    @if (session('error'))
    <div class="alert alert-danger">
   Invalid Admin credentials
    </div>
@endif
    <button class="login-btn">LOGIN</button>
  </form>

  <div class="footer">
    © 2026 MyAdmin
  </div>

</div>

</body>
</html>
