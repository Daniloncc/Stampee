{% if session.userId is defined %}
{{ include('layouts/header.php', {
    title: 'Creez votre compte',
    nav1: 'Lord Stampee III ▿',
    nav2: 'Enchères ▿',
    nav21: 'En vigueur',
    nav22: 'Archivée',
    nav3: 'Aide ▿',
    nav4: 'Langue ▿',
    nav5: ' Échange ▿',
    nav6: 'Profil',
    nav7: 'Deconnecter',
    lien6: '/user/edit?id=' ~ session.userId,
    lien7: '/auth/logout',
    lien8: '/timbre/index',
    lienJScript:'Timbre.js',
    lienTimbre: '/timbre/create?id=' ~ session.userId,
    lienTimbres: '/timbre/index',
    lienJScript:'TimbreZoom.js'

}) }}
{% endif %}

<main class="encheres">
    <section class="encheres__presentation encheres__presentation-gauche">
        <!-- <header>
            <h2 class="old-standard-tt-regular">
                {{ timbre.titre }}
            </h2>
        </header> -->
        <section class="timbre">
            <div id="myresult" class="img-zoom-result"></div>
            <div class="timbre__galerie">

                {# Image principale (première) #}
                {% for image in images %}
                {% if timbre.id == image.idTimbre and loop.first %}
                <picture class="img-zoom-container">
                    <img id="myimage" src="{{ asset }}/img/{{ image.lien }}" alt="{{ image.image }}">

                </picture>
                {% endif %}
                {% endfor %}

                {# Galerie des autres images #}
                <div class="timbre__galerie-petit">
                    {% for image in images %}
                    {% if timbre.id == image.idTimbre and not loop.first %}
                    <picture>
                        <img src="{{ asset }}/img/{{ image.lien }}" alt="{{ image.image }}">
                    </picture>
                    {% endif %}
                    {% endfor %}
                </div>
            </div>
            <div class="timbre__contenu forme-enchere">
                <header>
                    <h3 class="cinzel">{{ timbre.titre }}</h3>
                </header>
                <div>
                    <!-- <h4 class="old-standard-tt-regular">Faune Endémique de Nouvelle-Zélande</h4> -->
                    {% for pay in pays %}
                    {% if timbre.idPays == pay.id %}
                    <small>Nombre reference: {{ pay.abreviation }}{{ timbre.dateCreation }}.{{ timbre.id }}</small>
                    {% endif %}
                    {% endfor %}
                    <p class="quicksand">
                        {{ timbre.description }}
                    </p>
                    <div class="flex-row">
                        <footer>
                            <small>Prix Base: <strong>${{ timbre.prix }}</strong></small>
                            {% for pay in pays %}
                            {% if timbre.idPays == pay.id %}
                            <small>Pays: <strong>{{ pay.pays }}</strong></small>
                            {% endif %}
                            {% endfor %}
                            {% for etat in etats %}
                            {% if timbre.idEtat == etat.id %}
                            <small>Condition: <strong>{{ etat.etat }}</strong></small>
                            {% endif %}
                            {% endfor %}
                            <small>Tirage: <strong>{{ timbre.tirage }}</strong></small>
                            <small>Dimensions: <strong>{{ timbre.dimensions }}</strong></small>
                            {% for certifie in certifies %}
                            {% if timbre.idCertifie == certifie.id %}
                            <small>Certifie: <strong>{{ certifie.certifie }}</strong></small>
                            {% endif %}
                            {% endfor %}
                            {% for couleur in couleurs %}
                            {% if timbre.idCouleur == couleur.id %}
                            <small>Couleur: <strong>{{ couleur.couleur }}</strong></small>
                            {% endif %}
                            {% endfor %}

                            <small>Prix Actuel: <strong>faire logique</strong></small>
                            <small>Temps restant: <strong>faire logique 2</strong></small>
                        </footer>
                        {% if session.userId is defined and session.userId == timbre.idUtilisateur %}
                        <a href="{{ base }}/timbre/edit?id={{timbre.id}}" class="button button-bleu">Editer Timbre <i class="fa-solid fa-arrow-right"></i></a>
                        {% else %}
                        <div class="flex-column">
                            <div class="timbre__favoris">
                                <small>Placer aux Favoris</small> <i class="fa-solid fa-star"></i>
                            </div>
                            <button class="button button-bleu"><i class="fa-solid fa-gavel"></i> Placer une offre</button>
                        </div>
                        {% endif %}
                    </div>
                </div>
            </div>
        </section>
        <a class="button button-rouge" href="{{ base }}/timbre/index">← Retourner</a>
        <header>
            <h2 class="old-standard-tt-regular">D'autres options similaires</h2>
        </header>
        <div class="grille-cartes">

            <article class="carte">
                <picture>
                    <img src="./assets/img/eliot_british.webp" alt="timbre Lord Anglais">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Lord Eliot 1927</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Portraits de l’Aristocratie Britannique</h4>
                        <small>Stock Code: GBR1927E001</small>
                    </div>
                    <footer>
                        <small><strong>$490</strong></small>
                        <div>|</div>
                        <small>1 jour restant</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <picture>
                    <img src="./assets/img/elisabeth_1th.webp" alt="timbre Elisabeth I">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Elisabeth Ière 1588</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Dynastie Tudor en Philatélie</h4>
                        <small>Stock Code: GBR1588E001</small>
                    </div>
                    <footer>
                        <small><strong>$325</strong></small>
                        <div>|</div>
                        <small>3 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <picture>
                    <img src="./assets/img/migration_oeseaux.webp" alt="timbre migration oiseaux">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Oiseaux Migrateurs 1981</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Réserve Ornithologique Internationale</h4>
                        <small>Stock Code: INT1981M001</small>
                    </div>
                    <footer>
                        <small><strong>$42</strong></small>
                        <div>|</div>
                        <small>4 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <picture>
                    <img src="./assets/img/omnibus_1880.webp" alt="Timbre omnibus 1880">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Omnibus Impérial 1880</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Transport Urbain Victorien</h4>
                        <small>Stock Code: UKG1880O001</small>
                    </div>
                    <footer>
                        <small><strong>$88</strong></small>
                        <div>|</div>
                        <small>6 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>
        </div>
        <footer class="pagination">
            <span class="pagination__page">1</span>
            <span class="pagination__page">2</span>
            <span class="pagination__page">3</span>
            <span class="pagination__page">4</span>
            <span class="pagination__page">5</span>
        </footer>
    </section>
</main>

{{ include('layouts/footer.php') }}