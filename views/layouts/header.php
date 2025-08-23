<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Danilo Nunes Costa e Costa">
    <meta name="description" content="Projet - Enchères de timbres rares">
    <meta name="keywords" content="Enchère, timbre, collectionneurs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link
        href="https://fonts.googleapis.com/css2?family=Actor&family=Allura&family=Amatic+SC:wght@400;700&family=Archivo+Narrow:ital,wght@0,400..700;1,400..700&family=Belleza&family=Birthstone&family=Cinzel:wght@400..900&family=Edu+VIC+WA+NT+Hand:wght@400..700&family=Indie+Flower&family=Kings&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Lexend+Exa:wght@100..900&family=Lexend+Giga:wght@100..900&family=Lexend+Mega:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Pompiere&family=Quicksand:wght@300..700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- LINK CSS -->
    <link rel="stylesheet" href="{{ asset }}/css/style.css">
    <!-- LINK JS -->
    {% if lienJScript is defined %}
    <script src="{{ base }}/views/timbre/{{ lienJScript }}" defer></script>
    {% endif %}
    <title>{{ title }}</title>
</head>

<body>
    <nav class="navigation">
        <input type="checkbox" id="burger-toggle" hidden>

        <header class="navigation__secondaire">
            <div class="navigation__sous-menu">
                <ul>
                    <li><i class="fa-solid fa-phone"></i><a href="#"> +1(514)123-4567</a></li>
                    <li><i class="fa-solid fa-envelope"></i><a href="#"> stampeeIII@info.com</a></li>
                    <li>{% if session.userId is not defined %}<i class="fa-solid fa-arrow-right-to-bracket"></i>{% endif %}<a href="{{ base }}{{ lien6 }}">{{ nav6 }}</a></li>
                    <li><a href="{{ base }}{{ lien7 }}">{{ nav7 }}</a></li>
                </ul>
                <form action="#">
                    <input
                        aria-label="recherche"
                        type="text"
                        placeholder="Faites votre recherche">
                    <button>Rechercher</button>
                </form>
            </div>
        </header>

        <footer class="navigation__principale">
            <div class="navigation__logo">
                <picture class="logo">
                    <img src="{{ asset }}/img/logo.webp" alt="logo">
                </picture>
                <div class="navigation__titre">
                    <p class="italianno-regular">Lord Ronald</p>
                    <div>
                        <p class="italianno-regular">Stampee</p>
                        <p>III</p>
                    </div>
                    <small>La maison des collectionneurs</small>
                </div>
            </div>

            <div class="navigation__burger-wrapper">
                <label for="burger-toggle" class="navigation__burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>

            <ul class="navigation__options old-standard-tt-regular">
                <li class="menu-deroulant">
                    <a href="#">{{ nav1 }}</a>
                    <ul class="conteneur">
                        <li><a href="#">La philatélie, c'est la vie.</a></li>
                        <li><a href="#">Biographie du Lord</a></li>
                        <li><a href="#">Historique familial</a></li>
                    </ul>
                </li>

                {% if session.userId is defined %}
                <li class="menu-deroulant">
                    <a href="#">Timbre ▿</a>
                    <ul class="conteneur">
                        <li><a href="{{ base }}{{ lienTimbre }}">Ajouter Timbre</a></li>
                        <li><a href="#">Mes Favoris</a></li>
                        <li><a href="{{ base }}/timbre/mytimbres">Mes Timbres</a></li>
                        <li><a href="{{ base }}/timbre/index">Tous les Timbres</a></li>
                    </ul>
                </li>
                {% endif %}
                <li class="menu-deroulant">
                    <a href="#">{{ nav2 }}</a>
                    <ul class="conteneur">
                        <li><a href="{{ base }}{{ lienEnchere }}?condition=envigueur">{{ nav21 }}</a></li>
                        <li><a href="{{ base }}{{ lienEnchere }}?condition=archivee">{{ nav22 }}</a></li>
                        <li><a href="{{ base }}/enchere/index">Tous les Encheres</a></li>
                    </ul>
                </li>
                <li class="menu-deroulant">
                    <a href="#">{{ nav3 }}</a>
                    <ul class="conteneur">
                        <li><a href="#">Profil</a></li>
                        <li><a href="#">Comment placer une offre</a></li>
                        <li><a href="#">Suivre une enchère</a></li>
                        <li><a href="#">Trouver l'enchère désirée</a></li>
                        <li><a href="#">Contacter le webmestre</a></li>
                    </ul>
                </li>
                <li class="menu-deroulant">
                    <a href="#"><i class="fa-solid fa-globe"></i> {{ nav4 }}</a>
                    <ul class="conteneur">
                        <li><a href="#">Français</a></li>
                        <li><a href="#">Anglais</a></li>
                    </ul>
                </li>
                <li class="menu-deroulant">
                    <a href="#"><i class="fa-solid fa-dollar-sign"></i> {{ nav5 }}</a>
                    <ul class="conteneur">
                        <li><a href="#">Libres</a></li>
                        <li><a href="#">Dollar Canadien</a></li>
                        <li><a href="#">Dollar Américain</a></li>
                        <li><a href="#">Dollar Australién</a></li>
                    </ul>
                </li>
            </ul>
        </footer>
    </nav>