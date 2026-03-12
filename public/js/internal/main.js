function showMore() {
    // On sélectionne tous les conteneurs de la sidebar
    const items = document.querySelectorAll('.section-sidebar > div');

    let hiddenItems = Array.from(items).filter(item => item.style.display === 'none' || window.getComputedStyle(item).display === 'none');

    // Affiche les 2 prochains
    for (let i = 0; i < 2 && i < hiddenItems.length; i++) {
        hiddenItems[i].style.display = 'block';
    }

    // Cache le bouton si il n'y a plus rien à montrer
    if (hiddenItems.length <= 2) {
        document.getElementById('btn-more').style.display = 'none';
    }
}