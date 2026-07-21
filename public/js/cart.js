function addToCart(productId, quantity = 1) {

    if (!window.cartAddUrl) {
        console.error('cartAddUrl non definita');
        return Promise.resolve(); 
    }

    return fetch(window.cartAddUrl, {  
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json", 
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {
            loadCartCount();
            showToast(data.message, 'success');
        } else {
            showToast(data.message || "Errore", 'error');
        }

        return data; 
    })
    .catch(error => {
        console.error('Errore AJAX:', error);
    });
}



function showCartMessage(message) {

    let box = document.getElementById('cartMessage');

    if (!box) {
        alert(message);
        return;
    }

    box.innerText = message;
    box.style.display = 'block';

    setTimeout(() => {
        box.style.display = 'none';
    }, 2000);
}

function loadCartCount() {

    if (!window.cartCountUrl) return;

    fetch(window.cartCountUrl, {
        headers: {
            "Accept": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        const counters = document.querySelectorAll('.cartCount');
        counters.forEach(function(counter) {
            counter.innerHTML = data.count;
        });
    })
    .catch(() => {
        const counters = document.querySelectorAll('.cartCount');
        counters.forEach(function(counter) {
            counter.innerHTML = "0";
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    loadCartCount();
});

function getCsrfToken() {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

function updateCartItem(itemId, quantity) {
    if (!window.cartUpdateUrl) return;
    var qty = parseInt(quantity, 10);
    if (isNaN(qty) || qty < 1) qty = 1;

    fetch(window.cartUpdateUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ item_id: parseInt(itemId, 10), quantity: qty })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            if (typeof window.refreshMiniCart === 'function') window.refreshMiniCart();
            loadCartCount();
        } else if (data.message) {
            showToast(data.message, 'error');
        }
    })
    .catch(function() {});
}

function removeCartItem(itemId) {
    if (!window.cartRemoveUrl) return Promise.resolve();

    return fetch(window.cartRemoveUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ item_id: parseInt(itemId, 10) })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            if (typeof window.refreshMiniCart === 'function') window.refreshMiniCart();
            loadCartCount();
        }
    })
    .catch(function() {});
}

document.addEventListener('click', function(e) {

    const btn = e.target.closest('.add-to-cart-btn');
    if (!btn) return;
	
    const productId = btn.dataset.id;
	
    if (!productId) return;
    // 🔵 attiva loading
    btn.classList.add('loading');

    addToCart(productId)
        .finally(() => {
            // 🔵 rimuove loading quando termina
            btn.classList.remove('loading');
        });

});

//
//ESEMPI DI UTILIZZO
//showToast("Prodotto inserito nel carrello", "success");
//showToast("Stock insufficiente", "warning");
//showToast("Errore di sistema", "error");
//showToast("Devi effettuare il login", "info");
//
function showToast(message, type = 'success', duration = 3000) {

    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <span>${message}</span>
        <span class="toast-close">&times;</span>
    `;

    container.appendChild(toast);

    // Trigger animazione
    setTimeout(() => toast.classList.add('show'), 10);

    // Auto remove
    const removeToast = () => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    };

    setTimeout(removeToast, duration);

    toast.querySelector('.toast-close')
         .addEventListener('click', removeToast);
}
