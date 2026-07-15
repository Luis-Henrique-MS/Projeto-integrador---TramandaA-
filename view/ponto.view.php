<div class="max-w-6xl mx-auto px-6 py-12 mt-20">

    <a href="/" class="inline-flex items-center gap-2 text-emerald-700 dark:text-emerald-400 hover:text-emerald-900 dark:hover:text-emerald-300 text-sm font-medium mb-6">
        ← Voltar para os destinos
    </a>

    <!-- Foto principal -->
    <div class="mb-10">
        <div class="h-[420px] w-full">
            <img id="foto-principal" src="<?= $ponto->img ?? '' ?>" alt="<?= $ponto->titulo ?>"
                class="h-full md:h-full w-10/12 object-cover rounded-2xl shadow-md dark:shadow-black/30">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        <!-- Descrição -->
        <div class="md:col-span-2">
            <h1 class="font-display text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-gray-100 mb-4"><?= $ponto->titulo ?></h1>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-[16px]"><?= $ponto->descricao ?></p>
        </div>

        <!-- Infos práticas -->
        <aside class="bg-white dark:bg-[rgb(35,35,35)] rounded-2xl shadow-md dark:shadow-black/30 p-6 h-fit space-y-5">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400 mb-1">Endereço</h3>
                <p class="text-gray-700 dark:text-gray-300 text-sm"><?= $ponto->endereco ?? 'Não informado' ?></p>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400 mb-1">Horário de Funcionamento</h3>
                <p class="text-gray-700 dark:text-gray-300 text-sm"><?= $ponto->horario ?? 'Aberto 24h / acesso livre' ?></p>
            </div>

            <?php if (!empty($ponto->endereco)): ?>
                <!-- Só exibe o mapa embutido se o ponto turístico tiver um endereço cadastrado -->
                <div class="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    <iframe src="https://www.google.com/maps?q=<?= urlencode($ponto->endereco) ?>&output=embed"
                        class="w-full h-40 border-0" loading="lazy"></iframe>
                </div>
            <?php endif; ?>
        </aside>
    </div>

    <!-- Comentários -->
    <div class="mt-16 max-w-4xl">
        <h2 class="font-display text-2xl font-extrabold text-gray-900 dark:text-gray-100 mb-6">Comentários</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Lista de comentários -->
            <div class="space-y-4">
                <?php if (empty($comentarios)): ?>
                    <!-- Se ainda não há comentários, exibe mensagem incentivando o primeiro comentário -->
                    <p class="text-gray-500 dark:text-gray-400 text-sm italic bg-white dark:bg-[rgb(35,35,35)] border border-gray-100 dark:border-gray-700 p-4 rounded-xl">
                        Nenhum comentário ainda. Seja o primeiro a comentar sobre este lugar!
                    </p>
                <?php else: ?>
                    <?php foreach ($comentarios as $c): ?>
                        <!-- Renderiza cada comentário com nome, nota em estrelas, texto e foto (se houver) -->
                        <div class="bg-white dark:bg-[rgb(35,35,35)] border border-gray-100 dark:border-gray-700 rounded-xl p-4 shadow-sm dark:shadow-black/30">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-emerald-700 dark:text-emerald-400 font-semibold text-sm"><?= $c->nome ?></span>
                                <?php if (!empty($c->nota)): ?>
                                    <!-- Monta a nota em estrelas: preenchidas + vazias até completar 5 -->
                                    <div class="text-amber-500 text-xs">
                                        <?= str_repeat('★', (int) $c->nota) ?><span class="text-gray-300 dark:text-gray-600"><?= str_repeat('★', 5 - (int) $c->nota) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed"><?= $c->comentario ?></p>
                            <?php if (!empty($c->foto)): ?>
                                <!-- Exibe a foto enviada junto do comentário, se houver -->
                                <img src="<?= $c->foto ?>" alt="Foto enviada por <?= $c->nome ?>"
                                    class="mt-3 w-full max-w-xs h-40 object-cover rounded-lg">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Formulário de novo comentário -->
            <div class="bg-white dark:bg-[rgb(35,35,35)] border border-gray-100 dark:border-gray-700 rounded-xl p-6 shadow-sm dark:shadow-black/30 h-fit">
                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Deixe seu comentário</h3>

                <?php if ($validacoes = flash()->get('validacoes')): ?>
                    <!-- Exibe erros de validação do formulário de comentário (nome/comentário inválidos) -->
                    <div class="p-3 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 rounded-xl mb-4 space-y-0.5">
                        <?php foreach ($validacoes as $validacao): ?>
                            <p class="text-red-600 dark:text-red-400 text-xs font-medium">⚠️ <?= $validacao ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($mensagem = flash()->get('mensagem')): ?>
                    <!-- Exibe mensagem de sucesso após o envio do comentário -->
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-700 dark:text-emerald-400 text-xs font-medium mb-4">
                        ✅ <?= $mensagem ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/comentario-criar" enctype="multipart/form-data" class="space-y-4">
                    <input type="hidden" name="ponto_id" value="<?= $ponto->id ?>">

                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Seu nome</label>
                        <input type="text" name="nome" required
                            class="w-full p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-[rgb(25,25,25)] text-gray-900 dark:text-gray-100 text-sm outline-none focus:border-emerald-500 transition-colors">
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Comentário</label>
                        <textarea name="comentario" required placeholder="Conte como foi sua visita..."
                            class="w-full h-24 p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-[rgb(25,25,25)] text-gray-900 dark:text-gray-100 text-sm outline-none focus:border-emerald-500 transition-colors resize-none"></textarea>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">
                            Foto (opcional)
                        </label>
                        <input type="file" name="foto" accept="image/*"
                            class="w-full text-sm text-gray-600 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 dark:file:bg-emerald-900/40 file:text-emerald-700 dark:file:text-emerald-400 file:text-sm file:font-semibold hover:file:bg-emerald-100 dark:hover:file:bg-emerald-900/60 file:cursor-pointer cursor-pointer">
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Nota</label>
                        <select name="nota"
                            class="w-full p-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-[rgb(25,25,25)] text-gray-900 dark:text-gray-100 text-sm outline-none focus:border-emerald-500 transition-colors">
                            <option value="5">⭐⭐⭐⭐⭐ Excelente</option>
                            <option value="4">⭐⭐⭐⭐ Muito bom</option>
                            <option value="3">⭐⭐⭐ Mediano</option>
                            <option value="2">⭐⭐ Ruim</option>
                            <option value="1">⭐ Péssimo</option>
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2.5 rounded-lg transition-colors text-sm uppercase tracking-wider">
                        Publicar Comentário
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>