// Check and apply theme immediately
(function () {
    const theme = localStorage.getItem('app_theme') || 'default';
    const root = document.documentElement;

    if (theme === 'emerald') {
        root.style.setProperty('--primary', '#064e3b');
        root.style.setProperty('--secondary', '#065f46');
        root.style.setProperty('--accent', '#34d399');
        root.style.setProperty('--card-bg', 'rgba(6, 78, 59, 0.8)');
    } else if (theme === 'gold') {
        root.style.setProperty('--primary', '#451a03');
        root.style.setProperty('--secondary', '#78350f');
        root.style.setProperty('--accent', '#fbbf24');
        root.style.setProperty('--card-bg', 'rgba(69, 26, 3, 0.8)');
    } else {
        // Default (Midnight) - no need to set if CSS has defaults, 
        // but resetting ensures clean switch
        root.style.removeProperty('--primary');
        root.style.removeProperty('--secondary');
        root.style.removeProperty('--accent');
        root.style.removeProperty('--card-bg');
    }
})();

function setTheme(themeName) {
    localStorage.setItem('app_theme', themeName);
    location.reload(); // Reload to apply fresh
}
