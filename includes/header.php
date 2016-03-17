</head>
<body>
<header class="header">
    <a class="header1" href="http://localhost/proiect"> Fashion</a>
    <a href="#" class="icon"><img title="Vezi favorite" src="images/stelu.png"/></a>
    <a href="#" class="logare ">Favorite</a>
    <?php if (is_logged()) { ?>
        <a href="iesire" class="icon"><img alt="Logo" src="images/icon-cont-f.png" title="Iesire"/></a>
        <a href="iesire" class="logare">Iesire</a>
    <?php } else { ?>
        <a href="logare" class="icon"><img alt="Logo" src="images/icon-cont-f.png" title="Autentifica-te"/></a>
        <a href="logare" class="logare">Logare/Autentificare</a>
    <?php } ?>
    <div class="clear"></div>
</header>