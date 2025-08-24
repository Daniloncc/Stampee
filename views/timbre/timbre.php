{% if session.userId is defined %}
{{ include('layouts/header.php', {
    title: 'Timbre',
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
    lienJScript:'TimbreZoom.js',
    lienEnchere: '/enchere/index'
    }) }}
{% else %}
{{ include('layouts/header.php', {
    title: 'Timbre',
    nav1: 'Lord Stampee III ▿',
    nav2: 'Enchères ▿',
    nav21: 'En vigueur',
    nav22: 'Archivée',
    nav23: 'Tous les Timbres',
    nav3: 'Aide ▿',
    nav4: 'Langue ▿',
    nav5: ' Échange ▿',
    nav6: 'Se connecter',
    nav7: 'Devenir Membre',
    lien6: '/auth/index',
    lien7: '/user/create',
    lienTimbre: '/timbre/create?id=' ~ session.userId,
    lienTimbres: '/timbre/index',
    lienJScript:'TimbreZoom.js',
    lienEnchere: '/enchere/index'
    }) }}
{% endif %}

<main class="encheres">
    <section class="encheres__presentation encheres__presentation-gauche">
        <section class="timbre">
            <div id="myresult" class="img-zoom-result"></div>
            <div class="timbre__galerie">

                {# Image principale (première) #}
                {% for image in images %}
                {% if image.ordre == 0 %}
                <picture class="img-zoom-container">
                    <img id="myimage" src="{{ asset }}/img/{{ image.lien }}" alt="{{ image.image }}">
                </picture>
                {% endif %}
                {% endfor %}

                {# Galerie des autres images #}
                <div class="timbre__galerie-petit">
                    {% for image in images %}
                    {% if image.ordre != 0 %}
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
                    {% set PaysTimbre = pay.id %}
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

                            {% set aEnchere = false %}
                            {# flag pour savoir si le timbre a une enchère #}
                            {% for enchere in encheres %}
                            {% if enchere.idTimbreEnchere == timbre.id %}
                            {% set aEnchere = true %}

                            {% if mise is defined %}
                            <small>Prix : <strong>{{ mise.prix }} $</strong></small>
                            {% endif %}

                            <small>
                                {% if enchere.dateFin|date('U') > "now"|date('U') %}
                                Termine: <strong>{{ enchere.dateFin|date("d/m/Y") }}</strong>
                                {% else %}
                                Terminée le: <strong class="error">{{ enchere.dateFin|date("d/m/Y") }}</strong>
                                {% endif %}
                            </small>
                            {% endif %}
                            {% endfor %}
                        </footer>
                        {% if session.userId is defined and session.userId == timbre.idUtilisateur %}
                        <a href="{{ base }}/timbre/edit?id={{timbre.id}}" class="button button-bleu">Editer Timbre <i class="fa-solid fa-arrow-right"></i></a>
                        {% else %}
                        {% if session.userId is defined %}

                        {% set aEnchere = false %}
                        {# flag pour savoir si le timbre a une enchère #}
                        {% for enchere in encheres %}
                        {% if enchere.idTimbreEnchere == timbre.id %}
                        {% set aEnchere = true %}
                        {% if enchere.dateFin|date('U') > "now"|date('U') %}
                        <div class="flex-column">
                            <form action="" class="timbre__favoris">
                                <label class="form__label" for="favorit"></label>
                                <input class="form__input" type="hidden" name="favorit" id="favorit" value="{{ timbre.prix|default('') }}">
                                <button>Placer aux Favoris <i class="fa-solid fa-star"></i></button>
                            </form>

                            <form action="{{ base }}/mise/index?id={{ timbre.id }}" method="post" class="offre">
                                <button class="button button-bleu"><i class="fa-solid fa-gavel"></i> Placer une offre</button>
                                <div class="form__contenu">
                                    <input type="hidden" name="idEnchereMise" id="idEnchereMise" value="{{ enchere.id }}">
                                    <input type="hidden" name="idUtilisateurMise" id="idUtilisateurMise" value="{{ session.userId}}">
                                    <div>
                                        <label class="form__label" for="prix">Valeur:</label>
                                        {% if mise is defined %}
                                        <input class="form__input" type="text" name="prix" id="prix" value="{{ mise.prix }} " placeholder="Ex : 19,99">
                                        {% else %}
                                        <input class="form__input" type="text" name="prix" id="prix" value="{{ timbre.prix|default('') }}" placeholder="Ex : 19,99">
                                        {% endif %}

                                    </div>
                                    {% if errors.prix is defined %}
                                    <span class="error">{{ errors.prix }}</span>
                                    {% endif %}
                                </div>
                            </form>
                        </div>
                        {% endif %}
                        {% endif %}
                        {% endfor %}

                        {% endif %}
                        {% endif %}
                    </div>
                </div>
            </div>
        </section>
        <a class="button button-rouge" href="{{ base }}/timbre/index">← Retourner</a>
        <!--  -->
        <header>
            <h2 class="old-standard-tt-regular">D'autres options similaires par pays</h2>
        </header>
        <div class="grille-cartes">
            {% for timbrePays in timbres %}
            {% if timbrePays.idPays == timbre.idPays %}
            <article class="carte" id="{{timbrePays.id}}">
                {% set found = false %}
                {% for image in imagesTimbres %}
                {% if not found and timbrePays.id == image.idTimbre and image.ordre == 0 %}
                <picture>
                    <img src="{{ asset }}/img/{{ image.lien }}" alt="{{ timbrePays.titre }}">
                </picture>
                {% set found = true %}
                {% endif %}
                {% endfor %}

                <div class="carte__contenu forme-enchere">
                    <i class="fa-solid fa-star preference"></i>
                    <header>
                        <h3 class="cinzel">{{timbrePays.titre}}</h3>
                    </header>
                    <div>
                        {% for pay in pays %}
                        {% if timbrePays.idPays == pay.id %}
                        <small>Pays : <strong>{{pay.pays}}</strong></small>
                        {% endif %}
                        {% endfor %}
                        <small>Prix : <strong>{{timbrePays.prix}}</strong></small>
                        <small>Dimensions : <strong>{{timbrePays.dimensions}}</strong></small>
                    </div>
                    <footer>
                        {% set aEnchere = false %}
                        {# flag pour savoir si le timbrePays a une enchère #}
                        {% for enchere in encheres %}
                        {% if enchere.idTimbreEnchere == timbrePays.id %}
                        {% set aEnchere = true %}
                        <small>Prix : <strong>Actuel</strong></small>
                        <div>|</div>
                        <small>
                            {% if enchere.dateFin|date('U') > "now"|date('U') %}
                            Termine: <strong>{{ enchere.dateFin|date("d/m/Y") }}</strong>
                            {% else %}
                            Terminée le: <strong class="error">{{ enchere.dateFin|date("d/m/Y") }}</strong>
                            {% endif %}
                        </small>
                        {% endif %}
                        {% endfor %}

                        {% if not aEnchere %}
                        <small>
                            Pas encore disponible <strong class="error"></strong>
                        </small>
                        {% endif %}
                    </footer>
                    <a href="{{ base }}/timbre/timbre?id={{timbrePays.id}}" class="button button-bleu">Voir <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </article>
            {% endif %}
            {% endfor %}
        </div>
        <!-- <footer class="pagination">
            <span class="pagination__page">1</span>
            <span class="pagination__page">2</span>
            <span class="pagination__page">3</span>
            <span class="pagination__page">4</span>
            <span class="pagination__page">5</span>
        </footer> -->
    </section>

</main>

{{ include('layouts/footer.php') }}