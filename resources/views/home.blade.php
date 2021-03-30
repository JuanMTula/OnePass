<!DOCTYPE html>

  <html>
    <head>
        <title>OnePass</title>
        <link rel="icon"  type="image/png"  href="./includes/favicon.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="title" content="OnePass">
        <meta name="description" content="Password keeper">
        <meta name="author" content="Juan Manuel Tula">
        <link rel="stylesheet" href="./css/app.css">

    </head>
    <body class="sl-theme-dark">
        <div id="app">

            <router-view></router-view>
        </div>

      <script src="./js/app.js"></script>

      @include('includes.routes')

    </body>

  </html>
