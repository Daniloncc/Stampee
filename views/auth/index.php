{{ include('layouts/header.php', {
    title: 'Connectez-
    vous',
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
    lienEnchere: '/enchere/index'

}) }}


<main class="main__form">
    <form action="{{base}}/auth/index" method="post" class="form">
        <header>
            <h2 class="italianno-regular">Connectez-vous</h2>
            <hr>
        </header>

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
        {% if errors is defined %}
        <span class="error">{{errors.message}}</span>
        {% endif %}
        <button type="submit" class="button button-bleu">Connecter →</button>
    </form>
</main>

{{ include('layouts/footer.php') }}