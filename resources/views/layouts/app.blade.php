<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quiz App')</title>
    <meta http-equiv="refresh">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4F46E5">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --info: #3B82F6;
            --bg-primary: #F9FAFB;
            --bg-secondary: #FFFFFF;
            --text-primary: #380066;
            --text-secondary: #6B7280;
            --border: #E5E7EB;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #fbfaf8;
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            padding-bottom: env(safe-area-inset-bottom);
        }
        
        /*----menu---*/
        .bottom-nav {
    position: fixed;
    bottom: 0;
    width: 100%;
    background: #fff;
    display: flex;
    justify-content: space-around;
    padding: 10px 0;
    border-top: 1px solid #eee;
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    text-decoration: none;
    color: black;
    font-size: 12px;
    padding: 8px 14px;
    border-radius: 14px;
    transition: all 0.3s ease;
}

.nav-item i {
    font-size: 20px;
}

.nav-item:hover {
    /*background: #f1ecfb;*/
    color: #6232ba;
}

.nav-item.active {
    background: #ede7fb;
    color: #6232ba;
}
 /*---menu---*/

        .container {
            max-width: 100%;
            padding: 1rem;
            margin: 0 auto;
        }

        /* Cards */
        .card {
            background: var(--bg-secondary);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            border: 0.5px solid #9356a0;
        }

        .card:active {
            transform: scale(0.98);
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            width: 100%;
            touch-action: manipulation;
        }

        .btn-primary {
            background:linear-gradient(135deg,rgba(118, 4, 194, 1) 100%, rgba(252, 176, 69, 1) 0%);
            color: white;
        }

        .btn-primary:active {
            transform: scale(0.97);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-secondary {
            background: var(--border);
            color: var(--text-primary);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        /* Progress Bar */
        .progress-bar {
            width: 100%;
            height: 8px;
            background: var(--border);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--info) 100%);
            transition: width 0.3s ease;
        }

        /* Timer */
        .timer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: var(--primary);
            color: white;
            padding: 1rem;
            text-align: center;
            font-size: 1.25rem;
            font-weight: 700;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .timer.warning {
            background: var(--warning);
            animation: pulse 1s infinite;
        }

        .timer.danger {
            background: var(--danger);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        /* Options */
        .option {
            background: var(--bg-secondary);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 1rem;
        }

        .option:active {
            transform: scale(0.98);
        }

        .option.selected {
            border-color: var(--info);
            background: rgba(59, 130, 246, 0.1);
        }

        .option.correct {
            border-color: var(--success);
            background: rgba(16, 185, 129, 0.1);
        }

        .option.incorrect {
            border-color: var(--danger);
            background: rgba(239, 68, 68, 0.1);
        }

        /* Bottom Navigation */
        /*.bottom-nav {*/
        /*    position: fixed;*/
        /*    bottom: 0;*/
        /*    left: 0;*/
        /*    right: 0;*/
        /*    background: var(--bg-secondary);*/
        /*    border-top: 1px solid var(--border);*/
        /*    display: flex;*/
        /*    justify-content: space-around;*/
        /*    padding: 0.75rem 0;*/
        /*    padding-bottom: calc(0.75rem + env(safe-area-inset-bottom));*/
        /*    z-index: 50;*/
        /*    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.05);*/
        /*}*/

        /*.nav-item {*/
        /*    display: flex;*/
        /*    flex-direction: column;*/
        /*    align-items: center;*/
        /*    text-decoration: none;*/
        /*    color: var(--text-secondary);*/
        /*    font-size: 0.75rem;*/
        /*    padding: 0.5rem 1rem;*/
        /*    transition: color 0.2s;*/
        /*}*/

        /*.nav-item.active {*/
        /*    color: #6232ba;*/
        /*}*/

        /*.nav-icon {*/
        /*    font-size: 1.5rem;*/
        /*    margin-bottom: 0.25rem;*/
        /*}*/

        /* Content with bottom nav */
        .content-with-nav {
            padding-bottom: 5rem;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: var(--success);
            color: white;
        }

        .badge-danger {
            background: var(--danger);
            color: white;
        }

        .badge-info {
            background: var(--info);
            color: white;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 200;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--bg-secondary);
            border-radius: 16px;
            padding: 1.5rem;
            max-width: 400px;
            width: 100%;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .modal-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-success { color: var(--success); }
        .text-danger { color: var(--danger); }
        .text-primary { color: var(--primary); }
        .text-secondary { color: var(--text-secondary); }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .items-center { align-items: center; }
        .gap-1 { gap: 0.5rem; }
        .gap-2 { gap: 1rem; }

                        /* Pagination container */
        .pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding-left: 0;
            list-style: none;
            gap: 6px;
        }

        /* Page item */
        .page-item {
            list-style: none;
        }

        /* Page link */
        .page-link {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            font-size: 14px;
            color: #7604c2;
            text-decoration: none;
            background-color: linear-gradient(135deg,rgba(118, 4, 194, 1) 100%, rgba(252, 176, 69, 1) 0%);
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        /* Hover */
        .page-link:hover {
            background-color: #e9ecef;
        }

        /* Active */
        .page-item.active .page-link {
            background-color: #7604c2;
            color: #fff;
            border-color: #7604c2;
            z-index: 2;
        }

        /* Disabled */
        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            opacity: 0.6;
        }

        @media (max-width: 576px) {
            .pagination {
                gap: 10px;
            }

            .page-item:not(.previous):not(.next):not(.active) {
                display: none;
            }

            .page-link {
                min-width: 44px;
                height: 44px;
                font-size: 15px;
            }
        }

        .today-quiz {
    border: 2px solid #0d6efd;
    background: linear-gradient(135deg, #e7f1ff, #ffffff);
    animation: pulseGlow 1.8s infinite;
    position: relative;
}

.today-quiz::before {
    content: "🔥 Today's Quiz";
    position: absolute;
    top: -12px;
    left: 12px;
    background: #0d6efd;
    color: #fff;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 6px;
}

@keyframes pulseGlow {
    0% {
        box-shadow: 0 0 0 rgba(13, 110, 253, 0.4);
    }
    50% {
        box-shadow: 0 0 18px rgba(13, 110, 253, 0.6);
    }
    100% {
        box-shadow: 0 0 0 rgba(13, 110, 253, 0.4);
    }
}


    </style>

    @stack('styles')
</head>
<body>
    @yield('content')

    <script>
        // CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
                .catch(err => console.log('Service Worker registration failed:', err));
        }
    </script>

    @stack('scripts')
</body>
</html>
