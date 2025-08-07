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

}) }}
{% endif %}
<header>
    <h1 class="quicksand">Bonjour, {{ user.prenom }}</h1>
</header>

<main class="main__form">
    <!-- si je ne mets pas un action je reviens a la meme page -->
    <form method="post" class="form">
        <header>
            <h2 class="quicksand">Editez votre profil</h2>
            <hr>
        </header>
        <input class="form__input" type="hidden" name="id" id="id" value="{{ user.id }}">
        <div class="form__contenu">
            <lablel class="form__label">Nom :</lablel>
            <input class="form__input" type="text" name="nom" id="nom" value="{{ user.nom }}">
            {% if errors.nom is defined %}
            <span class="error">{{errors.nom}}</span>
            {% endif %}
        </div>
        <div class="form__contenu">
            <lablel class="form__label">Prenom :</lablel>
            <input class="form__input" type="text" name="prenom" id="prenom" value="{{ user.prenom }}">
            {% if errors.prenom is defined %}
            <span class="error">{{errors.prenom}}</span>
            {% endif %}
        </div>
        <div class="form__contenu">
            <lablel class="form__label">Adresse :</lablel>
            <input class="form__input" type="text" name="adresse" id="adresse" value="{{ user.adresse }}">
            {% if errors.adresse is defined %}
            <span class="error">{{errors.adresse}}</span>
            {% endif %}
        </div>
        <div class=" form__contenu">
            <lablel class="form__label">Telephone :</lablel>
            <input class="form__input" type="text" name="telephone" id="telephone" value="{{ user.telephone }}">
            {% if errors.telephone is defined %}
            <span class="error">{{errors.telephone}}</span>
            {% endif %}
        </div>
        <div class="form__contenu">
            <lablel class="form__label">Courriel :</lablel>
            <input class="form__input" type="text" name="courriel" id="courriel" value="{{ user.courriel }}">
            {% if errors.courriel is defined %}
            <span class="error">{{errors.courriel}}</span>
            {% endif %}
        </div>
        {% if message is defined %}
        <span class="error">{{message}}</span>
        {% endif %}
        <button type="submit" class="button button-bleu">Modifier</button>
        <div>
            <a class="button button-rouge" href="{{ base }}/user/show?id={{ user.id }}">Retourner</a>
        </div>
    </form>
</main>

{{ include('layouts/footer.php') }}