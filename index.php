<?php
// Recopilación de telemetría y datos del servidor en vivo
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Apache/2.4 (Debian)';
$phpVersion = phpversion() ?: '8.2+';
$serverIp = $_SERVER['SERVER_ADDR'] ?? (gethostbyname(gethostname()) ?: '127.0.0.1');
$clientIp = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$hostname = gethostname() ?: 'debian';
$uptimeRaw = @file_get_contents('/proc/uptime');
$systemLoad = function_exists('sys_getloadavg') ? sys_getloadavg()[0] : '0.05';
$docRoot = $_SERVER['DOCUMENT_ROOT'] ?? '/var/www/html';
?>
<!DOCTYPE html>
<html lang="es" class="h-full bg-[#07050f] text-slate-100 antialiased">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Primer Servidor en Apache | StellaLabs</title>

  <!-- Google Fonts: Space Grotesk -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Tailwind CSS por CDN con tokens de diseño StellaLabs -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Space Grotesk"', 'sans-serif'],
            mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'monospace']
          },
          colors: {
            space: {
              950: '#07050f',
              900: '#0d0a1c',
              800: '#16112e',
              700: '#231b45'
            },
            astra: {
              400: '#38bdf8',
              500: '#0ea5e9'
            },
            cosmic: {
              400: '#c084fc',
              500: '#a855f7',
              600: '#9333ea',
              900: '#3b0764'
            }
          }
        }
      }
    }
  </script>
