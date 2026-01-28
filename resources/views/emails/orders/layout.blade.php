<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            background-color: #fdfcf8; 
            color: #111827; 
            margin: 0; 
            padding: 0; 
            -webkit-text-size-adjust: none;
            width: 100% !important;
        }
        .wrapper {
            width: 100%;
            background-color: #fdfcf8;
            padding: 40px 0;
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: white; 
            padding: 60px 40px; 
            border: 1px solid #f3f4f6;
        }
        .header { 
            text-align: center; 
            margin-bottom: 50px; 
        }
        .logo { 
            font-size: 28px; 
            font-weight: 400; 
            text-decoration: none; 
            color: #111111; 
            font-family: 'Georgia', serif; 
            text-transform: uppercase; 
            letter-spacing: 6px; 
            display: block;
        }
        .brand-accent {
            height: 1px;
            width: 40px;
            background-color: #d4af37;
            margin: 20px auto;
        }
        .content { 
            line-height: 1.8; 
            margin-bottom: 50px; 
            font-size: 15px;
            color: #4b5563;
        }
        .footer { 
            font-size: 11px; 
            color: #9ca3af; 
            text-align: center; 
            margin-top: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .btn { 
            display: inline-block; 
            padding: 18px 40px; 
            background-color: #111827; 
            color: #ffffff !important; 
            text-decoration: none; 
            font-size: 11px;
            font-weight: 600; 
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: background-color 0.3s;
        }
        .btn:hover { background-color: #374151; }
        
        /* Heading Styles */
        h1, h2, h3 { 
            color: #111827; 
            font-family: 'Georgia', serif; 
            font-weight: 400;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <a href="{{ url('/') }}" class="logo">
                    {{ \App\Models\Setting::get('site_name', 'NewKirk') }}
                </a>
                <div class="brand-accent"></div>
            </div>
            
            <div class="content">
                @yield('content')
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'NewKirk') }}. All rights reserved.</p>
                <div style="margin-top: 20px; color: #d1d5db;">Fragrance & Objects Atelier</div>
            </div>
        </div>
    </div>
</body>
</html>
