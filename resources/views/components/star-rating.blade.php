<!-- resources/views/index.blade.php -->
<html>
    <head>
        <title>Index Page</title>
    </head>
    <body>
        <h1>Welcome to the Index Page</h1>
        <x-star-rating :rating="$rating" />
    </body>
</html>