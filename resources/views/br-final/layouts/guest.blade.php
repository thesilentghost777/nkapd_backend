<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Business Room')</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #0d0d0f; color: #e5e5e7; min-height: 100vh; }
        h1,h2,h3 { font-family: 'Syne', sans-serif; }
        .glass { background: rgba(22,22,24,.8); border: 1px solid rgba(255,255,255,.07); backdrop-filter: blur(20px); }
        .btn-primary { background: linear-gradient(135deg,#f97316,#ea580c); color:#fff; font-family:'Syne',sans-serif; font-weight:700; transition: all .2s; }
        .btn-primary:hover { transform:translateY(-1px); box-shadow:0 12px 30px rgba(249,115,22,.35); }
        .input { background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.1); color:#fff; border-radius:10px; transition: border-color .2s; }
        .input:focus { outline:none; border-color:#f97316; box-shadow:0 0 0 3px rgba(249,115,22,.1); }
        .mesh { position:fixed; inset:0; background: radial-gradient(ellipse at 20% 50%, rgba(249,115,22,.08) 0%, transparent 60%), radial-gradient(ellipse at 80% 20%, rgba(234,88,12,.05) 0%, transparent 50%); pointer-events:none; }
    </style>
</head>
<body>
<div class="mesh"></div>
<div class="relative min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        @if(session('error'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-green-500/10 border border-green-500/30 text-green-400 text-sm">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</div>
</body>
</html>