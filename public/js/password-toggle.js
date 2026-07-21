(function () {
    function getLabels() {
        return {
            show: window.passwordToggleShow || 'Show password',
            hide: window.passwordToggleHide || 'Hide password',
        };
    }

    function enhancePasswordInput(input) {
        if (!input || input.type !== 'password' || input.closest('.password-field-wrap')) {
            return;
        }

        var wrap = document.createElement('div');
        wrap.className = 'password-field-wrap';

        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);

        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'password-toggle-btn';
        button.setAttribute('aria-pressed', 'false');

        var labels = getLabels();
        button.setAttribute('aria-label', labels.show);
        button.innerHTML = '<i class="fa-regular fa-eye" aria-hidden="true"></i>';

        button.addEventListener('click', function () {
            var isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            button.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
            button.setAttribute('aria-label', isHidden ? labels.hide : labels.show);
            button.innerHTML = isHidden
                ? '<i class="fa-regular fa-eye-slash" aria-hidden="true"></i>'
                : '<i class="fa-regular fa-eye" aria-hidden="true"></i>';
        });

        wrap.appendChild(button);
    }

    function initPasswordToggles(root) {
        (root || document).querySelectorAll('input[type="password"]').forEach(enhancePasswordInput);
    }

    document.addEventListener('DOMContentLoaded', function () {
        initPasswordToggles();
    });

    window.initPasswordToggles = initPasswordToggles;
})();
