<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Thoth LMS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 400px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; margin-bottom: 30px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #555; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        .btn { width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        .btn:hover { background: #218838; }
        .error { color: #dc3545; margin-bottom: 15px; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; }
        .link { text-align: center; margin-top: 20px; }
        .link a { color: #007bff; text-decoration: none; }
        .link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register for Thoth LMS</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/register">
            <input type="hidden" name="csrf_token" value="<?php echo \Auth::generateCSRFToken(); ?>">
            
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
            </div>
            
            <button type="submit" class="btn">Register</button>
        </form>
        
        <div class="link">
            <p>Already have an account? <a href="/login">Login here</a></p>
        </div>
    </div>
</body>
</html>