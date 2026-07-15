<div class="max-w-4xl mx-auto px-6 py-16 mt-6">
  <div class="flex items-center justify-between mb-10">
    <div>
      <h1 class="font-display text-2xl font-extrabold text-gray-900 dark:text-gray-100">Painel Administrativo</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Olá, <?= $_SESSION['auth']->nome ?>!</p>
    </div>
    <a href="/logout"
      class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-semibold py-2 px-4 rounded-lg transition-colors">
      Sair
    </a>
  </div>

  <?php if ($mensagem = flash()->get('mensagem_painel')): ?>
    <!-- Exibe mensagem de sucesso após ações no painel (ex: criar/remover artigo ou comentário) -->
    <div class="mb-6 p-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl">
        <p class="text-emerald-700 dark:text-emerald-400 text-sm font-medium">✅ <?= $mensagem ?></p>
    </div>
  <?php endif; ?>

  <?php if ($validacoes = flash()->get('validacoes_painel')): ?>
    <!-- Exibe erros de validação ao tentar criar um novo ponto turístico -->
    <div class="mb-6 p-3 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 rounded-xl space-y-0.5">
        <?php foreach ($validacoes as $v): ?>
            <p class="text-red-600 dark:text-red-400 text-sm font-medium">⚠️ <?= $v ?></p>
        <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Adicionar novo ponto turístico -->
  <div class="bg-white dark:bg-[rgb(35,35,35)] border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm dark:shadow-black/30 p-6 mb-10">
    <h2 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Adicionar Ponto Turístico</h2>
    <form method="POST" action="/artigo-criar" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Título</label>
            <input type="text" name="titulo" required
                class="w-full p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-[rgb(25,25,25)] text-gray-900 dark:text-gray-100 text-sm outline-none focus:border-emerald-500 transition-colors">
        </div>

        <div>
            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Descrição</label>
            <textarea name="descricao" required
                class="w-full h-24 p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-[rgb(25,25,25)] text-gray-900 dark:text-gray-100 text-sm outline-none focus:border-emerald-500 transition-colors resize-none"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Endereço</label>
                <input type="text" name="endereco"
                    class="w-full p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-[rgb(25,25,25)] text-gray-900 dark:text-gray-100 text-sm outline-none focus:border-emerald-500 transition-colors">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Horário</label>
                <input type="text" name="horario" placeholder="Ex: Diariamente, das 8h às 18h"
                    class="w-full p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-[rgb(25,25,25)] text-gray-900 dark:text-gray-100 text-sm outline-none focus:border-emerald-500 transition-colors">
            </div>
        </div>

        <div>
            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Link (opcional)</label>
            <input type="url" name="link" placeholder="https://..."
                class="w-full p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-[rgb(25,25,25)] text-gray-900 dark:text-gray-100 text-sm outline-none focus:border-emerald-500 transition-colors">
        </div>

        <div>
            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Foto</label>
            <input type="file" name="img" accept="image/*"
                class="w-full text-sm text-gray-600 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 dark:file:bg-emerald-900/40 file:text-emerald-700 dark:file:text-emerald-400 file:text-sm file:font-semibold hover:file:bg-emerald-100 dark:hover:file:bg-emerald-900/60 file:cursor-pointer cursor-pointer">
        </div>

        <button type="submit"
            class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2.5 px-6 rounded-lg transition-colors text-sm uppercase tracking-wider">
            Adicionar
        </button>
    </form>
  </div>

  <!-- Lista de pontos turísticos -->
  <div class="mb-10">
    <h2 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Pontos Turísticos Cadastrados</h2>
    <div class="space-y-3">
        <?php if (empty($artigos)): ?>
            <!-- Nenhum ponto turístico cadastrado ainda -->
            <p class="text-gray-500 dark:text-gray-400 text-sm">Nenhum ponto turístico cadastrado ainda.</p>
        <?php else: ?>
            <?php foreach ($artigos as $artigo): ?>
                <!-- Exibe cada ponto turístico com botão para remover (confirmação via JS antes de enviar) -->
                <div class="bg-white dark:bg-[rgb(35,35,35)] border border-gray-100 dark:border-gray-700 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-gray-100 text-sm"><?= $artigo->titulo ?></p>
                        <p class="text-gray-500 dark:text-gray-400 text-xs mt-0.5"><?= $artigo->dataPublicacao ?></p>
                    </div>
                    <form method="POST" action="/artigo-deletar" onsubmit="return confirm('Remover este ponto turístico?');">
                        <input type="hidden" name="id" value="<?= $artigo->id ?>">
                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-xs font-semibold">Remover</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
  </div>

  <!-- Lista de comentários -->
  <div>
    <h2 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Comentários</h2>
    <div class="space-y-3">
        <?php if (empty($comentarios)): ?>
            <!-- Nenhum comentário cadastrado ainda -->
            <p class="text-gray-500 dark:text-gray-400 text-sm">Nenhum comentário ainda.</p>
        <?php else: ?>
            <?php foreach ($comentarios as $comentario): ?>
                <!-- Exibe cada comentário com botão para remover (confirmação via JS antes de enviar) -->
                <div class="bg-white dark:bg-[rgb(35,35,35)] border border-gray-100 dark:border-gray-700 rounded-xl p-4 flex items-start justify-between gap-4">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-gray-100 text-sm"><?= $comentario->nome ?></p>
                        <p class="text-gray-500 dark:text-gray-400 text-xs mt-0.5"><?= $comentario->comentario ?></p>
                    </div>
                    <form method="POST" action="/comentario-deletar" onsubmit="return confirm('Remover este comentário?');">
                        <input type="hidden" name="id" value="<?= $comentario->id ?>">
                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-xs font-semibold whitespace-nowrap">Remover</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
  </div>
</div>