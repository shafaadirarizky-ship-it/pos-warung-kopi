<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-main: #0c0b0e;
            --bg-surface: #17161b;
            --bg-card: #1f1e24;
            --bg-card-hover: #27252f;
            --primary: #e67e22;
            --primary-hover: #d35400;
            --primary-light: rgba(230, 126, 34, 0.15);
            --secondary: #3b82f6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --text-main: #f9fafb;
            --text-muted: #9ca3af;
            --text-dim: #6b7280;
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(230, 126, 34, 0.4);
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --shadow-subtle: 0 8px 32px rgba(0, 0, 0, 0.35);
            --shadow-glow: 0 0 24px rgba(230, 126, 34, 0.25);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(230, 126, 34, 0.06) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(211, 84, 0, 0.05) 0%, transparent 40%);
        }

        /* Top Navigation Bar */
        .navbar {
            background-color: rgba(23, 22, 27, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #e67e22, #d35400);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            box-shadow: 0 4px 14px rgba(230, 126, 34, 0.4);
        }

        .brand-text h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .brand-text span {
            font-size: 0.75rem;
            color: var(--primary);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .badge-btn {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .badge-btn:hover {
            border-color: var(--primary);
            background-color: var(--bg-card-hover);
            transform: translateY(-1px);
        }

        .badge-btn.primary {
            background-color: var(--primary-light);
            color: var(--primary);
            border-color: rgba(230, 126, 34, 0.3);
        }

        .cashier-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 999px;
            border: 1px solid var(--border-color);
        }

        .cashier-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .cashier-name {
            font-size: 0.82rem;
            font-weight: 600;
        }

        .live-clock {
            font-family: 'Space Mono', monospace;
            font-size: 0.85rem;
            color: var(--text-muted);
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            background: rgba(0, 0, 0, 0.3);
        }

        /* Main Workspace Container (Dual-Pane) */
        .pos-container {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 430px;
            height: calc(100vh - 69px);
            overflow: hidden;
        }

        /* Left Pane: Catalog & Menus */
        .menu-pane {
            display: flex;
            flex-direction: column;
            overflow-y: hidden;
            padding: 20px 24px;
            gap: 16px;
        }

        .menu-top-bar {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 240px;
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            font-size: 0.95rem;
        }

        .search-box input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            color: var(--text-main);
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.15);
        }

        /* Category Filter Pills */
        .categories-filter {
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
            scrollbar-width: none;
        }

        .categories-filter::-webkit-scrollbar {
            display: none;
        }

        .cat-pill {
            padding: 8px 18px;
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 999px;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s ease;
            user-select: none;
        }

        .cat-pill:hover {
            color: var(--text-main);
            border-color: rgba(230, 126, 34, 0.3);
            background-color: var(--bg-card);
        }

        .cat-pill.active {
            background: linear-gradient(135deg, #e67e22, #d35400);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(230, 126, 34, 0.35);
        }

        /* Menu Grid */
        .menu-grid {
            flex: 1;
            overflow-y: auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 16px;
            padding-right: 4px;
            padding-bottom: 24px;
        }

        .menu-grid::-webkit-scrollbar {
            width: 6px;
        }

        .menu-grid::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 999px;
        }

        /* Menu Item Card */
        .menu-card {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 14px;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            user-select: none;
        }

        .menu-card:hover {
            background-color: var(--bg-card-hover);
            border-color: var(--border-hover);
            transform: translateY(-3px);
            box-shadow: var(--shadow-subtle), var(--shadow-glow);
        }

        .menu-card:active {
            transform: scale(0.98);
        }

        .menu-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .cat-badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            background: rgba(230, 126, 34, 0.12);
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .stock-badge {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 999px;
            background: rgba(16, 185, 129, 0.12);
            color: var(--success);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .stock-badge.warning {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }

        .stock-badge.empty {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }

        .menu-visual {
            height: 105px;
            border-radius: var(--radius-sm);
            background: linear-gradient(135deg, rgba(230, 126, 34, 0.08), rgba(0, 0, 0, 0.2));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .menu-icon-hero {
            font-size: 42px;
            color: var(--primary);
            opacity: 0.85;
            transition: transform 0.3s ease;
        }

        .menu-card:hover .menu-icon-hero {
            transform: scale(1.1) rotate(4deg);
        }

        .menu-info h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 0.96rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .menu-recipe-peek {
            font-size: 0.72rem;
            color: var(--text-dim);
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .menu-price {
            font-family: 'Outfit', sans-serif;
            font-size: 1.05rem;
            font-weight: 800;
            color: #fff;
        }

        .add-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            border: 1px solid rgba(230, 126, 34, 0.2);
            transition: all 0.2s ease;
        }

        .menu-card:hover .add-btn {
            background-color: var(--primary);
            color: #fff;
            transform: scale(1.08);
        }

        /* Right Pane: Cart & Calculator */
        .cart-pane {
            background-color: var(--bg-surface);
            border-left: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            height: 100%;
        }

        .cart-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-title h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
        }

        .cart-counter {
            background-color: var(--primary);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 999px;
        }

        .clear-cart-btn {
            background: none;
            border: none;
            color: var(--text-dim);
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .clear-cart-btn:hover {
            color: var(--danger);
        }

        /* Customer & Order Settings */
        .order-meta-box {
            padding: 12px 20px;
            background: rgba(0, 0, 0, 0.25);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .order-meta-row {
            display: flex;
            gap: 10px;
        }

        .order-type-tabs {
            display: flex;
            flex: 1;
            background-color: var(--bg-card);
            border-radius: var(--radius-sm);
            padding: 3px;
            border: 1px solid var(--border-color);
        }

        .order-tab {
            flex: 1;
            text-align: center;
            padding: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-muted);
            user-select: none;
        }

        .order-tab.active {
            background-color: var(--primary);
            color: #fff;
        }

        .form-select, .form-input-sm {
            flex: 1;
            padding: 8px 12px;
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: var(--text-main);
            font-size: 0.82rem;
            outline: none;
        }

        .form-select:focus, .form-input-sm:focus {
            border-color: var(--primary);
        }

        /* Cart Items List */
        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 14px 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .cart-items::-webkit-scrollbar {
            width: 4px;
        }

        .cart-items::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 999px;
        }

        .empty-cart-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--text-dim);
            text-align: center;
            gap: 12px;
            padding: 40px 20px;
        }

        .empty-cart-icon {
            font-size: 48px;
            color: rgba(255, 255, 255, 0.08);
        }

        .cart-item-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 10px 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            animation: slideIn 0.2s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .cart-item-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .cart-item-name {
            font-family: 'Outfit', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .cart-item-price {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .qty-btn {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            background-color: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .qty-btn:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .qty-display {
            font-family: 'Space Mono', monospace;
            font-size: 0.85rem;
            font-weight: 700;
            min-width: 24px;
            text-align: center;
        }

        .cart-item-subtotal {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            min-width: 80px;
            text-align: right;
            color: #fff;
        }

        .remove-item-btn {
            background: none;
            border: none;
            color: var(--text-dim);
            cursor: pointer;
            padding: 4px;
            font-size: 0.82rem;
            transition: color 0.15s ease;
        }

        .remove-item-btn:hover {
            color: var(--danger);
        }

        .cart-item-note {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(0, 0, 0, 0.2);
            padding: 4px 8px;
            border-radius: 4px;
        }

        .cart-item-note input {
            background: none;
            border: none;
            outline: none;
            color: var(--text-muted);
            font-size: 0.75rem;
            width: 100%;
        }

        .cart-item-note input::placeholder {
            color: var(--text-dim);
        }

        /* Calculator & Payment Summary */
        .cart-calculator {
            background-color: #121115;
            border-top: 1px solid var(--border-color);
            padding: 16px 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .calc-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.84rem;
            color: var(--text-muted);
        }

        .calc-row span.val {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            color: var(--text-main);
        }

        .calc-control-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .calc-input {
            width: 90px;
            padding: 4px 8px;
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-main);
            font-size: 0.8rem;
            text-align: right;
            outline: none;
        }

        .calc-input:focus {
            border-color: var(--primary);
        }

        .tax-toggle-btn {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            cursor: pointer;
        }

        .tax-toggle-btn.active {
            background: var(--primary-light);
            color: var(--primary);
            border-color: rgba(230, 126, 34, 0.3);
        }

        .calc-divider {
            height: 1px;
            background: var(--border-color);
            margin: 2px 0;
        }

        .calc-row.grand-total {
            font-size: 1.05rem;
            font-weight: 800;
            color: #fff;
        }

        .calc-row.grand-total span.val {
            font-size: 1.35rem;
            color: var(--primary);
            font-weight: 800;
        }

        /* Payment & Quick Cash Buttons */
        .payment-methods {
            display: flex;
            gap: 6px;
            margin-top: 4px;
        }

        .pay-tab {
            flex: 1;
            padding: 8px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            text-align: center;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .pay-tab.active {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }

        .cash-input-box {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 4px;
        }

        .cash-input-wrapper {
            position: relative;
        }

        .cash-input-prefix {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted);
        }

        .cash-input-field {
            width: 100%;
            padding: 10px 14px 10px 42px;
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .cash-input-field:focus {
            border-color: var(--primary);
        }

        .quick-cash-row {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .quick-cash-row::-webkit-scrollbar {
            display: none;
        }

        .qc-btn {
            flex: 1;
            white-space: nowrap;
            padding: 5px 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-muted);
            font-size: 0.72rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .qc-btn:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }

        /* Change Return Display */
        .change-box {
            background: rgba(0, 0, 0, 0.35);
            border: 1px dashed var(--border-color);
            border-radius: var(--radius-sm);
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .change-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .change-value {
            font-family: 'Outfit', sans-serif;
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--success);
        }

        .change-value.underpaid {
            color: var(--danger);
            font-size: 0.92rem;
        }

        /* Process Checkout Button */
        .checkout-btn {
            background: linear-gradient(135deg, #e67e22, #d35400);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: var(--radius-md);
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            box-shadow: 0 4px 18px rgba(230, 126, 34, 0.4);
            transition: all 0.2s ease;
            margin-top: 4px;
        }

        .checkout-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(230, 126, 34, 0.55);
        }

        .checkout-btn:active:not(:disabled) {
            transform: scale(0.98);
        }

        .checkout-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            box-shadow: none;
            background: var(--bg-card);
            color: var(--text-dim);
            border: 1px solid var(--border-color);
        }

        /* Modals Generic Styling */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 20px;
            animation: fadeIn 0.2s ease;
        }

        .modal-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-box {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            max-width: 580px;
            width: 100%;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
        }

        .modal-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-close-btn {
            background: none;
            border: none;
            color: var(--text-dim);
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.15s ease;
        }

        .modal-close-btn:hover {
            color: var(--text-main);
        }

        .modal-body {
            padding: 20px 24px;
            overflow-y: auto;
            flex: 1;
        }

        .modal-footer {
            padding: 14px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: rgba(0, 0, 0, 0.2);
        }

        /* Realistic Thermal Paper Receipt Preview */
        .receipt-paper {
            background: #fff;
            color: #111;
            font-family: 'Space Mono', monospace;
            padding: 28px 24px;
            border-radius: 6px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            max-width: 380px;
            margin: 0 auto;
            position: relative;
            line-height: 1.4;
            font-size: 0.8rem;
        }

        /* Serrated Receipt Edges Effect */
        .receipt-paper::before, .receipt-paper::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            height: 6px;
            background-size: 12px 6px;
        }

        .receipt-paper::before {
            top: -6px;
            background-image: radial-gradient(circle at 6px 0, transparent 6px, #fff 6px);
        }

        .receipt-paper::after {
            bottom: -6px;
            background-image: radial-gradient(circle at 6px 6px, transparent 6px, #fff 6px);
        }

        .receipt-center {
            text-align: center;
        }

        .receipt-brand-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .receipt-divider {
            border-top: 1px dashed #999;
            margin: 8px 0;
        }

        .receipt-double-divider {
            border-top: 1px double #555;
            margin: 8px 0;
        }

        .receipt-line {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .receipt-item-title {
            font-weight: 700;
        }

        .receipt-item-math {
            font-size: 0.75rem;
            color: #555;
        }

        .receipt-total-big {
            font-size: 1.05rem;
            font-weight: 800;
        }

        /* Stock Automation Banner in Receipt Modal */
        .stock-deduction-badge {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 12px;
            margin-top: 16px;
            color: #166534;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.78rem;
        }

        .stock-deduction-badge h4 {
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 6px;
            font-size: 0.85rem;
        }

        .stock-deduction-badge ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stock-deduction-badge li {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed rgba(22, 101, 52, 0.2);
            padding-bottom: 2px;
        }

        /* Ingredients Monitor Table */
        .ingredients-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.83rem;
        }

        .ingredients-table th {
            text-align: left;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.04);
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
        }

        .ingredients-table td {
            padding: 10px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            color: var(--text-main);
        }

        /* Table Status Cards in Table Modal */
        .tables-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 12px;
        }

        .table-status-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 12px;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .table-status-card.tersedia {
            border-color: rgba(16, 185, 129, 0.4);
        }

        .table-status-card.terisi {
            border-color: rgba(239, 68, 68, 0.5);
            background: rgba(239, 68, 68, 0.05);
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 200;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .pos-toast {
            background: var(--bg-card);
            color: #fff;
            padding: 12px 18px;
            border-radius: var(--radius-sm);
            border-left: 4px solid var(--primary);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: toastIn 0.25s ease;
        }

        .pos-toast.success {
            border-left-color: var(--success);
        }

        .pos-toast.error {
            border-left-color: var(--danger);
        }

        @keyframes toastIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Print Specific Styling */
        @media print {
            body * {
                visibility: hidden;
            }
            #receiptPaperModal, #receiptPaperModal * {
                visibility: visible;
            }
            #receiptPaperModal {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                background: none;
                box-shadow: none;
            }
            .modal-overlay, .modal-box, .modal-header, .modal-footer, .stock-deduction-badge {
                display: none !important;
            }
        }

        @media (max-width: 980px) {
            .pos-container {
                grid-template-columns: 1fr;
                height: auto;
                overflow: visible;
            }
            .cart-pane {
                border-left: none;
                border-top: 1px solid var(--border-color);
            }
        }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <header class="navbar">
        <a href="<?= base_url() ?>" class="brand">
            <div class="brand-icon">
                <i class="fa-solid fa-mug-hot"></i>
            </div>
            <div class="brand-text">
                <h1>Warung Kopi Tradisional</h1>
                <span>Sistem Kasir POS & Otomasi Stok</span>
            </div>
        </a>

        <div class="nav-actions">
            <div class="live-clock" id="liveClock">00:00:00 WIB</div>

            <button type="button" class="badge-btn primary" onclick="openIngredientsModal()">
                <i class="fa-solid fa-boxes-stacked"></i>
                <span>Stok Bahan Baku</span>
            </button>

            <button type="button" class="badge-btn" onclick="openTablesModal()">
                <i class="fa-solid fa-chair"></i>
                <span>Status Meja</span>
            </button>

            <div class="cashier-info">
                <div class="cashier-avatar">
                    <?= esc(substr($activeUser['nama_lengkap'] ?? 'K', 0, 1)) ?>
                </div>
                <div class="cashier-name">
                    <?= esc($activeUser['nama_lengkap'] ?? 'Kasir') ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Main POS Interface Workspace -->
    <main class="pos-container">
        
        <!-- Left Pane: Menu Catalog -->
        <section class="menu-pane">
            <div class="menu-top-bar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="menuSearch" placeholder="Cari menu kopi, makanan, cemilan..." oninput="filterMenus()">
                </div>
                <div class="categories-filter" id="categoriesFilter">
                    <button type="button" class="cat-pill active" onclick="setCategoryFilter('all')">
                        <i class="fa-solid fa-utensils"></i> Semua Menu
                    </button>
                    <?php foreach ($categories as $cat): ?>
                        <button type="button" class="cat-pill" onclick="setCategoryFilter('<?= $cat['id'] ?>')">
                            <?= esc($cat['nama_kategori']) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Menu Grid -->
            <div class="menu-grid" id="menuGrid">
                <?php foreach ($menus as $menu): ?>
                    <div class="menu-card" 
                         data-category="<?= $menu['category_id'] ?>" 
                         data-id="<?= $menu['id'] ?>" 
                         data-name="<?= esc(strtolower($menu['nama_menu'])) ?>"
                         onclick="addToCart(<?= htmlspecialchars(json_encode([
                             'id'    => $menu['id'],
                             'nama'  => $menu['nama_menu'],
                             'harga' => (float) $menu['harga'],
                             'stok'  => (int) $menu['stok'],
                             'resep' => $menu['resep'] ?? [],
                         ])) ?>)">
                        
                        <div class="menu-card-header">
                            <span class="cat-badge"><?= esc($menu['nama_kategori']) ?></span>
                            <?php if ($menu['stok'] > 20): ?>
                                <span class="stock-badge"><i class="fa-solid fa-circle-check"></i> <?= $menu['stok'] ?> porsi</span>
                            <?php elseif ($menu['stok'] > 0): ?>
                                <span class="stock-badge warning"><i class="fa-solid fa-triangle-exclamation"></i> <?= $menu['stok'] ?> porsi</span>
                            <?php else: ?>
                                <span class="stock-badge empty"><i class="fa-solid fa-circle-xmark"></i> Habis</span>
                            <?php endif; ?>
                        </div>

                        <div class="menu-visual">
                            <?php
                                // Icon representative based on category
                                $iconClass = 'fa-mug-hot';
                                if ($menu['category_id'] == 1) $iconClass = 'fa-mug-saucer';
                                elseif ($menu['category_id'] == 2) $iconClass = 'fa-glass-water-droplet';
                                elseif ($menu['category_id'] == 3) $iconClass = 'fa-bottle-water';
                                elseif ($menu['category_id'] == 4) $iconClass = 'fa-bowl-rice';
                                elseif ($menu['category_id'] == 5) $iconClass = 'fa-cookie-bite';
                            ?>
                            <i class="fa-solid <?= $iconClass ?> menu-icon-hero"></i>
                        </div>

                        <div class="menu-info">
                            <h3><?= esc($menu['nama_menu']) ?></h3>
                            <div class="menu-recipe-peek" title="Resep: <?php 
                                $ingList = [];
                                foreach ($menu['resep'] as $r) {
                                    $ingList[] = $r['nama_bahan'] . ' ' . (float)$r['jumlah_pakai'] . $r['satuan'];
                                }
                                echo esc(implode(', ', $ingList));
                            ?>">
                                <i class="fa-solid fa-mortar-pestle"></i> 
                                <?php 
                                    if (!empty($menu['resep'])) {
                                        $peek = [];
                                        foreach ($menu['resep'] as $r) {
                                            $peek[] = $r['nama_bahan'];
                                        }
                                        echo esc(implode(' • ', $peek));
                                    } else {
                                        echo 'Bahan langsung';
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="menu-footer">
                            <span class="menu-price">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></span>
                            <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Right Pane: Interactive Cart & Calculator -->
        <aside class="cart-pane">
            <div class="cart-header">
                <div class="cart-title">
                    <i class="fa-solid fa-basket-shopping" style="color: var(--primary);"></i>
                    <h2>Pesanan</h2>
                    <span class="cart-counter" id="cartCountBadge">0</span>
                </div>
                <button type="button" class="clear-cart-btn" onclick="clearCart()">
                    <i class="fa-solid fa-trash-can"></i> Bersihkan
                </button>
            </div>

            <!-- Order Metadata (Pelanggan, Dine In / Take Away, Meja) -->
            <div class="order-meta-box">
                <div class="order-meta-row">
                    <div class="order-type-tabs">
                        <div class="order-tab active" id="tabDineIn" onclick="setOrderType('dine_in')">
                            <i class="fa-solid fa-utensils"></i> Makan Sini
                        </div>
                        <div class="order-tab" id="tabTakeAway" onclick="setOrderType('take_away')">
                            <i class="fa-solid fa-bag-shopping"></i> Bungkus
                        </div>
                    </div>
                </div>

                <div class="order-meta-row">
                    <input type="text" id="customerName" class="form-input-sm" placeholder="Nama Pelanggan (cth: Mas Budi)" value="Pelanggan">
                    <select id="tableSelect" class="form-select">
                        <option value="">Pilih Nomor Meja...</option>
                        <?php foreach ($tables as $t): ?>
                            <option value="<?= $t['id'] ?>" <?= ($t['status'] === 'terisi') ? 'style="color:#ef4444;"' : '' ?>>
                                <?= esc($t['nomor_meja']) ?> (<?= esc(ucfirst($t['status'])) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Cart Items List -->
            <div class="cart-items" id="cartItemsList">
                <div class="empty-cart-state" id="emptyCartState">
                    <i class="fa-solid fa-cart-shopping empty-cart-icon"></i>
                    <p>Keranjang masih kosong.<br><small style="color:var(--text-dim)">Klik salah satu menu di sebelah kiri untuk menambahkan pesanan.</small></p>
                </div>
            </div>

            <!-- Calculator & Summary Section -->
            <div class="cart-calculator">
                <div class="calc-row">
                    <span>Subtotal</span>
                    <span class="val" id="calcSubtotal">Rp 0</span>
                </div>

                <div class="calc-row">
                    <div class="calc-control-group">
                        <span>Diskon (Rp)</span>
                    </div>
                    <input type="number" id="calcDiscount" class="calc-input" min="0" step="1000" value="0" placeholder="0" oninput="calculateTransaction()">
                </div>

                <div class="calc-row">
                    <div class="calc-control-group">
                        <span>Pajak PPN</span>
                        <button type="button" class="tax-toggle-btn active" id="taxToggleBtn" onclick="toggleTax()">10% (Aktif)</button>
                    </div>
                    <span class="val" id="calcTax">Rp 0</span>
                </div>

                <div class="calc-divider"></div>

                <div class="calc-row grand-total">
                    <span>Total Tagihan</span>
                    <span class="val" id="calcGrandTotal">Rp 0</span>
                </div>

                <!-- Metode Pembayaran -->
                <div class="payment-methods">
                    <div class="pay-tab active" id="payTunai" onclick="setPaymentMethod('tunai')">
                        <i class="fa-solid fa-money-bill-wave"></i> Tunai
                    </div>
                    <div class="pay-tab" id="payQris" onclick="setPaymentMethod('qris')">
                        <i class="fa-solid fa-qrcode"></i> QRIS
                    </div>
                    <div class="pay-tab" id="payTransfer" onclick="setPaymentMethod('transfer')">
                        <i class="fa-solid fa-building-columns"></i> Transfer
                    </div>
                </div>

                <!-- Input Uang Bayar Tunai -->
                <div class="cash-input-box" id="cashInputBox">
                    <div class="cash-input-wrapper">
                        <span class="cash-input-prefix">Rp</span>
                        <input type="number" id="cashPaidInput" class="cash-input-field" placeholder="0" oninput="calculateTransaction()">
                    </div>

                    <div class="quick-cash-row">
                        <button type="button" class="qc-btn" onclick="setQuickCash('exact')">Uang Pas</button>
                        <button type="button" class="qc-btn" onclick="setQuickCash(10000)">10k</button>
                        <button type="button" class="qc-btn" onclick="setQuickCash(20000)">20k</button>
                        <button type="button" class="qc-btn" onclick="setQuickCash(50000)">50k</button>
                        <button type="button" class="qc-btn" onclick="setQuickCash(100000)">100k</button>
                    </div>
                </div>

                <!-- Display Uang Kembalian -->
                <div class="change-box">
                    <span class="change-label">Uang Kembalian:</span>
                    <span class="change-value" id="calcChange">Rp 0</span>
                </div>

                <!-- Checkout Button -->
                <button type="button" id="btnCheckout" class="checkout-btn" disabled onclick="processCheckout()">
                    <i class="fa-solid fa-print"></i>
                    <span>Selesaikan & Cetak Struk</span>
                </button>
            </div>
        </aside>
    </main>

    <!-- Modal Cetak Struk Termal & Hasil Pengurangan Stok Otomatis -->
    <div class="modal-overlay" id="receiptModal">
        <div class="modal-box" style="max-width: 480px;">
            <div class="modal-header">
                <h3><i class="fa-solid fa-receipt" style="color:var(--primary);"></i> Struk Transaksi Selesai</h3>
                <button type="button" class="modal-close-btn" onclick="closeReceiptModal()">&times;</button>
            </div>
            <div class="modal-body" style="background:#222127;">
                <!-- Kertas Struk Realistis -->
                <div class="receipt-paper" id="receiptPaperModal">
                    <div class="receipt-center">
                        <div class="receipt-brand-title">WARUNG KOPI TRADISIONAL</div>
                        <div style="font-size:0.75rem;">Jl. Teuku Umar No. 24, Warkop Heritage</div>
                        <div style="font-size:0.72rem; color:#666;">Telp/WA: 0812-3456-7890</div>
                    </div>

                    <div class="receipt-divider"></div>

                    <div class="receipt-line">
                        <span>No. Faktur:</span>
                        <span id="rcptInvoice">-</span>
                    </div>
                    <div class="receipt-line">
                        <span>Tanggal:</span>
                        <span id="rcptDate">-</span>
                    </div>
                    <div class="receipt-line">
                        <span>Kasir:</span>
                        <span id="rcptCashier">-</span>
                    </div>
                    <div class="receipt-line">
                        <span>Pelanggan:</span>
                        <span id="rcptCustomer">-</span>
                    </div>
                    <div class="receipt-line">
                        <span>Layanan / Meja:</span>
                        <span id="rcptTable">-</span>
                    </div>

                    <div class="receipt-double-divider"></div>

                    <!-- Items container -->
                    <div id="rcptItemsList"></div>

                    <div class="receipt-divider"></div>

                    <div class="receipt-line">
                        <span>Subtotal:</span>
                        <span id="rcptSubtotal">Rp 0</span>
                    </div>
                    <div class="receipt-line" id="rcptDiscountRow" style="display:none;">
                        <span>Diskon:</span>
                        <span id="rcptDiscount">- Rp 0</span>
                    </div>
                    <div class="receipt-line" id="rcptTaxRow" style="display:none;">
                        <span>Pajak (PPN):</span>
                        <span id="rcptTax">Rp 0</span>
                    </div>
                    
                    <div class="receipt-divider"></div>

                    <div class="receipt-line receipt-total-big">
                        <span>TOTAL AKHIR:</span>
                        <span id="rcptGrandTotal">Rp 0</span>
                    </div>
                    <div class="receipt-line">
                        <span>Metode / Bayar:</span>
                        <span id="rcptPayment">-</span>
                    </div>
                    <div class="receipt-line" style="font-weight:700;">
                        <span>Kembalian:</span>
                        <span id="rcptChange">Rp 0</span>
                    </div>

                    <div class="receipt-double-divider"></div>

                    <div class="receipt-center" style="font-size:0.75rem; margin-top:8px;">
                        <div>-- MATUR NUWUN / TERIMA KASIH --</div>
                        <div style="font-size:0.7rem; color:#666; margin-top:4px;">Racikan Kopi Mantap, Obrolan Hangat!</div>
                    </div>
                </div>

                <!-- Banner Informasi Pengurangan Stok Bahan Baku Otomatis -->
                <div class="stock-deduction-badge" id="stockDeductionAlert">
                    <h4><i class="fa-solid fa-atom"></i> Otomatisasi Stok Berhasil:</h4>
                    <p style="margin-bottom:6px;">Bahan baku MySQL otomatis berkurang sesuai resep menu:</p>
                    <ul id="deductedMaterialsList">
                        <!-- Populated by JavaScript -->
                    </ul>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="badge-btn" onclick="closeReceiptModal()">
                    <i class="fa-solid fa-circle-check"></i> Transaksi Baru
                </button>
                <button type="button" class="badge-btn primary" onclick="printReceipt()">
                    <i class="fa-solid fa-print"></i> Cetak Struk (Print)
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Monitor Stok Bahan Baku Warkop -->
    <div class="modal-overlay" id="ingredientsModal">
        <div class="modal-box" style="max-width: 650px;">
            <div class="modal-header">
                <h3><i class="fa-solid fa-boxes-stacked" style="color:var(--primary);"></i> Gudang Bahan Baku Warkop</h3>
                <button type="button" class="modal-close-btn" onclick="closeIngredientsModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p style="font-size:0.84rem; color:var(--text-muted); margin-bottom:14px;">
                    Setiap menu yang dipesan akan memotong bahan baku berikut di database MySQL secara otomatis sesuai takaran resep.
                </p>
                <div style="overflow-x:auto;">
                    <table class="ingredients-table">
                        <thead>
                            <tr>
                                <th>Nama Bahan</th>
                                <th>Satuan</th>
                                <th>Stok Tersedia</th>
                                <th>Status Gudang</th>
                            </tr>
                        </thead>
                        <tbody id="ingredientsTableBody">
                            <?php foreach ($ingredients as $ing): ?>
                                <tr>
                                    <td style="font-weight:600;"><?= esc($ing['nama_bahan']) ?></td>
                                    <td><span style="color:var(--text-muted);"><?= esc($ing['satuan']) ?></span></td>
                                    <td style="font-family:'Space Mono', monospace; font-weight:700;">
                                        <?= number_format($ing['stok'], 2, ',', '.') ?> <?= esc($ing['satuan']) ?>
                                    </td>
                                    <td>
                                        <?php if ($ing['stok'] <= $ing['stok_minimum']): ?>
                                            <span style="color:var(--danger); font-size:0.75rem; font-weight:700;">
                                                <i class="fa-solid fa-circle-exclamation"></i> Menipis
                                            </span>
                                        <?php else: ?>
                                            <span style="color:var(--success); font-size:0.75rem; font-weight:700;">
                                                <i class="fa-solid fa-circle-check"></i> Aman
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="badge-btn primary" onclick="refreshIngredientsData()">
                    <i class="fa-solid fa-rotate"></i> Segarkan Data
                </button>
                <button type="button" class="badge-btn" onclick="closeIngredientsModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Status Meja Warkop -->
    <div class="modal-overlay" id="tablesModal">
        <div class="modal-box" style="max-width: 580px;">
            <div class="modal-header">
                <h3><i class="fa-solid fa-chair" style="color:var(--primary);"></i> Status Meja Warung Kopi</h3>
                <button type="button" class="modal-close-btn" onclick="closeTablesModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="tables-grid" id="tablesModalGrid">
                    <?php foreach ($tables as $t): ?>
                        <div class="table-status-card <?= esc($t['status']) ?>" id="tableCard-<?= $t['id'] ?>">
                            <i class="fa-solid fa-mug-hot" style="font-size:24px; color:<?= ($t['status'] === 'terisi') ? 'var(--danger)' : 'var(--success)' ?>;"></i>
                            <strong style="font-size:0.9rem;"><?= esc($t['nomor_meja']) ?></strong>
                            <small style="color:var(--text-muted);"><?= $t['kapasitas'] ?> Kursi</small>
                            <span style="font-size:0.75rem; font-weight:700; text-transform:uppercase; color:<?= ($t['status'] === 'terisi') ? 'var(--danger)' : 'var(--success)' ?>;">
                                <?= esc($t['status']) ?>
                            </span>
                            <?php if ($t['status'] === 'terisi'): ?>
                                <button type="button" class="badge-btn" style="padding:4px 8px; font-size:0.7rem; margin-top:4px;" onclick="resetTable(<?= $t['id'] ?>)">
                                    Kosongkan
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="badge-btn" onclick="closeTablesModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Toast Notifications Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // State Management
        let cart = [];
        let orderType = 'dine_in';
        let paymentMethod = 'tunai';
        let isTaxActive = true;
        let lastTransactionReceipt = null;

        // Audio Feedback Synthesizer (Web Audio API)
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        function playBeep(freq = 600, duration = 0.08) {
            try {
                if (audioCtx.state === 'suspended') audioCtx.resume();
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
                gain.gain.setValueAtTime(0.08, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + duration);
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.start();
                osc.stop(audioCtx.currentTime + duration);
            } catch (e) {}
        }

        function playSuccessChime() {
            try {
                playBeep(523.25, 0.1); // C5
                setTimeout(() => playBeep(659.25, 0.1), 100); // E5
                setTimeout(() => playBeep(783.99, 0.2), 200); // G5
            } catch (e) {}
        }

        // Live Clock
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour12: false }) + ' WIB';
            document.getElementById('liveClock').textContent = timeStr;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Filter Categories
        function setCategoryFilter(catId) {
            const pills = document.querySelectorAll('#categoriesFilter .cat-pill');
            pills.forEach(p => p.classList.remove('active'));
            event.target.classList.add('active');

            const cards = document.querySelectorAll('.menu-card');
            cards.forEach(card => {
                if (catId === 'all' || card.getAttribute('data-category') === catId) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Search Menus Realtime
        function filterMenus() {
            const query = document.getElementById('menuSearch').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.menu-card');
            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                if (name.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Order Type Tab Switcher
        function setOrderType(type) {
            orderType = type;
            document.getElementById('tabDineIn').classList.toggle('active', type === 'dine_in');
            document.getElementById('tabTakeAway').classList.toggle('active', type === 'take_away');
            
            const tableSelect = document.getElementById('tableSelect');
            if (type === 'take_away') {
                tableSelect.disabled = true;
                tableSelect.value = '';
            } else {
                tableSelect.disabled = false;
            }
        }

        // Payment Method Switcher
        function setPaymentMethod(method) {
            paymentMethod = method;
            document.getElementById('payTunai').classList.toggle('active', method === 'tunai');
            document.getElementById('payQris').classList.toggle('active', method === 'qris');
            document.getElementById('payTransfer').classList.toggle('active', method === 'transfer');

            const cashBox = document.getElementById('cashInputBox');
            if (method === 'tunai') {
                cashBox.style.display = 'flex';
            } else {
                cashBox.style.display = 'none';
            }
            calculateTransaction();
        }

        // Tax Toggle
        function toggleTax() {
            isTaxActive = !isTaxActive;
            const btn = document.getElementById('taxToggleBtn');
            btn.classList.toggle('active', isTaxActive);
            btn.textContent = isTaxActive ? '10% (Aktif)' : '0% (Nonaktif)';
            calculateTransaction();
        }

        // Add Menu to Cart (Interactive Click)
        function addToCart(menu) {
            playBeep(750, 0.06);

            const existingIndex = cart.findIndex(item => item.id === menu.id);
            if (existingIndex > -1) {
                if (cart[existingIndex].qty >= menu.stok) {
                    showToast('Stok porsi menu sudah mencapai batas maksimum!', 'error');
                    return;
                }
                cart[existingIndex].qty += 1;
            } else {
                if (menu.stok <= 0) {
                    showToast('Maaf, menu ini sedang habis!', 'error');
                    return;
                }
                cart.push({
                    id: menu.id,
                    nama: menu.nama,
                    harga: menu.harga,
                    qty: 1,
                    stok: menu.stok,
                    catatan: '',
                    resep: menu.resep,
                });
            }

            renderCart();
            calculateTransaction();
            showToast(`${menu.nama} ditambahkan ke keranjang`, 'success');
        }

        // Adjust Quantity
        function changeQty(index, delta) {
            playBeep(650, 0.05);
            const item = cart[index];
            const newQty = item.qty + delta;

            if (newQty <= 0) {
                cart.splice(index, 1);
            } else if (newQty > item.stok) {
                showToast(`Stok hanya tersisa ${item.stok} porsi!`, 'error');
            } else {
                item.qty = newQty;
            }

            renderCart();
            calculateTransaction();
        }

        // Remove Single Item
        function removeFromCart(index) {
            cart.splice(index, 1);
            renderCart();
            calculateTransaction();
        }

        // Update Item Note
        function updateItemNote(index, note) {
            if (cart[index]) {
                cart[index].catatan = note;
            }
        }

        // Clear Entire Cart
        function clearCart() {
            if (cart.length === 0) return;
            cart = [];
            renderCart();
            calculateTransaction();
            showToast('Keranjang telah dibersihkan', 'info');
        }

        // Render Cart HTML
        function renderCart() {
            const container = document.getElementById('cartItemsList');
            const emptyState = document.getElementById('emptyCartState');
            const countBadge = document.getElementById('cartCountBadge');

            const totalItemCount = cart.reduce((sum, item) => sum + item.qty, 0);
            countBadge.textContent = totalItemCount;

            if (cart.length === 0) {
                container.innerHTML = '';
                container.appendChild(emptyState);
                emptyState.style.display = 'flex';
                return;
            }

            emptyState.style.display = 'none';
            let html = '';

            cart.forEach((item, index) => {
                const subtotal = item.harga * item.qty;
                html += `
                    <div class="cart-item-card">
                        <div class="cart-item-main">
                            <div style="flex:1;">
                                <div class="cart-item-name">${item.nama}</div>
                                <div class="cart-item-price">Rp ${formatRupiah(item.harga)}</div>
                            </div>
                            <div class="cart-item-actions">
                                <button type="button" class="qty-btn" onclick="changeQty(${index}, -1)">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <span class="qty-display">${item.qty}</span>
                                <button type="button" class="qty-btn" onclick="changeQty(${index}, 1)">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                            <div class="cart-item-subtotal">Rp ${formatRupiah(subtotal)}</div>
                            <button type="button" class="remove-item-btn" onclick="removeFromCart(${index})" title="Hapus">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="cart-item-note">
                            <i class="fa-solid fa-pen" style="font-size:0.7rem; color:var(--text-dim);"></i>
                            <input type="text" placeholder="Catatan rasa (cth: Panas, Gula sedikit, dll.)" 
                                   value="${escapeHtml(item.catatan || '')}" 
                                   onchange="updateItemNote(${index}, this.value)">
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        // Kalkulator Transaksi Otomatis
        function calculateTransaction() {
            let subtotal = 0;
            cart.forEach(item => {
                subtotal += item.harga * item.qty;
            });

            let discount = parseFloat(document.getElementById('calcDiscount').value) || 0;
            if (discount > subtotal) discount = subtotal;

            const taxable = Math.max(0, subtotal - discount);
            const taxPercent = isTaxActive ? 10 : 0;
            const tax = Math.round(taxable * (taxPercent / 100));
            const grandTotal = taxable + tax;

            document.getElementById('calcSubtotal').textContent = 'Rp ' + formatRupiah(subtotal);
            document.getElementById('calcTax').textContent = 'Rp ' + formatRupiah(tax);
            document.getElementById('calcGrandTotal').textContent = 'Rp ' + formatRupiah(grandTotal);

            // Logika Pembayaran & Kembalian
            const cashInput = document.getElementById('cashPaidInput');
            const changeDisplay = document.getElementById('calcChange');
            const checkoutBtn = document.getElementById('btnCheckout');

            if (cart.length === 0) {
                checkoutBtn.disabled = true;
                changeDisplay.textContent = 'Rp 0';
                changeDisplay.className = 'change-value';
                return;
            }

            if (paymentMethod === 'tunai') {
                const cashPaid = parseFloat(cashInput.value) || 0;
                if (cashPaid >= grandTotal) {
                    const change = cashPaid - grandTotal;
                    changeDisplay.textContent = 'Rp ' + formatRupiah(change);
                    changeDisplay.className = 'change-value';
                    checkoutBtn.disabled = false;
                } else {
                    const deficit = grandTotal - cashPaid;
                    changeDisplay.textContent = 'Kurang Rp ' + formatRupiah(deficit);
                    changeDisplay.className = 'change-value underpaid';
                    checkoutBtn.disabled = true;
                }
            } else {
                // Non-tunai (QRIS / Transfer)
                changeDisplay.textContent = 'Rp 0 (Pas)';
                changeDisplay.className = 'change-value';
                checkoutBtn.disabled = false;
            }
        }

        // Quick Cash Buttons
        function setQuickCash(amount) {
            const grandTotalStr = document.getElementById('calcGrandTotal').textContent.replace(/[^\d]/g, '');
            const grandTotal = parseInt(grandTotalStr) || 0;

            if (amount === 'exact') {
                document.getElementById('cashPaidInput').value = grandTotal;
            } else {
                document.getElementById('cashPaidInput').value = amount;
            }
            calculateTransaction();
        }

        // Backend Transaksi & Otomasi Pengurangan Stok Bahan Baku
        async function processCheckout() {
            if (cart.length === 0) return;

            const customerName = document.getElementById('customerName').value.trim() || 'Pelanggan';
            const tableId = document.getElementById('tableSelect').value;
            const discount = parseFloat(document.getElementById('calcDiscount').value) || 0;
            const taxPercent = isTaxActive ? 10 : 0;
            const cashPaid = parseFloat(document.getElementById('cashPaidInput').value) || 0;

            const btn = document.getElementById('btnCheckout');
            btn.disabled = true;
            btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>Memproses Stok...</span>`;

            const payload = {
                nama_pelanggan: customerName,
                tipe_pesanan: orderType,
                table_id: tableId,
                metode_pembayaran: paymentMethod,
                diskon: discount,
                pajak_persen: taxPercent,
                total_bayar: cashPaid,
                items: cart.map(item => ({
                    menu_id: item.id,
                    qty: item.qty,
                    catatan: item.catatan || '',
                }))
            };

            try {
                const response = await fetch('<?= base_url('pos/checkout') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (data.success) {
                    playSuccessChime();
                    showToast('Transaksi Sukses! Stok bahan baku berhasil dikurangi.', 'success');
                    lastTransactionReceipt = data.receipt;

                    // Buka Modal Cetak Struk
                    openReceiptModal(data.receipt);

                    // Bersihkan keranjang
                    cart = [];
                    renderCart();
                    document.getElementById('cashPaidInput').value = '';
                    document.getElementById('calcDiscount').value = '0';
                    calculateTransaction();

                    // Update visual status meja jika dine in
                    if (orderType === 'dine_in' && tableId) {
                        const tableCard = document.getElementById(`tableCard-${tableId}`);
                        if (tableCard) {
                            tableCard.className = 'table-status-card terisi';
                        }
                    }
                } else {
                    showToast(data.message || 'Gagal memproses transaksi!', 'error');
                }
            } catch (err) {
                showToast('Terjadi kesalahan koneksi ke server!', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = `<i class="fa-solid fa-print"></i> <span>Selesaikan & Cetak Struk</span>`;
            }
        }

        // Buka Modal Cetak Struk Termal
        function openReceiptModal(rcpt) {
            document.getElementById('rcptInvoice').textContent = rcpt.kode_transaksi;
            document.getElementById('rcptDate').textContent = rcpt.tanggal;
            document.getElementById('rcptCashier').textContent = rcpt.kasir;
            document.getElementById('rcptCustomer').textContent = rcpt.nama_pelanggan;
            document.getElementById('rcptTable').textContent = rcpt.tipe_pesanan + (rcpt.nomor_meja !== '-' ? ` (${rcpt.nomor_meja})` : '');

            // Render list items
            const itemsContainer = document.getElementById('rcptItemsList');
            let itemsHtml = '';
            rcpt.items.forEach(item => {
                itemsHtml += `
                    <div style="margin: 4px 0;">
                        <div class="receipt-line">
                            <span class="receipt-item-title">${item.nama_menu}</span>
                            <span>Rp ${formatRupiah(item.subtotal)}</span>
                        </div>
                        <div class="receipt-line receipt-item-math">
                            <span>${item.jumlah} x Rp ${formatRupiah(item.harga_satuan)}${item.catatan ? ' (' + item.catatan + ')' : ''}</span>
                        </div>
                    </div>
                `;
            });
            itemsContainer.innerHTML = itemsHtml;

            document.getElementById('rcptSubtotal').textContent = 'Rp ' + formatRupiah(rcpt.subtotal);

            // Diskon & Pajak
            const discRow = document.getElementById('rcptDiscountRow');
            if (rcpt.diskon > 0) {
                discRow.style.display = 'flex';
                document.getElementById('rcptDiscount').textContent = '- Rp ' + formatRupiah(rcpt.diskon);
            } else {
                discRow.style.display = 'none';
            }

            const taxRow = document.getElementById('rcptTaxRow');
            if (rcpt.pajak > 0) {
                taxRow.style.display = 'flex';
                document.getElementById('rcptTax').textContent = 'Rp ' + formatRupiah(rcpt.pajak);
            } else {
                taxRow.style.display = 'none';
            }

            document.getElementById('rcptGrandTotal').textContent = 'Rp ' + formatRupiah(rcpt.total_akhir);
            document.getElementById('rcptPayment').textContent = `${rcpt.metode_pembayaran} (Rp ${formatRupiah(rcpt.total_bayar)})`;
            document.getElementById('rcptChange').textContent = 'Rp ' + formatRupiah(rcpt.kembalian);

            // Render Pengurangan Bahan Baku Otomatis
            const matList = document.getElementById('deductedMaterialsList');
            if (rcpt.deducted_materials && rcpt.deducted_materials.length > 0) {
                let matHtml = '';
                rcpt.deducted_materials.forEach(m => {
                    matHtml += `
                        <li>
                            <span>${m.nama_bahan}:</span>
                            <strong>-${m.jumlah_pakai} ${m.satuan} (Sisa: ${m.stok_sisa} ${m.satuan})</strong>
                        </li>
                    `;
                });
                matList.innerHTML = matHtml;
                document.getElementById('stockDeductionAlert').style.display = 'block';
            } else {
                document.getElementById('stockDeductionAlert').style.display = 'none';
            }

            document.getElementById('receiptModal').classList.add('active');
        }

        function closeReceiptModal() {
            document.getElementById('receiptModal').classList.remove('active');
        }

        // Direct Print Window
        function printReceipt() {
            window.print();
        }

        // Modal Monitor Stok Bahan Baku
        function openIngredientsModal() {
            refreshIngredientsData();
            document.getElementById('ingredientsModal').classList.add('active');
        }

        function closeIngredientsModal() {
            document.getElementById('ingredientsModal').classList.remove('active');
        }

        async function refreshIngredientsData() {
            try {
                const res = await fetch('<?= base_url('pos/ingredients') ?>');
                const data = await res.json();
                if (data.success) {
                    const tbody = document.getElementById('ingredientsTableBody');
                    let html = '';
                    data.ingredients.forEach(ing => {
                        const isLow = parseFloat(ing.stok) <= parseFloat(ing.stok_minimum);
                        html += `
                            <tr>
                                <td style="font-weight:600;">${ing.nama_bahan}</td>
                                <td><span style="color:var(--text-muted);">${ing.satuan}</span></td>
                                <td style="font-family:'Space Mono', monospace; font-weight:700;">
                                    ${parseFloat(ing.stok).toLocaleString('id-ID')} ${ing.satuan}
                                </td>
                                <td>
                                    ${isLow 
                                        ? '<span style="color:var(--danger); font-size:0.75rem; font-weight:700;"><i class="fa-solid fa-circle-exclamation"></i> Menipis</span>' 
                                        : '<span style="color:var(--success); font-size:0.75rem; font-weight:700;"><i class="fa-solid fa-circle-check"></i> Aman</span>'}
                                </td>
                            </tr>
                        `;
                    });
                    tbody.innerHTML = html;
                }
            } catch (e) {}
        }

        // Modal Meja
        function openTablesModal() {
            document.getElementById('tablesModal').classList.add('active');
        }

        function closeTablesModal() {
            document.getElementById('tablesModal').classList.remove('active');
        }

        async function resetTable(tableId) {
            try {
                const res = await fetch(`<?= base_url('pos/reset-table/') ?>${tableId}`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                if (data.success) {
                    showToast('Meja berhasil dikosongkan!', 'success');
                    const card = document.getElementById(`tableCard-${tableId}`);
                    if (card) {
                        card.className = 'table-status-card tersedia';
                        card.querySelector('span').textContent = 'tersedia';
                        card.querySelector('span').style.color = 'var(--success)';
                        const btn = card.querySelector('button');
                        if (btn) btn.remove();
                    }
                }
            } catch (e) {}
        }

        // Toast Helper
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `pos-toast ${type}`;
            
            let icon = 'fa-info-circle';
            if (type === 'success') icon = 'fa-circle-check';
            if (type === 'error') icon = 'fa-circle-exclamation';

            toast.innerHTML = `<i class="fa-solid ${icon}"></i> <span>${escapeHtml(message)}</span>`;
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                setTimeout(() => toast.remove(), 300);
            }, 3200);
        }

        // Utilities
        function formatRupiah(number) {
            return Math.round(number).toLocaleString('id-ID');
        }

        function escapeHtml(text) {
            return String(text).replace(/[&<>"']/g, function(m) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
            });
        }
    </script>
</body>
</html>
