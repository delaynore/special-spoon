var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

const themeItemName = 'pradict-preferred-theme';

// Change the icons inside the button based on previous settings
if (localStorage.getItem(themeItemName) === 'dark' || (!(themeItemName in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIcon.classList.remove('hidden');
} else {
    themeToggleDarkIcon.classList.remove('hidden');
}


var themeToggleBtn = document.getElementById('theme-toggle');

themeToggleBtn.addEventListener('click', function() {

    // toggle icons inside button
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');

    // if set via local storage previously
    if (localStorage.getItem(themeItemName)) {
        if (localStorage.getItem(themeItemName) === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem(themeItemName, 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem(themeItemName, 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem(themeItemName, 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem(themeItemName, 'dark');
        }
    }

});
