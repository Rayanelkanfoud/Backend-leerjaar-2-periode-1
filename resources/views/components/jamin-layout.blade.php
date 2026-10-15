@props(['title', 'refreshUrl' => null, 'refreshSeconds' => null])
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Jamin</title>
    @if ($refreshUrl)
        <meta http-equiv="refresh" content="{{ $refreshSeconds }};url={{ $refreshUrl }}">
    @endif
    <style>
        * { box-sizing: border-box; }
        body { margin: 32px; color: #111; background: #fff; font: 16px Arial, sans-serif; }
        main { max-width: 1400px; margin: 0 auto; }
        h1 { margin: 0 0 28px; font-size: 30px; font-weight: 500; text-decoration: underline; }
        .table-scroll { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 16px; border: 1px solid #444; text-align: left; vertical-align: middle; }
        th { font-weight: 600; }
        .number, .action { text-align: center; }
        .icon { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #111; }
        .icon svg { width: 27px; height: 27px; }
        a:focus-visible, button:focus-visible, input:focus-visible { outline: 3px solid #145c9e; outline-offset: 3px; }
        .details { display: grid; grid-template-columns: max-content 1fr; gap: 12px 28px; margin: 0 0 32px; }
        dt, dd { margin: 0; }
        .buttons { display: flex; justify-content: flex-end; gap: 20px; margin-top: 28px; }
        .button { display: inline-block; border: 1px solid #444; padding: 10px 32px; background: #fff; color: #111; text-decoration: none; font: inherit; cursor: pointer; }
        .button:hover { background: #eee; }
        .message { padding: 24px; text-align: center; }
        .fields { display: grid; grid-template-columns: max-content minmax(180px, 320px); gap: 20px 28px; align-items: center; margin: 50px 0 32px; }
        input { width: 100%; min-height: 40px; padding: 8px; border: 1px solid #444; font: inherit; }
        .form-buttons { justify-content: space-between; max-width: 800px; }
        .form-buttons div { display: flex; gap: 20px; }
        .error { color: #a11; margin-top: 8px; }
        @media (max-width: 600px) {
            body { margin: 18px; }
            .fields { grid-template-columns: 1fr; gap: 12px; }
            .details { gap: 12px; }
            .button { padding: 10px 18px; }
        }
    </style>
</head>
<body>
    <main>
        <h1>{{ $title }}</h1>
        {{ $slot }}
    </main>
</body>
</html>
