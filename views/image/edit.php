{% if session.userId is defined %}
{{ include('layouts/header.php', {
    title: 'Editer Images',
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
    lienJScript:''

}) }}
{% endif %}

<main class="encheres">
    <section class="encheres__presentation encheres__presentation-gauche">
        <!-- <header>
            <h2 class="old-standard-tt-regular">
                {{ timbre.titre }}
            </h2>
        </header> -->
        <section class="timbre-images">
            <form action="{{ base }}/image/action" method="post" class="form" enctype="multipart/form-data">
                <label for="id"></label>
                <input type="hidden" id="id" name="id" value="{{ timbre.id }}">

                <div class="timbre__galerie-images">
                    {% for image in images %}
                    {% if image.ordre == 0 %}
                    <div>
                        <label for="image">Image Principale :</label>
                        <small>Titre: <strong>{{ image.image }}</strong></small>
                        <picture>
                            <img src="{{ asset }}/img/{{ image.lien }}" alt="{{ image.image }}">
                        </picture>
                        <input type="file" name="image" id="image" multiple accept="image/*">
                        {% if errors.images is defined %}
                        <span class="error">{{ errors.images }}</span>
                        {% endif %}

                    </div>
                    {% endif %}
                    {% endfor %}

                    {% for image in images %}
                    {% if image.ordre != 0 %}
                    <div>
                        <label for="images">Image Secondaire :</label>
                        <small>Titre: <strong>{{ image.image }}</strong></small>
                        <picture>
                            <img src="{{ asset }}/img/{{ image.lien }}" alt="{{ image.image }}">
                            <a class="button button-joune" href="{{ base }}/image/delete?id={{ image.id }}"><i class="fa-solid fa-trash"></i></a>
                        </picture>
                    </div>
                    {% endif %}
                    {% endfor %}
                </div>

                <input type="file" name="images[]" id="images" multiple accept="image/*">
                {% if errors.images is defined %}
                <span class="error">{{ errors.images }}</span>
                {% endif %}
                <button type="submit" class="button button-bleu">Modifier</button>
            </form>

        </section>
        <a class="button button-rouge" href="{{ base }}/timbre/timbre?id={{ timbre.id }}">← Retourner</a>
    </section>
</main>

{{ include('layouts/footer.php') }}