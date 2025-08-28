{% if session.userId is defined %}
{{ include('layouts/header.php', {
    title: 'Encheres',
    nav1: 'Lord Stampee III ▿',
    nav2: 'Enchères ▿',
    nav21: 'En vigueur',
    nav22: 'Archivée',
    nav23: 'Tous les Timbres',
    nav3: 'Aide ▿',
    nav4: 'Langue ▿',
    nav5: ' Échange ▿',
    nav6: 'Profil',
    nav7: 'Deconnecter',
    lien6: '/user/edit?id=' ~ session.userId,
    lien7: '/auth/logout',
    lienTimbre: '/timbre/create?id=' ~ session.userId,
    lienTimbres: '/timbre/index',
    lienJScript:'/enchere/Filtre.js',
    lienEnchere: '/enchere/index'
    }) }}
{% else %}
{{ include('layouts/header.php', {
    title: 'Encheres',
    nav1: 'Lord Stampee III ▿',
    nav2: 'Enchères ▿',
    nav21: 'En vigueur',
    nav22: 'Archivée',
    nav3: 'Aide ▿',
    nav4: 'Langue ▿',
    nav5: ' Échange ▿',
    nav6: 'Se connecter',
    nav7: 'Devenir Membre',
    lien6: '/auth/index',
    lien7: '/user/create',
    lienTimbre: '/timbre/create?id=' ~ session.userId,
    lienTimbres: '/timbre/index',
    lienJScript:'Timbre.js',
    lienEnchere: '/enchere/index'
    }) }}
{% endif %}

<header class="entete">
    <picture>
        <img src="{{ asset }}/img/gerdarme_royale.jpg" alt="Gendarme royal">
    </picture>
    <div class="entete__opacite"></div>
    <div class="entete__contenu">
        <h1>Portail des Enchères</h1>
        <h2 class="italianno-regular">
            Le Lord Ronald Stampee
            <strong class="old-standard-tt-bold">III</strong>
        </h2>
        <p class="pompiere-regular">
            vous ouvre les portes de son prestigieux site d'enchères.
            Collectionneur passionné depuis toujours, il est honoré de partager avec vous
            une sélection unique des timbres les plus rares et les plus raffinés jamais proposés.
            Saisissez votre chance, placez vos offres et enrichissez votre collection de véritables trésors.
        </p>
    </div>
</header>

