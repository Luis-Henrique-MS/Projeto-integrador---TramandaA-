<div class="min-h-screen w-full bg-[rgb(250,250,248)] dark:bg-[rgb(17,17,17)] flex items-center justify-center px-6 py-12 transition-colors">
  <div class="w-full max-w-sm">

    <div class="text-center mb-8">
      <span class="font-display text-2xl text-gray-900 dark:text-gray-100 font-extrabold">TramandaAí</span>
      <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Acesso administrativo</p>
    </div>

    <div class="bg-white dark:bg-[rgb(30,30,30)] border border-gray-100 dark:border-[rgb(50,50,50)] rounded-2xl shadow-md dark:shadow-black/30 p-6 transition-colors">

      <?php if ($mensagem = flash()->get('mensagem')): ?>
        <!-- Exibe mensagem de sucesso vinda da sessão (ex: após logout ou erro anterior) -->
        <div class="mb-4 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl">
          <p class="text-emerald-700 dark:text-emerald-400 text-xs font-medium">✅ <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
      <?php endif; ?>

      <?php if ($validacoes = flash()->get('validacoes_login')): ?>
        <!-- Exibe as mensagens de erro de validação do login (ex: e-mail/senha incorretos) -->
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl space-y-0.5">
          <?php foreach ($validacoes as $v): ?>
            <p class="text-red-600 dark:text-red-400 text-xs font-medium">⚠️ <?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="/login" class="space-y-4">
        <div>
          <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">E-mail</label>
          <input type="email" name="email" required placeholder="admin@tramandai.com"
            class="w-full p-2.5 rounded-lg border border-gray-200 dark:border-[rgb(50,50,50)] bg-white dark:bg-[rgb(30,30,30)] text-gray-900 dark:text-gray-100 dark:placeholder-gray-500 text-sm outline-none focus:border-emerald-500 transition-colors">
        </div>

        <div>
          <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Senha</label>
          <input type="password" name="senha" required placeholder="••••••••"
            class="w-full p-2.5 rounded-lg border border-gray-200 dark:border-[rgb(50,50,50)] bg-white dark:bg-[rgb(30,30,30)] text-gray-900 dark:text-gray-100 dark:placeholder-gray-500 text-sm outline-none focus:border-emerald-500 transition-colors">
        </div>

        <button type="submit"
          class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2.5 rounded-lg transition-colors text-sm uppercase tracking-wider">
          Entrar
        </button>
      </form>
    </div>

    <a href="/" class="block text-center text-sm text-gray-500 dark:text-gray-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors mt-6">
      ← Voltar para o site
    </a>
  </div>
</div>