</head>
<body class="relative flex min-h-screen flex-col overflow-x-hidden bg-space-950 font-sans selection:bg-astra-400/20 selection:text-astra-400">

  <!-- Cuadrícula técnica de fondo & Luces difusas -->
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(#38bdf812_1px,transparent_1px)] [background-size:32px_32px]" aria-hidden="true"></div>
  <div class="pointer-events-none absolute -top-32 right-1/4 h-[420px] w-[420px] rounded-full bg-astra-400/10 blur-[130px]" aria-hidden="true"></div>
  <div class="pointer-events-none absolute top-1/2 -left-36 h-[380px] w-[380px] rounded-full bg-cosmic-500/10 blur-[140px]" aria-hidden="true"></div>

  <!-- ========================================================= -->
  <!-- NAVBAR OFICIAL CON ENLACES A STELLALABS.TECH              -->
  <!-- ========================================================= -->
  <header class="sticky top-0 z-50 w-full border-b border-white/10 bg-space-950/75 backdrop-blur-md">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4 md:px-10">
      
      <!-- Isotipo + Logo + Badge Localhost -->
      <div class="flex items-center gap-3">
        <a href="https://stellalabs.tech/" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-2.5 transition-opacity hover:opacity-90">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="h-6 w-6 shrink-0 transition-transform duration-200 group-hover:scale-105" aria-hidden="true">
            <defs>
              <linearGradient id="header-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#38bdf8"></stop>
                <stop offset="100%" stop-color="#1d4ed8"></stop>
              </linearGradient>
              <mask id="header-mask">
                <rect width="100" height="100" fill="white"></rect>
                <path d="M 50 49 Q 50 64 65 64 Q 50 64 50 79 Q 50 64 35 64 Q 50 64 50 49 Z" fill="black"></path>
              </mask>
            </defs>
            <path d="M 40 12 H 60 C 61.5 12 62 13 62 15 C 62 17 61 18 58 18 V 38 L 81.5 76 C 84.5 81 81.5 86 76 86 H 24 C 18.5 86 15.5 81 18.5 76 L 42 38 V 18 C 39 18 38 17 38 15 C 38 13 38.5 12 40 12 Z" fill="url(#header-grad)" mask="url(#header-mask)"></path>
          </svg>

          <span class="text-base font-semibold tracking-tight text-white">
            Stella<span class="text-astra-400">Labs</span>
          </span>
        </a>

        <!-- Badge indicador de entorno local -->
        <span class="rounded-full border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-0.5 font-mono text-[10px] text-emerald-400">
          <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse mr-1"></span> LOCALHOST
        </span>
      </div>

      <!-- Menú Desktop -->
      <nav class="hidden items-center gap-6 text-sm text-gray-400 md:flex">
        <a href="https://stellalabs.tech/herramientas" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Herramientas</a>
        <a href="https://stellalabs.tech/torneos" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Torneos</a>
        <a href="https://stellalabs.tech/guias" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Guías</a>
        <a href="https://stellalabs.tech/guias/linux" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-astra-400/30 bg-astra-400/10 px-3 py-1 text-xs font-mono text-astra-400 transition-colors hover:bg-astra-400/20">
          Ver Guía Linux
        </a>
        <span class="text-white/15">|</span>
        <a href="https://stellalabs.tech/acerca-de" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Acerca de</a>
        <a href="https://stellalabs.tech/contacto" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Contacto</a>
      </nav>

      <!-- Botón Menú Móvil -->
      <button id="mobileMenuBtn" class="rounded-lg border border-white/10 p-2 text-gray-400 hover:text-white md:hidden" aria-label="Abrir menú">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- Menú Desplegable Móvil -->
    <div id="mobileMenu" class="hidden border-b border-white/10 bg-space-950/95 px-6 py-4 md:hidden">
      <div class="flex flex-col space-y-3 text-sm text-gray-300 font-mono text-xs">
        <a href="https://stellalabs.tech/herramientas" target="_blank" rel="noopener noreferrer" class="py-1 hover:text-astra-400">Herramientas</a>
        <a href="https://stellalabs.tech/torneos" target="_blank" rel="noopener noreferrer" class="py-1 hover:text-astra-400">Torneos</a>
        <a href="https://stellalabs.tech/guias" target="_blank" rel="noopener noreferrer" class="py-1 hover:text-astra-400">Guías</a>
        <a href="https://stellalabs.tech/guias/linux" target="_blank" rel="noopener noreferrer" class="text-astra-400 font-semibold py-1">📖 Taller de Linux</a>
        <a href="https://stellalabs.tech/acerca-de" target="_blank" rel="noopener noreferrer" class="py-1 hover:text-astra-400">Acerca de</a>
        <a href="https://stellalabs.tech/contacto" target="_blank" rel="noopener noreferrer" class="py-1 hover:text-astra-400">Contacto</a>
      </div>
    </div>
  </header>

  <!-- ========================================================= -->
  <!-- CONTENIDO PRINCIPAL                                       -->
  <!-- ========================================================= -->
  <main class="relative z-10 flex-grow px-6 py-12 md:px-10 lg:py-16">
    <div class="mx-auto max-w-5xl">
      
      <!-- HERO: ÉXITO EN EL DESPLIEGUE -->
      <div class="text-center sm:text-left">
        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3.5 py-1 text-xs font-mono text-emerald-400">
          <span class="h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
          HTTP STATUS 200 // APACHE ONLINE
        </div>

        <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
          ¡Felicidades! Tu servidor <br class="hidden sm:inline" />
          <span class="bg-gradient-to-r from-astra-400 via-sky-300 to-cosmic-400 bg-clip-text text-transparent">
            Apache está funcionando
          </span>
        </h1>

        <p class="mt-4 max-w-2xl text-sm leading-relaxed text-gray-300 sm:text-base md:text-lg">
          Has desplegado con éxito tu primer entorno web sobre Debian GNU/Linux. Esta página está siendo interpretada por PHP y servida a través del puerto 80.
        </p>
      </div>

      <!-- BENTO GRID: TELEMETRÍA DEL SERVIDOR EN VIVO -->
      <div class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 font-mono text-xs">
        
        <!-- Tarjeta 1: Software -->
        <div class="rounded-2xl border border-white/10 bg-space-900/70 p-5 backdrop-blur-xl">
          <span class="text-gray-500 block uppercase tracking-wider text-[10px]">Web Server</span>
          <p class="mt-1 text-sm font-bold text-white truncate" title="<?php echo htmlspecialchars($serverSoftware); ?>">
            <?php echo htmlspecialchars(explode(' ', $serverSoftware)[0]); ?>
          </p>
          <span class="mt-2 inline-block rounded bg-white/5 px-2 py-0.5 text-[10px] text-gray-400">
            Port: 80 / HTTP
          </span>
        </div>

        <!-- Tarjeta 2: PHP Version -->
        <div class="rounded-2xl border border-white/10 bg-space-900/70 p-5 backdrop-blur-xl">
          <span class="text-gray-500 block uppercase tracking-wider text-[10px]">PHP Runtime</span>
          <p class="mt-1 text-sm font-bold text-astra-400">
            v<?php echo htmlspecialchars($phpVersion); ?>
          </p>
          <span class="mt-2 inline-block rounded bg-astra-400/10 px-2 py-0.5 text-[10px] text-astra-400">
            FPM / Native
          </span>
        </div>

        <!-- Tarjeta 3: IP del Servidor -->
        <div class="rounded-2xl border border-white/10 bg-space-900/70 p-5 backdrop-blur-xl">
          <span class="text-gray-500 block uppercase tracking-wider text-[10px]">Server IP / Host</span>
          <p class="mt-1 text-sm font-bold text-cosmic-400">
            <?php echo htmlspecialchars($serverIp); ?>
          </p>
          <span class="mt-2 inline-block text-[10px] text-gray-400 truncate">
            host: <?php echo htmlspecialchars($hostname); ?>
          </span>
        </div>

        <!-- Tarjeta 4: IP del Cliente -->
        <div class="rounded-2xl border border-white/10 bg-space-900/70 p-5 backdrop-blur-xl">
          <span class="text-gray-500 block uppercase tracking-wider text-[10px]">Tu IP (Cliente)</span>
          <p class="mt-1 text-sm font-bold text-emerald-400">
            <?php echo htmlspecialchars($clientIp); ?>
          </p>
          <span class="mt-2 inline-block text-[10px] text-gray-400">
            load avg: <?php echo htmlspecialchars($systemLoad); ?>
          </span>
        </div>

      </div>

      <!-- DETALLE DE RUTA Y CHEATSHEET DE TERMINAL -->
      <div class="mt-8 overflow-hidden rounded-2xl border border-white/10 bg-space-900/80 shadow-2xl backdrop-blur-xl">
        <!-- Barra de título de la terminal -->
        <div class="flex items-center justify-between border-b border-white/10 bg-space-950/80 px-5 py-3">
          <div class="flex items-center gap-2">
            <span class="h-3 w-3 rounded-full bg-rose-500/80"></span>
            <span class="h-3 w-3 rounded-full bg-amber-500/80"></span>
            <span class="h-3 w-3 rounded-full bg-emerald-500/80"></span>
            <span class="ml-2 font-mono text-xs text-gray-400">terminal@<?php echo htmlspecialchars($hostname); ?>: ~</span>
          </div>
          <span class="font-mono text-[10px] text-gray-500">DocumentRoot: <?php echo htmlspecialchars($docRoot); ?></span>
        </div>

        <!-- Comandos útiles explicados -->
        <div class="p-6 sm:p-8 space-y-6">
          <div>
            <h3 class="text-base font-bold text-white flex items-center gap-2">
              <span class="text-astra-400">📁</span> ¿Dónde está alojado este archivo?
            </h3>
            <p class="mt-1 text-xs text-gray-300 font-mono">
              Ruta física en Debian: <span class="rounded bg-black/60 px-2 py-1 text-astra-400"><?php echo htmlspecialchars($docRoot); ?>/index.php</span>
            </p>
          </div>

          <!-- Comandos rápidos para copiar -->
          <div class="space-y-4 font-mono text-xs">
            <div>
              <span class="text-gray-400">1. Para editar esta página en vivo desde la terminal:</span>
              <div class="mt-1.5 overflow-x-auto rounded-xl border border-white/5 bg-black/70 p-3 text-gray-200">
                <span class="text-astra-400">$</span> nano <?php echo htmlspecialchars($docRoot); ?>/index.php
              </div>
            </div>

            <div>
              <span class="text-gray-400">2. Para ver el registro de peticiones en tiempo real (logs de Apache):</span>
              <div class="mt-1.5 overflow-x-auto rounded-xl border border-white/5 bg-black/70 p-3 text-gray-200">
                <span class="text-astra-400">$</span> sudo tail -f /var/log/apache2/access.log
              </div>
            </div>

            <div>
              <span class="text-gray-400">3. Si realizas cambios en la configuración y necesitas reiniciar el demonio:</span>
              <div class="mt-1.5 overflow-x-auto rounded-xl border border-white/5 bg-black/70 p-3 text-gray-200">
                <span class="text-astra-400">$</span> sudo systemctl restart apache2
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TARJETA CTA HACIA EL TALLER COMPLETO -->
      <div class="mt-10 flex flex-col items-start justify-between gap-6 rounded-2xl border border-astra-400/30 bg-gradient-to-r from-astra-400/10 via-space-900 to-cosmic-500/10 p-6 sm:flex-row sm:items-center sm:p-8">
        <div>
          <span class="font-mono text-xs uppercase tracking-wider text-astra-400">Taller Presencial de Linux</span>
          <h4 class="mt-1 text-lg font-bold text-white">¿Te perdiste en algún paso o quieres continuar?</h4>
          <p class="mt-1 text-xs text-gray-300">Consulta la guía paso a paso con todos los comandos de permisos (chmod/chown), networking y Git.</p>
        </div>

        <a
          href="https://stellalabs.tech/guias/linux"
          target="_blank"
          rel="noopener noreferrer"
          class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-astra-400 px-6 py-3 text-xs font-bold uppercase tracking-wider text-space-950 transition-all hover:bg-sky-300 active:scale-95 shadow-lg shadow-astra-400/20"
        >
          <span>Ir a la Guía Oficial</span>
          <span>→</span>
        </a>
      </div>

    </div>
  </main>

  <!-- ========================================================= -->
  <!-- FOOTER OFICIAL CON ENLACES A STELLALABS.TECH              -->
  <!-- ========================================================= -->
  <footer class="relative z-10 w-full border-t border-white/10 bg-space-950/80 px-6 py-12 backdrop-blur-md md:px-10">
    <div class="mx-auto max-w-7xl">
      <div class="grid grid-cols-1 gap-10 md:grid-cols-12 md:gap-8">
        
        <!-- Marca y Lema -->
        <div class="space-y-4 md:col-span-6 lg:col-span-5">
          <a href="https://stellalabs.tech/" target="_blank" rel="noopener noreferrer" class="group inline-flex items-center gap-2.5 transition-opacity hover:opacity-90">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="h-6 w-6 shrink-0" aria-hidden="true">
              <path d="M 40 12 H 60 C 61.5 12 62 13 62 15 C 62 17 61 18 58 18 V 38 L 81.5 76 C 84.5 81 81.5 86 76 86 H 24 C 18.5 86 15.5 81 18.5 76 L 42 38 V 18 C 39 18 38 17 38 15 C 38 13 38.5 12 40 12 Z" fill="#38bdf8"></path>
            </svg>
            <span class="text-lg font-semibold tracking-tight text-white">
              Stella<span class="text-astra-400">Labs</span>
            </span>
          </a>

          <p class="font-mono text-sm text-astra-400">
            Por y para estudiantes<span class="text-white">.</span>
          </p>

          <p class="max-w-sm text-xs leading-relaxed text-gray-400">
            Laboratorio experimental de software, utilidades y guías técnicas para impulsar a la comunidad estudiantil.
          </p>
        </div>

        <!-- Enlaces: Herramientas -->
        <div class="space-y-3 md:col-span-3 lg:col-span-4">
          <p class="font-mono text-xs uppercase tracking-wider text-gray-300">Herramientas</p>
          <ul class="space-y-2 text-sm text-gray-400">
            <li><a href="https://stellalabs.tech/eventos" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Registro de eventos</a></li>
            <li><a href="https://stellalabs.tech/torneos" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Torneos de videojuegos</a></li>
            <li><a href="https://stellalabs.tech/juegos" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Mini juegos</a></li>
            <li><a href="https://stellalabs.tech/guias" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Catálogo de guías</a></li>
          </ul>
        </div>

        <!-- Enlaces: Navegación -->
        <div class="space-y-3 md:col-span-3 lg:col-span-3">
          <p class="font-mono text-xs uppercase tracking-wider text-gray-300">Sitio Principal</p>
          <ul class="space-y-2 text-sm text-gray-400">
            <li><a href="https://stellalabs.tech/" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Inicio</a></li>
            <li><a href="https://stellalabs.tech/acerca-de" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Acerca de</a></li>
            <li><a href="https://stellalabs.tech/contacto" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-white">Contacto</a></li>
            <li><a href="https://stellalabs.tech/guias/linux" target="_blank" rel="noopener noreferrer" class="text-astra-400 hover:underline">Guía del Taller Linux</a></li>
          </ul>
        </div>
      </div>

      <!-- Barra inferior -->
      <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/5 pt-8 text-xs text-gray-500 sm:flex-row">
        <p>
          Powered by <span class="font-semibold text-white">Stella<span class="text-astra-400">Labs</span></span> — © <?php echo date('Y'); ?>.
        </p>
        <div class="flex items-center gap-2 font-mono text-[11px] text-gray-400">
          <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
          Apache2 / PHP Runtime activo
        </div>
      </div>
    </div>
  </footer>

  <script>
    // Toggle para menú móvil
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileBtn?.addEventListener('click', () => {
      mobileMenu?.classList.toggle('hidden');
    });
  </script>
</body>
</html>
