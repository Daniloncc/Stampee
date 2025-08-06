{{ include('layouts/header.php', {
    title: 'Bienvenue',
    nav1: 'Lord Stampee III ▿',
    nav2: 'Enchères ▿',
    nav21: 'En vigueur',
    nav22: 'Archivée',
    nav3: 'Aide ▿',
    nav4: 'Langue ▿',
    nav5: ' Échange ▿',
    nav6: 'Se connecter',
    nav7: 'Devenir Membre',
    lien1: '#',
    lien2: '/user/create',
    lien3: '/auth/index',
    lien2: '/user/create',
    lien3: '/auth/index',

}) }}
<!-- <header class="entete entete-accueil">
    <picture>
        <img src="{{ asset }}/img/gerdarme_royale.jpg" alt="gerdarme royale">
    </picture>
    <div class="entete__opacite"></div>
    <div class="entete__contenu">
        <h1 class="italianno-regular">create <strong class="old-standard-tt-bold">III</strong></h1>
        <p class="pompiere-regular">
            vous souhaite la bienvenue sur son prestigieux site d'enchères.
            Passionné et collectionneur depuis toujours, il est fier de vous
            proposer les plus rares et exquis timbres jamais vendus. Faites vos
            offres!
        </p>
    </div>
</header> -->
<main class="main__form">
    <form action="{{base}}/user/store" method="post" class="form">
        <header>
            <h2 class="italianno-regular">Creez votre compte</h2>
            <hr>
        </header>
        <div class="form__contenu">
            <lablel class="form__label">Nom :</lablel>
            <input class="form__input" type="text" name="nom" id="nom" value="{{user.nom}}" placeholder="Min 2 lettres, Max 25">
            {% if errors.nom is defined %}
            <span class="error">{{errors.nom}}</span>
            {% endif %}
        </div>
        <div class="form__contenu">
            <lablel class="form__label">Prenom :</lablel>
            <input class="form__input" type="text" name="prenom" id="prenom" value="{{user.prenom}}" placeholder="Min 2 lettres, Max 25">
            {% if errors.prenom is defined %}
            <span class="error">{{errors.prenom}}</span>
            {% endif %}
        </div>
        <div class="form__contenu">
            <lablel class="form__label">Adresse :</lablel>
            <input class="form__input" type="text" name="adresse" id="adresse" value="{{user.adresse}}" placeholder="Votre adresse complet">
            {% if errors.adresse is defined %}
            <span class="error">{{errors.adresse}}</span>
            {% endif %}
        </div>
        <div class="form__contenu">
            <lablel class="form__label">Telephone :</lablel>
            <input class="form__input" type="text" name="telephone" id="telephone" value="{{user.telephone}}" placeholder="Format: 1234567890">
        </div>
        {% if errors.telephone is defined %}
        <span class="error">{{errors.telephone}}</span>
        {% endif %}
        <div class="form__contenu">
            <lablel class="form__label">Courriel :</lablel>
            <input class="form__input" type="text" name="courriel" id="courriel" value="{{user.courriel}}" placeholder="Format: courriel@courriel.com">
            {% if errors.courriel is defined %}
            <span class="error">{{errors.courriel}}</span>
            {% endif %}
            {% if message is defined %}
            <span class="error">{{message}}</span>
            {% endif %}
        </div>
        <div class="form__contenu">
            <lablel class="form__label">Mot de passe:</lablel>

            <input class="form__input" type="password" name="motPasse" id="motPasse"
                {% if user.motPasse is not defined %}
                value=""
                {% endif %}
                placeholder="Min 3, Max 8. Vous devez avoir des chiffres et lettres">

            {% if errors.motPasse is defined %}
            <span class="error">{{errors.motPasse}}</span>
            {% endif %}
        </div>
        <button type="submit" class="button">Creer →</button>
    </form>
</main>


{{ include('layouts/footer.php') }}