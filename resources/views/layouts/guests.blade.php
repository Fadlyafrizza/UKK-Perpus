<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}


    <style>
        @media print {
            body {
                font-size: 12px;
                margin: 20px;
                color: #000;
            }

            .sembunyikan {
                display: none !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin: 0 auto;
            }

            table th,
            table td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            thead {
                display: table-header-group;
            }

            tbody tr {
                page-break-inside: avoid;
            }

            tfoot {
                display: table-row-group;
            }
        }
    </style>





    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <main>
        <div class="py-6 mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

</body>

</html>
