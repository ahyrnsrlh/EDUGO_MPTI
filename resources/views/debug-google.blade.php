<!DOCTYPE html>
<html>
<head>
    <title>Google OAuth Debug</title>
</head>
<body>
    <h1>Google OAuth Configuration Debug</h1>
    
    <h2>Configuration:</h2>
    <ul>
        <li><strong>Client ID:</strong> {{ $config['client_id'] ?? 'NOT SET' }}</li>
        <li><strong>Client Secret:</strong> {{ !empty($config['client_secret']) ? 'SET' : 'NOT SET' }}</li>
        <li><strong>Redirect URI:</strong> {{ $config['redirect'] ?? 'NOT SET' }}</li>
    </ul>
    
    <h2>Test Google Login:</h2>
    <a href="{{ route('auth.google') }}" style="background: #4285f4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Login with Google
    </a>
    
    <h2>Manual Redirect URL Test:</h2>
    <p>URL yang seharusnya dikunjungi Google setelah login:</p>
    <code>{{ url('/auth/google-callback') }}</code>
    
    <p><a href="{{ url('/auth/google-callback') }}">Test Callback URL</a></p>
</body>
</html>
