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

    <section class="encheres__presentation">
        <header>
            <h2 class="pompiere-regular">
                <pre>{{ page }}</pre>
            </h2>
            <small class="quicksand">Tous les options | 12 sur 231</small>
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

                {# Chercher la première image du timbre #}
                {% set imageTrouvee = null %}
                {% for image in images %}
                {% if image.idTimbre == timbreAssocie.id and imageTrouvee is null and imageTrouvee == 0 %}
                {% set imageTrouvee = image %}
                {% endif %}
                {% endfor %}

                {% if imageTrouvee %}
                <picture>
                    <img src="{{ asset }}/img/{{ imageTrouvee.lien }}" alt="{{ imageTrouvee.image }}">
                </picture>
                {% endif %}

                <div class="carte__contenu forme-enchere">
                    <i class="fa-solid fa-star preference"></i>
                    <header>
                        <h3 class="cinzel">{{ timbreAssocie.titre }}</h3>
                    </header>
                    <div>
                        {% for pay in pays %}
                        {% if timbreAssocie.idPays == pay.id %}
                        <small>Pays : <strong>{{ pay.pays }}</strong></small>
                        {% endif %}
                        {% endfor %}
                        <small>Prix : <strong>{{ timbreAssocie.prix }}</strong></small>
                        <small>Dimensions : <strong>{{ timbreAssocie.dimensions }}</strong></small>
                    </div>
                    <footer>
                        <small>Prix : <strong>Actuel</strong></small>
                        <div>|</div>
                        <small>
                            {% if condition == 'envigueur' %}
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