
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href=" styles/login.css">
  <title>LOGIN</title>
</head>

<body>
  <header>RECORD MANAGEMENT SYSTEM</header>
  <div class="container" id="container">
    <div class="form-container sign-up-container">
      <!-- SIGN UP/ CREATE ACCOUNT FORM -->
      <form action="#">
        <h1>Create Account</h1>
        
        <input type="text" placeholder="Full Name" />
        <input type="text" placeholder="Username" />
        <input type="email" placeholder="Email" />
        <input type="password" placeholder="Password" />
        <select name="roles" id="roles" >
          <option value="">Select Role: </option>
          <option value="admin">Admin</option>
          <option value="staff">Staff</option>
          <option value="regular_user">Regular User</option>
        </select>
        <button>Sign Up</button>
      </form>
    </div>
    <div class="form-container sign-in-container">
      <!-- SIGN IN/ LOGIN TO ACCOUNT -->
      <form action="#">
        <h1>Sign in</h1>
        
        <input type="email" placeholder="Email" />
        <input type="password" placeholder="Password" />
        <a href="#">Forgot your password?</a>
        <button>Sign In</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login with your personal info</p>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Hello, Friend!</h1>
          <p>Enter your personal details and start journey with us</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>
  </div>


<!-- JAVASCRIPT -->
  <script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
      container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
      container.classList.remove("right-panel-active");
    });
  </script>
</body>

</html>
