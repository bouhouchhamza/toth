<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found - Thoth LMS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .error-container { text-align: center; padding: 40px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 500px; }
        .error-code { font-size: 72px; font-weight: bold; color: #dc3545; margin-bottom: 20px; }
        .error-title { font-size: 24px; color: #333; margin-bottom: 15px; }
        .error-message { color: #666; margin-bottom: 30px; line-height: 1.6; }
        .btn { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-message">
            The page you are looking for doesn't exist or has been moved. 
            Please check the URL or return to the dashboard.
        </p>
        <a href="/student/dashboard" class="btn">Go to Dashboard</a>
    </div>
</body>
</html>
