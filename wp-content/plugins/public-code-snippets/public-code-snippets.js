// Public Code Snippets Plugin Scripts
(function(){
    function renderSnippets(snippets) {
        // ...existing code for rendering snippets...
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Dark mode toggle
        var darkBtn = document.getElementById('pcs-dark-toggle');
        if (darkBtn) {
            darkBtn.onclick = function() {
                document.body.classList.toggle('pcs-dark-mode');
                localStorage.setItem('pcs-dark', document.body.classList.contains('pcs-dark-mode'));
            };
            if (localStorage.getItem('pcs-dark') === 'true') {
                document.body.classList.add('pcs-dark-mode');
            }
        }
        // Add New Snippet
        var addForm = document.getElementById('pcs-add-form');
        if (addForm) {
            addForm.onsubmit = function(e) {
                e.preventDefault();
                var title = document.getElementById('pcs-add-title').value.trim();
                var lang = document.getElementById('pcs-add-lang').value.trim();
                var code = document.getElementById('pcs-add-code').value.trim();
                if (!title || !lang || !code) return;
                var customSnippets = JSON.parse(localStorage.getItem('pcs-custom-snippets') || '[]');
                customSnippets.push([title, lang, code]);
                localStorage.setItem('pcs-custom-snippets', JSON.stringify(customSnippets));
                document.getElementById('pcs-add-title').value = '';
                document.getElementById('pcs-add-lang').value = '';
                document.getElementById('pcs-add-code').value = '';
                document.getElementById('pcs-form').dispatchEvent(new Event('submit'));
            };
        }
        // Filter by language
        var langFilter = document.getElementById('pcs-lang-filter');
        if (langFilter) {
            langFilter.onchange = function() {
                document.getElementById('pcs-form').dispatchEvent(new Event('submit'));
            };
        }
    });
})();
// Example JS for public-code-snippets plugin
document.addEventListener('DOMContentLoaded', function() {
    const snippets = document.querySelectorAll('.public-code-snippet');
    snippets.forEach(snippet => {
        snippet.addEventListener('click', function() {
            alert('Code snippet clicked!');
        });
    });
});
