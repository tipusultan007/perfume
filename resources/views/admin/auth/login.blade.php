<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | L'ESSENCE NYC</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400&family=Inter:wght@300;400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-luxury-cream h-screen flex items-center justify-center font-sans text-luxury-black">
    <div class="bg-white p-12 w-full max-w-md shadow-sm border border-black/5">
        <h1 class="font-serif text-4xl text-center mb-10 tracking-widest font-light">L'ESSENCE</h1>
        
        <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] uppercase tracking-wider mb-2 opacity-60">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full py-3 border-b border-black/10 transition-colors focus:border-luxury-black outline-none bg-transparent text-sm">
                @error('email')
                    <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label class="block text-[10px] uppercase tracking-wider mb-2 opacity-60">Password</label>
                <input type="password" name="password" required
                    class="w-full py-3 border-b border-black/10 transition-colors focus:border-luxury-black outline-none bg-transparent text-sm">
                @error('password')
                    <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="pt-4">
                <button type="submit" 
                    class="w-full py-4 bg-luxury-black text-white text-[11px] uppercase tracking-[0.2em] hover:bg-opacity-90 transition-all">
                    Sign In
                </button>
            </div>
        </form>
    </div>
</body>
</html>