<!--  -->
<main>
    <section class="presentation-pays">
        <picture class="medaillon">
            <img src="{{ asset }}/img/drapeau_anglaterre.jpeg" alt="drapeau anglaterre">
        </picture>
        <picture class="medaillon">
            <img src="{{ asset }}/img/drapeau_canada.jpeg" alt="{{ timbrePays.titre }}">
        </picture>
        <picture class="medaillon">
            <img src="{{ asset }}/img/drapeau_nouvelle_zelande.jpeg" alt="{{ timbrePays.titre }}">
        </picture>
        <picture class="medaillon">
            <img src="{{ asset }}/img/drapeau_etats_unis.jpeg" alt="{{ timbrePays.titre }}">
        </picture>
        <picture class="medaillon">
            <img src="{{ asset }}/img/drapeau_australie.jpeg" alt="{{ timbrePays.titre }}">
        </picture>
    </section>
    <!--  -->
    <section>
        <header class="flex-column flex-column-center">
            <picture>
                <img src="{{ asset }}/img/couronne.png" alt="couronne">
            </picture>
            <h2 class="italianno-regular">
                Nous avons des timbres de qualité pour vous
            </h2>
            <p class="pompiere-regular">
                Chaque pièce proposée sur Stampee III est soigneusement sélectionnée
                pour son authenticité et son raffinement. Que vous soyez un collectionneur
                passionné ou un amateur curieux, vous trouverez ici des trésors uniques
                dignes des plus grandes collections.
            </p>

        </header>
    </section>

    <!--  -->
    <div class="encheres">
        <aside>
            <form action="{{ base }}/enchere/index" method="post" class="filtres">
                <section class="filtre">
                    <header class="filtre__titre">
                        <h3>Pays</h3>
                    </header>
                    <ul class="filtre__options old-standard-tt-regular">
                        {% for pay in pays %}
                        <li>
                            <label name="pays"></label>
                            <input type="checkbox" name="pays[]" value="{{ pay.id }}">{{ pay.pays }}
                        </li>
                        {% endfor %}
                    </ul>
                </section>
                <section class="filtre">
                    <header class="filtre__titre">
                        <h3>Couleur</h3>
                    </header>
                    <ul class="filtre__options old-standard-tt-regular">
                        {% for couleur in couleurs %}
                        <li>
                            <label name="couleur"></label>
                            <input type="checkbox" name="couleur[]" value="{{ couleur.id }}">{{ couleur.couleur }}
                        </li>
                        {% endfor %}
                    </ul>
                </section>
                <section class="filtre">
                    <header class="filtre__titre">
                        <h3>Certifie</h3>
                    </header>
                    <ul class="filtre__options old-standard-tt-regular">
                        {% for certifie in certifies %}
                        <li>
                            <label name="certifie"></label>
                            <input type="checkbox" name="certifie[]" value="{{ certifie.id }}">{{ certifie.certifie }}
                        </li>
                        {% endfor %}
                    </ul>
                </section>
                <section class="filtre">
                    <header class="filtre__titre">
                        <h3>Condition</h3>
                    </header>
                    <ul class="filtre__options old-standard-tt-regular">
                        {% for Etat in etats %}
                        <li>
                            <label name="etat"></label>
                            <input type="checkbox" name="etat[]" value="{{ Etat.id }}">{{ Etat.etat }}
                        </li>
                        {% endfor %}
                    </ul>
                </section>
                <button class="button button-bleu">Apliquer</button>
            </form>
        </aside>
        <!--  -->
        <section class="encheres__presentation">

            <header>
                <h2 class="pompiere-regular">
                    <pre>{{ page }}</pre>
                </h2>
                <small class="quicksand"> Tous les options | {{ encheres|length }} sur {{ encheres|length }}</small>
            </header>
            <div class="grille-cartes">
                {% for enchere in encheres %}
                {# Chercher le timbre associé à cette enchère #}
                {% set timbreAssocie = null %}
                {% for timbre in timbres %}
                {% if timbre.id == enchere.idTimbreEnchere %}
                {% set timbreAssocie = timbre %}
                {% endif %}
                {% endfor %}
                {% if timbreAssocie %}
                <article class="carte" id="{{ timbreAssocie.id }}">
                    {% for image in images %}
                    {% if  timbreAssocie.id == image.idTimbre and image.ordre == 0 %}
                    <picture>
                        <img src="{{ asset }}/img/{{ image.lien }}" alt="{{ timbrePays.titre }}">
                    </picture>
                    {% endif %}
                    {% endfor %}
                    <div class="carte__contenu forme-enchere">
                        <!-- <i class="fa-solid fa-star preference"></i> -->
                        <header>
                            <h3 class="cinzel">{{ timbreAssocie.titre }}</h3>
                        </header>
                        <div>
                            {% for pay in pays %}
                            {% if timbreAssocie.idPays == pay.id %}
                            <small>Pays : <strong>{{ pay.pays }}</strong></small>
                            <small>Nombre reference: {{ pay.abreviation }}{{ timbreAssocie.dateCreation }}.{{ timbreAssocie.id }}</small>
                            {% endif %}
                            {% endfor %}
                            {% for certifie in certifies %}
                            {% if timbreAssocie.idCertifie == certifie.id %}
                            <small>Certifie : <strong>{{ certifie.certifie }}</strong></small>
                            {% endif %}
                            {% endfor %}
                            {% for couleur in couleurs %}
                            {% if timbreAssocie.idCouleur == couleur.id %}
                            <small>Couleur : <strong>{{ couleur.couleur }}</strong></small>
                            {% endif %}
                            {% endfor %}
                            {% for etat in etats %}
                            {% if timbreAssocie.idEtat == etat.id %}
                            <small>Condition : <strong>{{ etat.etat }}</strong></small>
                            {% endif %}
                            {% endfor %}
                            <small>Dimensions : <strong>{{ timbreAssocie.dimensions }}</strong></small>
                        </div>
                        <footer>
                            <small>
                                {% if enchere.dateFin|date('U') > "now"|date('U') %}
                                Termine: <strong>{{ enchere.dateFin|date("d/m/Y") }}</strong>
                                {% else %}
                                Terminée le: <strong class="error">{{ enchere.dateFin|date("d/m/Y") }}</strong>
                                {% endif %}
                            </small>
                            <a href="{{ base }}/timbre/timbre?id={{ timbreAssocie.id }}" class="button button-bleu">
                                Voir <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </footer>
                    </div>
                </article>
                {% endif %}
                {% endfor %}
            </div>
            <!--  -->
            <footer class="pagination">
                <span class="pagination__page">1</span>
                <span class="pagination__page">2</span>
                <span class="pagination__page">3</span>
                <span class="pagination__page">4</span>
                <span class="pagination__page">5</span>
            </footer>
        </section>
    </div>
    <!--  -->
    <div class="image">
        <section class="image-cote image-cote-gauche">
            <picture>
                <img src="{{ asset }}/img/SG_Old_Van1.png" alt="minivan">
            </picture>
            <div>
                <header>
                    <h3 class="pompiere-regular">Notre premier magasin</h3>
                </header>
                <hr>
                <p>
                    Stampee III a vu le jour comme un simple comptoir de timbres au sein d'une entreprise familiale en 1856, à Plymouth. Aujourd'hui, dans sa prestigieuse boutique du West End, Stampee III propose la plus vaste collection philatélique disponible au monde, avec plus d'un million de timbres à découvrir et à acquérir.
                </p>
            </div>
        </section>
        <!--  -->
        <hr class="separation">
        <!--  -->
        <section class="image-cote">
            <div>
                <header>
                    <h3 class="pompiere-regular">Nous garantissons des livraisons à temps</h3>
                </header>
                <hr>
                <p class="old-standard-tt-regular">
                    Sur notre plateforme, chaque enchère est synonyme de confiance et de sérénité.
                    Une fois votre timbre rare remporté, nous veillons à ce qu'il vous parvienne
                    rapidement et en toute sécurité. Nos partenaires de livraison spécialisés
                    assurent un suivi rigoureux afin que vos précieux trésors philatéliques arrivent
                    entre vos mains exactement comme vous les avez remportés.
                </p>
            </div>
            <picture>
                <img src="{{ asset }}/img/facteur.png" alt="facteur">
            </picture>
        </section>
    </div>


</main>

{{ include('layouts/footer.php') }}