<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TramandaAí — Guia Turístico de Tramandaí, RS</title>
  <link rel="shortcut icon" href="/view/images/logo.png" type="image/png">
  <meta name="description"
    content="Guia turístico de Tramandaí, RS: praia, plataforma marítima, Ponta da Barra, Parque Histórico Marechal Osório e as melhores dicas para sua viagem ao litoral norte gaúcho.">

  <link rel="stylesheet" href="/view/css/style.css">

  <!-- Aplica o tema ANTES da página renderizar, pra não piscar claro->escuro -->
  <script>
    (function () {
      const salvo = localStorage.getItem('tema');
      const prefereEscuro = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const deveEscurecer = salvo ? salvo === 'dark' : prefereEscuro;
      if (deveEscurecer) document.documentElement.classList.add('dark');
    })();
  </script>

  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
</head>

<body data-template-id="__page-root" class="w-full min-h-screen bg-[rgb(250,250,248)] dark:bg-[rgb(20,20,20)] flex flex-col transition-colors">
  <?php if ($view != 'login'): ?>
    <!-- Barra de navegação: exibida em todas as páginas, exceto na tela de login -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-[rgb(30,30,30)]/80 border-b border-gray-100 dark:border-gray-800 shadow-sm backdrop-blur-md transition-colors">
      <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between">
        <a href="/" class="font-display text-[16px] text-gray-900 dark:text-gray-100 font-extrabold">TramandaAí</a>
        <div class="flex items-center gap-2 md:gap-6 text-sm font-medium">
          <a href="/#destinos" class="text-gray-700 dark:text-gray-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors mx-2 md:mx-4">Pontos
            Turísticos</a>
          <a href="/#dicas" class="text-gray-700 dark:text-gray-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors mx-2 md:mx-4">Dicas</a>
          <?php if (isset($_SESSION['auth'])): ?>
            <!-- Usuário logado: mostra link do painel e opção de sair -->
            <li><a href="/painel" class="text-gray-700 dark:text-gray-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors mx-2 md:mx-4">Painel</a></li>
            <li><a href="/logout" class="text-gray-700 dark:text-gray-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors mx-2 md:mx-4">Sair, <?= $_SESSION['auth']->nome ?></a></li>
          <?php else: ?>
            <!-- Visitante não logado: mostra link para acesso administrativo -->
            <li><a href="/login" class="text-gray-700 dark:text-gray-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors mx-2 md:mx-4">Entrar/ADM</a></li>
          <?php endif; ?>

          <button id="botao-tema" type="button" aria-label="Alternar modo escuro"
            class="ml-2 w-9 h-9 flex items-center justify-center rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <i data-lucide="sun" class="w-[18px] h-[18px] hidden dark:block"></i>
            <i data-lucide="moon" class="w-[18px] h-[18px] block dark:hidden"></i>
          </button>
        </div>
      </div>
    </nav>
  <?php endif; ?>

  <?php if ($view === 'index'): ?>
    <!-- Cabeçalho com vídeo de fundo, exibido apenas na página inicial -->
    <header class="relative overflow-hidden w-full md:h-[80vh]">
      <video id="hero-video" class="absolute inset-0 w-full h-full object-cover"
        src="/view/videos/HOME ATUALIZADA.mp4" autoplay muted loop playsinline>
      </video>
      <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/30 to-black/10"></div>

      <div class="relative z-10 flex flex-col justify-center h-full mb-6 px-6 md:px-0 mt-28">
        <div class="relative w-64 sm:w-80 md:w-[28rem] lg:w-[34rem] mx-auto md:mx-0 md:ml-24">
          <img class="w-full h-auto" src="/view/images/tramanda_logo.png" alt="TramandaAí">
        </div>
      </div>
    </header>
  <?php endif; ?>

  <main class="flex-1">
    <?php require "view/{$view}.view.php"; ?>
    <!-- Inclui a view específica da página atual (definida pela variável $view) -->
  </main>

  <?php if ($view != 'login'): ?>
    <!-- Rodapé: exibido em todas as páginas, exceto na tela de login -->
    <footer class="text-center py-10 bg-[rgb(26,26,26)] dark:bg-black transition-colors">
      <p class="text-sm text-gray-400">© 2026 TramandaAí — Explore, descubra, viva.</p>
    </footer>
  <?php endif; ?>

  <script src="/view/js/icons.js"></script>
  <script src="/view/js/galeria.js"></script>
  <script>
    document.getElementById('botao-tema')?.addEventListener('click', function () {
      const html = document.documentElement;
      const escuroAgora = html.classList.toggle('dark');
      localStorage.setItem('tema', escuroAgora ? 'dark' : 'light');
      if (window.lucide) lucide.createIcons();
    });
  </script>
</body>

</html>