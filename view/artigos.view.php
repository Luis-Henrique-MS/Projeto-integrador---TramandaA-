<main id="destinos" class="max-w-6xl mx-auto px-6 py-16">
    <h2 class="font-display text-center mb-12 text-gray-900 dark:text-gray-100 font-extrabold text-[24px]">Pontos Turísticos</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php foreach ($artigos as $ponto): ?>
            <?php $img = $ponto->img ?? '/view/img/Praia.jpg'; ?>
            <!-- Percorre cada artigo/ponto turístico e monta um card com link para a página de detalhes -->
            <a href="ponto?id=<?= $ponto->id ?>" class="block">
                <article class="rounded-2xl overflow-hidden bg-white dark:bg-[rgb(35,35,35)] shadow-md dark:shadow-black/30 transition-transform transform hover:-translate-y-2 hover:shadow-2xl">
                    <div class="w-full h-56">
                        <img class="w-full h-full object-cover" loading="lazy" src="<?= $img ?>" alt="<?= $ponto->titulo ?>">
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-[19px] text-gray-900 dark:text-gray-100"><?= $ponto->titulo ?></h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-400"><?= $ponto->descricao ?></p>
                    </div>
                </article>
            </a>
        <?php endforeach; ?>

    </div>
</main>