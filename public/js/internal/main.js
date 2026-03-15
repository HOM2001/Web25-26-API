// On utilise window. pour garantir que le onclick du PHP trouve la fonction
let visibleCount = 2; // On commence avec 2 articles visibles

window.showMore = function() {
    const items = document.querySelectorAll('.section-sidebar > div');
    const btnMore = document.getElementById('btn-more');
    const btnLess = document.getElementById('btn-less');

    // On augmente de 2
    visibleCount += 2;

    // On affiche les articles jusqu'à visibleCount (max 6)
    items.forEach((item, index) => {
        if (index < visibleCount && index < 7) {
            item.style.display = 'block';
        }
    });

    // Gestion des boutons
    if (visibleCount >= 6 || visibleCount >= items.length) {
        btnMore.style.display = 'none';
        btnLess.style.display = 'block';
    }
};

window.showLess = function() {
    const items = document.querySelectorAll('.section-sidebar > div');
    const btnMore = document.getElementById('btn-more');
    const btnLess = document.getElementById('btn-less');

    // On revient à 2
    visibleCount = 3;

    // On cache tout à partir du 3ème article (index 2)
    items.forEach((item, index) => {
        if (index >= visibleCount ) {
            item.style.display = 'none';
        }
    });

    // On remet les boutons dans l'état initial
    btnMore.style.display = 'block';
    btnLess.style.display = 'none';
};