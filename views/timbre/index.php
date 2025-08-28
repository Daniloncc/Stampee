{% if session.userId is defined %}
{{ include('layouts/header.php', {
    title: 'Timbres',
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
    lienJScript:'Timbre.js',
    lienEnchere: '/enchere/index'
    }) }}
{% else %}
{{ include('layouts/header.php', {
    title: 'Timbres',
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
    lienJScript:'Timbre.js',
    lienEnchere: '/enchere/index'
    }) }}
{% endif %}

<header class="entete">
    <picture>
        <img src="{{ asset }}/img/gerdarme_royale.jpg" alt="gerdarme royale">
    </picture>
    <div class="entete__opacite"></div>
    <div class="entete__contenu">
        <h1>Portail des Encheres</h1>
        <h2 class="italianno-regular">
            Le Lord Ronald Stampee
            <strong class="old-standard-tt-bold">III</strong>
        </h2>
        <p class="pompiere-regular">
            vous souhaite la bienvenue sur son prestigieux site d'enchères.
            Passionné et collectionneur depuis toujours, il est fier de vous
            proposer les plus rares et exquis timbres jamais vendus. Faites vos
            offres!
        </p>
    </div>
</header>
<!--  -->
<main>
    <section class="encheres__presentation">
        <header>
            <h2 class="pompiere-regular">
                <pre>{{ page }}</pre>
            </h2>
            <small class="quicksand">
                Tous les options | {{ timbres|length }} sur {{ timbres|length }}
            </small>
        </header>

        <div class="grille-cartes">
            {% for timbre in timbres %}
            <article class="carte" id="{{timbre.id}}">
                {% set found = false %}
                {% for image in images %}
                {% if not found and timbre.id == image.idTimbre and image.ordre == 0%}
                <picture>
                    <img src="{{ asset }}/img/{{ image.lien }}" alt="{{ timbre.titre }}">
                </picture>
                {% set found = true %}
                {% endif %}
                {% endfor %}

                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">{{timbre.titre}}</h3>
                    </header>
                    <div>
                        {% for pay in pays %}
                        {% if timbre.idPays == pay.id %}
                        <small>Pays : <strong>{{pay.pays}}</strong></small>
                        {% endif %}
                        {% endfor %}
                        {% for pay in pays %}

                        {% if timbre.idPays == pay.id %}
                        {% set PaysTimbre = pay.id %}
                        <small>Nombre reference: {{ pay.abreviation }}{{ timbre.dateCreation }}.{{ timbre.id }}</small>
                        {% endif %}
                        {% endfor %}

                        {% for certifie in certifies %}
                        {% if timbre.idCertifie == certifie.id %}
                        <small>Certifie : <strong>{{ certifie.certifie }}</strong></small>
                        {% endif %}
                        {% endfor %}

                        {% for couleur in couleurs %}
                        {% if timbre.idCouleur == couleur.id %}
                        <small>Couleur : <strong>{{ couleur.couleur }}</strong></small>
                        {% endif %}
                        {% endfor %}

                        {% for etat in etats %}
                        {% if timbre.idEtat == etat.id %}
                        <small>Condition : <strong>{{ etat.etat }}</strong></small>
                        {% endif %}
                        {% endfor %}

                        <small>Dimensions : <strong>{{timbre.dimensions}}</strong></small>
                    </div>
                    <footer>
                        {% set aEnchere = false %}
                        {# flag pour savoir si le timbre a une enchère #}
                        {% for enchere in encheres %}
                        {% if enchere.idTimbreEnchere == timbre.id %}
                        {% set aEnchere = true %}
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
                        <a href="{{ base }}/timbre/timbre?id={{timbre.id}}" class="button button-bleu">Voir <i class="fa-solid fa-arrow-right"></i></a>
                    </footer>

                </div>
            </article>

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

</main>

{{ include('layouts/footer.php') }}