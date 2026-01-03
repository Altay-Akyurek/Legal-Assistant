<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sanal Hukuk Asistanı') - Türkiye Cumhuriyeti Anayasası</title>
       <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --warning-color: #f59e0b;
            --danger-color: #dc2626;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .legal-warning {
            background-color: #fff3cd;
            border-left: 4px solid var(--warning-color);
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 4px;
        }
        
        .legal-warning strong {
            color: var(--danger-color);
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            font-weight: 600;
            border-radius: 8px 8px 0 0 !important;
        }
        
        .article-card {
            border-left: 4px solid var(--secondary-color);
            transition: transform 0.2s;
        }
        
        .article-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .article-number {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .footer {
            background-color: #343a40;
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    
</body>
</html>