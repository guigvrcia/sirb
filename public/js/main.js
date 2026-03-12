(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();

document.addEventListener('DOMContentLoaded', () => {
  const inp = document.getElementById('ajaxSearch');
  const out = document.getElementById('ajaxResults');
  if (!inp || !out) return;

  let t = null;
  inp.addEventListener('input', () => {
    const q = inp.value.trim();
    clearTimeout(t);
    t = setTimeout(async () => {
      if (q.length < 2) {
        out.textContent = 'Digite ao menos 2 caracteres...';
        return;
      }
      try {
        const resp = await fetch(`/sirb/private/ajax_buscar_itens.php?q=${encodeURIComponent(q)}`);
        const json = await resp.json();
        if (!json.ok) throw new Error('Erro');
        if (json.data.length === 0) {
          out.textContent = 'Nenhum item encontrado.';
          return;
        }
        out.innerHTML = json.data
          .map(i => `#${i.id} - ${i.nome} (R$ ${Number(i.preco).toFixed(2)})`)
          .join('<br>');
      } catch (e) {
        out.textContent = 'Falha na busca AJAX.';
      }
    }, 250);
  });
});