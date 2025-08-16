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
    lienJScript:'Timbre.js'

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
            {% for timbre in timbres %}
            {% if session.userId == timbre.idUtilisateur %}
            <article class="carte" id="{{timbre.id}}">
                <i class="fa-solid fa-star preference"></i>
                {% set found = false %}
                {% for image in images %}
                {% if not found and timbre.id == image.idTimbre %}
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
                        <!-- <h4 class="old-standard-tt-regular">${description}...</h4> -->

                        {% for pay in pays %}
                        {% if timbre.idPays == pay.id %}
                        <small>Pays : <strong>{{pay.pays}}</strong></small>
                        {% endif %}
                        {% endfor %}
                        <small>Prix : <strong>{{timbre.prix}}</strong></small>
                        <small>Dimensions : <strong>${timbre.dimensions}</strong></small>
                    </div>
                    <footer>
                        <small>Prix : <strong>{{timbre.prix}}</strong></small>
                        <div>|</div>
                        <small>Temps restant s: <strong>{{timbre.prix}}</strong></small>
                        <a hrtf="/STAMPEE/mvc/timbre/timbre?id=${timbre.id}" class="button button-bleu">Voir plus <i class="fa-solid fa-arrow-right"></i></a>
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
</main>



{{ include('layouts/footer.php') }}