// Troca a foto principal quando o usuário clica numa miniatura da galeria
document.addEventListener('DOMContentLoaded', () => {
  const fotoPrincipal = document.getElementById('foto-principal');
  const miniaturas = document.querySelectorAll('[data-galeria-thumb]');

  if (!fotoPrincipal || !miniaturas.length) return;

  miniaturas.forEach((thumb) => {
    thumb.addEventListener('click', () => {
      fotoPrincipal.src = thumb.src;
    });
  });
});
