<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hosting System</title>

     @vite(['resources/js/app.js']) {{-- botar o css se for necessario --}}
<style>
    body {
        margin: 0;
        padding: 0;
        border: none;
    }
</style>
      
</head>
<body class="antialiased">
    <div id="app" class="margin:0"> {{-- Elemento com o id "app" --}}
        <app-component></app-component>
    </div>
</body>
</html>
