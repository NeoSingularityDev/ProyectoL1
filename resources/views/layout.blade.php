<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Escolar')</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <nav class="bg-slate-900 text-white shadow-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="/alumnos" class="text-xl font-bold tracking-wide">
                Sistema Escolar
            </a>
            <div class="flex items-center gap-6 text-sm">
                <a href="/" class="text-slate-300 hover:text-white">
                    Inicio
                </a>
                <a href="/alumnos" class="font-semibold text-white">
                    Alumnos
                </a>
                <a href="/profesores" class="font-semibold text-white">
                    Profesores
                </a>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-6 py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>