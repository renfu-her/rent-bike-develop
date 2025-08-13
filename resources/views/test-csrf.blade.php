<!DOCTYPE html>
<html>
<head>
    <title>CSRF Test</title>
</head>
<body>
    <h1>CSRF Test Page</h1>
    
    <form method="POST" action="/test-csrf">
        <button type="submit">Test CSRF Exception</button>
    </form>
    
    <form method="POST" action="/cart">
        <button type="submit">Test CSRF Protection (Should Fail)</button>
    </form>
</body>
</html>
