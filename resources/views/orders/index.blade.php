<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>卓番号 {{ $table->table_number }} - ご注文画面</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>卓番号: {{ $table->table_number }} 番席</h2>
        <span class="badge bg-primary fs-6">ご注文画面</span>
    </div>

    <div class="row">
        <!-- メニュー表示エリア -->
        <div class="col-md-8">
            <!-- カテゴリ切り替えタブ -->
            <ul class="nav nav-pills mb-3" id="category-tabs" role="tablist">
                @foreach ($menus as $category =>$categoryMenus)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($loop->first) active @endif" 
                                id="tab-{{ $loop->index }}" 
                                data-bs-toggle="pill" 
                                data-bs-target="#category-{{ $loop->index }}" 
                                type="button" role="tab">
                            {{ $category }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <!-- カテゴリ別メニュー表示 -->
            <div class="tab-content" id="category-tabContent">
                @foreach ($menus as $category =>$categoryMenus)
                    <div class="tab-pane fade @if($loop->first) show active @endif" 
                         id="category-{{ $loop->index }}" 
                         role="tabpanel">
                        <div class="row row-cols-1 row-cols-md-3 g-3">
                            @foreach ($categoryMenus as $menu)
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        @if($menu->image_url)
                                            <img src="{{ asset('/' . $menu->image_url) }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 140px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 140px;">
                                                NO IMAGE
                                            </div>
                                        @endif
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title fs-6">{{ $menu->name }}</h5>
                                            <p class="card-text text-danger fw-bold fs-5 mb-3">¥{{ number_format($menu->price) }}</p>
                                            <button class="btn btn-outline-primary mt-auto w-100" onclick="addToCart({{ $menu->id }}, '{{ $menu->name }}', {{$menu->price }})">
                                                追加
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 簡易カート表示エリア -->
        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">現在の注文リスト</h5>
                </div>
                <div class="card-body">
                    <ul id="cart-list" class="list-group mb-3">
                        <li class="list-group-item text-muted text-center">商品が選択されていません</li>
                    </ul>
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                        <span>合計金額:</span>
                        <span>¥<span id="cart-total">0</span></span>
                    </div>
                    <button class="btn btn-success w-100 btn-lg" id="order-btn" data-table-id="{{ $table->id }}" disabled>
                        注文を確定する
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let cart = [];

// カートに追加
function addToCart(id, name, price) {
    const existing = cart.find(item => item.id === id);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({ id, name, price, quantity: 1 });
    }
    updateCartUI();
}

// 数量変更（プラス / マイナス）
function changeQuantity(id, delta) {
    const item = cart.find(item => item.id === id);
    if (!item) return;

    item.quantity += delta;
    if (item.quantity <= 0) {
        removeFromCart(id);
    } else {
        updateCartUI();
    }
}

// カートから削除
function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    updateCartUI();
}

// カートUIの更新
function updateCartUI() {
    const cartList = document.getElementById('cart-list');
    const cartTotal = document.getElementById('cart-total');
    const orderBtn = document.getElementById('order-btn');

    if (cart.length === 0) {
        cartList.innerHTML = '<li class="list-group-item text-muted text-center">商品が選択されていません</li>';
        cartTotal.textContent = '0';
        orderBtn.disabled = true;
        return;
    }

    let html = '';
    let total = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        html += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <div><strong>${item.name}</strong></div>
                    <small class="text-muted">¥${item.price.toLocaleString()}</small>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <button class="btn btn-sm btn-outline-secondary px-2" onclick="changeQuantity(${item.id}, -1)">-</button>
                    <span class="fw-bold px-1">${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary px-2" onclick="changeQuantity(${item.id}, 1)">+</button>
                    <button class="btn btn-sm btn-outline-danger ms-1 px-2" onclick="removeFromCart(${item.id})">×</button>
                </div>
            </li>
        `;
    });

    cartList.innerHTML = html;
    cartTotal.textContent = total.toLocaleString();
    orderBtn.disabled = false;
}

// 注文確定処理
document.getElementById('order-btn').addEventListener('click', function() {
    if (cart.length === 0) return;

    if (!confirm('注文を確定してもよろしいですか？')) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('order.store', $table->id) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            items: cart.map(item => ({
                id: item.id,
                quantity: item.quantity
            }))
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            cart = [];
            updateCartUI();
        } else {
            alert(data.message || 'エラーが発生しました');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('通信エラーが発生しました。');
    });
});
</script>
</body>
</html>