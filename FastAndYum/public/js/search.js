document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('input', async (e) => {
        const query = e.target.value.trim();

        if (query.length === 0) {
            searchResults.style.display = 'none';
            searchResults.innerHTML = '';
            return;
        }

        try {
            const response = await fetch(`index.php?page=search&q=${encodeURIComponent(query)}`);
            const results = await response.json();

            searchResults.innerHTML = '';
            if (results.length > 0) {
                results.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'result-item';
                    div.innerHTML = `
                        <a href="index.php?page=details&plat_id=${item.plat_id}">
                            <strong>${item.titre}</strong><br>
                        </a>
                    `;
                    searchResults.appendChild(div);
                });
                searchResults.style.display = 'block';
            } else {
                searchResults.innerHTML = '<div class="result-item">Aucun résultat trouvé</div>';
                searchResults.style.display = 'block';
            }
        } catch (error) {
            console.error('Erreur lors de la recherche:', error);
            searchResults.innerHTML = '<div class="result-item">Erreur de recherche</div>';
            searchResults.style.display = 'block';
        }
    });

    // Hide results when clicking outside
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
});