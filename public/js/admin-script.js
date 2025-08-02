window.addEventListener('load', function() {
    const loadingElement = document.getElementById('loading');
    loadingElement.classList.add('hidden');
    setTimeout(function() {
        loadingElement.style.display = 'none';
    }, 500); // Geçiş süresi ile aynı olmalı
});