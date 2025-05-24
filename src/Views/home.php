<!<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Kufi+Arabic&family=Noto+Sans+Arabic:wght@100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="src/Views/css/style.css">

    </head>
    <body>
     
    <?php foreach ($data['users'] as $user):?>
     <ul id="list">
        <li>My Name is: <?=  $user['u_name'];  ?></li>
        <li>My Cred is: <?=  $user['u_pwd'];  ?></li>
        <li>Creation date: <?=  $user['u_cdate'];  ?></li>
     </ul>

     <?php endforeach; ?>
    </body>
</html>