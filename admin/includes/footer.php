<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensure the body takes at least the full height of the viewport */
            margin: 0; /* Remove default margin */
        }

        .container {
            flex: 1; /* Allow the container to grow and take remaining space */
        }

        footer {
            padding: 10px;
            margin-top: auto; /* Push the footer to the bottom */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Your content goes here -->
    </div>

    <footer>
        &copy; <?php echo date('Y');?> Online Course Registration
    </footer>
</body>
</html>
