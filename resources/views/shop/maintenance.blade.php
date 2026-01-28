<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evolving... | L'ESSENCE NYC</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,500;0,600;1,300&family=Montserrat:wght@300;400;500;600&family=Space+Mono&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #fbf9f4;
            --accent: #D4AF37;
            --black: #0A0A0A;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: var(--cream);
            color: var(--black);
            font-family: 'Cormorant Garamond', serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            overflow: hidden;
        }
        .container {
            max-width: 600px;
            padding: 40px;
            animation: fadeIn 2s ease-out;
        }
        .logo {
            font-size: 2.5rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            margin-bottom: 40px;
            font-weight: 300;
        }
        .divider {
            width: 80px;
            height: 1px;
            background-color: var(--accent);
            margin: 0 auto 40px;
        }
        h1 {
            font-size: 3.5rem;
            font-style: italic;
            font-weight: 300;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        p {
            font-family: 'Montserrat', sans-serif;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            opacity: 0.6;
            margin-bottom: 40px;
        }
        .status {
            font-family: 'Space Mono', monospace;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 8px 20px;
            display: inline-block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">L'ESSENCE</div>
        <div class="divider"></div>
        <h1>Our atelier is<br>currently evolving.</h1>
        <p>We are refining our collection and will return shortly with fresh inspirations.</p>
        <div class="status">Atelier Maintenance</div>
    </div>
</body>
</html>
