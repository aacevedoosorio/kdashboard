<html>
    <head>
        <title>We've got a message for you!</title>
        <style type="text/css">
            body {font-family: Georgia;}
            h1 {font-style: italic;}
 
        </style>
    </head>
    <body>
        <h1><?php echo $message; ?></h1>
        <?php print (isset($content)?$content:"") ?>
    </body>
</html>
