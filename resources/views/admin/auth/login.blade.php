<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | {{ \App\Models\Setting::get('site_name', 'L\'ESSENCE') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-[#0f172a] h-screen flex items-center justify-center font-sans text-slate-200 overflow-hidden">
    <!-- Background Animation -->
    <div class="fixed inset-0 z-0">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
    </div>

    <div class="relative z-10 w-full max-w-md p-8">
        <div class="glass p-10 rounded-3xl shadow-2xl space-y-8">
            <div class="text-center space-y-2">
                <h1 class="font-serif text-5xl text-white tracking-widest font-light">{{ \App\Models\Setting::get('site_name', 'L\'ESSENCE') }}</h1>
                <p class="text-slate-400 text-sm uppercase tracking-[0.3em] font-medium">Administration</p>
            </div>
            
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest mb-2 text-slate-400 group-focus-within:text-purple-400 transition-colors">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full py-3 px-4 bg-white/10 border border-white/20 rounded-xl focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 outline-none transition-all text-sm text-slate-900 placeholder-slate-500"
                            placeholder="admin@lessence.nyc">
                    </div>
                    @error('email')
                        <span class="text-rose-400 text-xs mt-2 block">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-widest mb-2 text-slate-400 group-focus-within:text-purple-400 transition-colors">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required
                            class="w-full py-3 px-4 bg-white/10 border border-white/20 rounded-xl focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 outline-none transition-all text-sm text-slate-900 placeholder-slate-500"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <span class="text-rose-400 text-xs mt-2 block">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[11px] font-bold uppercase tracking-[0.2em] rounded-xl shadow-lg shadow-purple-500/20 transform hover:-translate-y-0.5 transition-all duration-200">
                        Sign In to Dashboard
                    </button>
                </div>
            </form>

            <div class="text-center pt-4">
                <a href="/" class="text-slate-500 hover:text-white text-[10px] uppercase tracking-widest transition-colors">
                    &larr; Return to storefront
                </a>
            </div>
        </div>
    </div>
</body>
</html>
