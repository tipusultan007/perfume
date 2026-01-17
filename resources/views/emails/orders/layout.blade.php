<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: #f9f9f9; color: #333; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; text-decoration: none; color: black; font-family: 'Garamond', serif; text-transform: uppercase; letter-spacing: 2px; }
        .content { line-height: 1.6; margin-bottom: 40px; }
        .footer { font-size: 12px; color: #999; text-align: center; border-top: 1px solid #eee; padding-top: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #000; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .btn:hover { background-color: #333; }
        .order-details { margin-top: 20px; background: #f5f5f5; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ url('/') }}" class="logo">{{ \App\Models\Setting::get('site_name', 'L\'ESSENCE') }}</a>
        </div>
        
        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'L\'ESSENCE') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
