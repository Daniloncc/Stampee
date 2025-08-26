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
    lienJScript:'Timbre.js',
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
<main class="encheres">
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
                        <input type="checkbox" name="pays[]" value="{{ pay.pays }}">{{ pay.pays }}
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
                        <input type="checkbox" name="couleur[]" value="{{ couleur.couleur }}">{{ couleur.couleur }}
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
                        <input type="checkbox" name="certifie[]" value="{{ certifie.certifie }}">{{ certifie.certifie }}
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
                        <input type="checkbox" name="etat[]" value="{{ Etat.etat }}">{{ Etat.etat }}
                    </li>
                    {% endfor %}
                </ul>
            </section>

            <section class="filtre">
                <header class="filtre__titre">
                    <h3>Encheres</h3>
                </header>
                <ul class="filtre__options old-standard-tt-regular">
                    <li>
                        <label name="archivee"></label>
                        <input type="checkbox" name="archivee" value="archivee">Archivee
                    </li>
                    <li>
                        <label name="envigueur"></label>
                        <input type="checkbox" name="envigueur" value="envigueur">En vigeur
                    </li>
                </ul>
            </section>

            <section class="filtre">
                <header class="filtre__titre">
                    <h3>Preferences du Lord</h3>
                </header>
                <ul class="filtre__options old-standard-tt-regular">
                    {% for pay in pays %}
                    <li>
                        <label name="lord"></label>
                        <input type="checkbox" name="lord" value="{{ pay.pays }}">{{ pay.pays }}
                    </li>
                    {% endfor %}
                </ul>
            </section>

            <!-- <section class="filtre">
                <header class="filtre__titre">
                    <h3>Prix</h3>
                </header>

                <div class="filtre__gamme">
                    <input
                        type="range"
                        min="0.01"
                        max="3257.41"
                        value="1200"
                        step="0.01"
                        class="filtre__gamme--barre"
                        id="prixGamme">
                    <div class="filtre__valeurs quicksand">
                        <span>00.01</span>
                        <span>1.200,01</span>
                        <span>3.257,41</span>
                    </div>
                </div>
            </section> -->

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

                {% set found = false %}
                {% for image in images %}
                {% if not found and timbreAssocie.id == image.idTimbre and image.ordre == 0 %}
                <picture>
                    <img src="{{ asset }}/img/{{ image.lien }}" alt="{{ timbrePays.titre }}">
                </picture>
                {% set found = true %}
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
                        {% if timbre.idPays == pay.id %}

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
                    </footer>

                    <a href="{{ base }}/timbre/timbre?id={{ timbreAssocie.id }}" class="button button-bleu">
                        Voir <i class="fa-solid fa-arrow-right"></i>
                    </a>
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
</main>

{{ include('layouts/footer.php') }}