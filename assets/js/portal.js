/**
 * VOSTOKPRIBOR AI • Portal Tailwind Configuration & Search Engine
 */

tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                background: "#00142a",
                surface: "#00142a",
                "surface-container-lowest": "#000f21",
                "surface-container-low": "#021c36",
                "surface-container": "#06203a",
                "surface-container-high": "#132b45",
                "surface-container-highest": "#1f3651",
                primary: "#b4c8e3",
                secondary: "#abc9f2",
                tertiary: "#ffb956",
                "tertiary-container": "#331e00",
                error: "#ffb4ab",
                "error-container": "#93000a",
                outline: "#8e9197",
                "outline-variant": "#43474c",
                "on-surface": "#d3e4ff",
                "on-surface-variant": "#c4c6cd"
            }
        }
    }
};

// Portal real-time search filter
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('system-search');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('#systems-grid > div').forEach(card => {
                const text = card.textContent.toLowerCase() + ' ' + (card.getAttribute('data-keywords') || '');
                card.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }
});
