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

<!-- <header>
    <h1 class="quicksand">Ajouter <strong class="pompiere">Un Timbre</strong></h1>
</header> -->

<main class="main__form">

    <form action="{{ base }}/timbre/index" method="post" class="form" enctype="multipart/form-data">
        <header>
            <h2 class="quicksand">Ajouter un Timbre</h2>
            <hr>
        </header>

        <label for="idUtilisateur"></label>
        <input class="form__input" type="hidden" name="idUtilisateur" id="idUtilisateur" value="{{ session.userId }}">

        <div class="form__contenu">
            <label class="form__label" for="titre">Titre :</label>
            <input class="form__input" type="text" name="titre" id="titre" value="{{ timbre.titre|default('') }}" placeholder="Min 2 lettres, Max 45">
            {% if errors.titre is defined %}
            <span class="error">{{ errors.titre }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="tirage">Tirage :</label>
            <input class="form__input" type="number" name="tirage" id="tirage" value="{{ timbre.tirage|default('') }}" placeholder="Entrez un nombre">
            {% if errors.tirage is defined %}
            <span class="error">{{ errors.tirage }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="dimensions">Dimensions :</label>
            <input class="form__input" type="number" name="dimensions" id="dimensions" value="{{ timbre.dimensions|default('') }}" placeholder="Dimensions">
            {% if errors.dimensions is defined %}
            <span class="error">{{ errors.dimensions }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="id_certifie">Est certifie :</label>
            <select name="id_certifie" id="id_certifie" class="form__options">
                <option value="">Certifie</option>
                {% for certifie in certifies %}
                <option value="{{ certifie.id }}" {% if timbre.id_certifie is defined and timbre.id_certifie == certifie.id %}selected{% endif %}>{{ certifie.certifie }}</option>
                {% endfor %}
            </select>
            {% if errors.id_certifie is defined %}
            <span class="error">{{ errors.id_certifie }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="id_pays">Pays:</label>
            <select name="id_pays" id="id_pays" class="form__options">
                <option value="">Pays</option>
                {% for pay in pays %}
                <option value="{{ pay.id }}" {% if timbre.id_pay is defined and timbre.id_pay == pay.id %}selected{% endif %}>{{ pay.pays }}</option>
                {% endfor %}
            </select>
            {% if errors.id_pays is defined %}
            <span class="error">{{ errors.id_pays }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="id_etat">Etat:</label>
            <select name="id_etat" id="id_etat" class="form__options">
                <option value="">Etat</option>
                {% for etat1 in etat %}
                <option value="{{ etat1.id }}" {% if timbre.id_etat1 is defined and timbre.id_etat1 == etat1.id %}selected{% endif %}>{{ etat1.etat }}</option>
                {% endfor %}
            </select>
            {% if errors.id_etat is defined %}
            <span class="error">{{ errors.id_etat }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="id_couleur">Couleur:</label>
            <select name="id_couleur" id="id_couleur" class="form__options">
                <option value="">Couleur</option>
                {% for couleur in couleurs %}
                <option value="{{ couleur.id }}" {% if timbre.id_couleur is defined and timbre.id_couleur == couleur.id %}selected{% endif %}>{{ couleur.couleur }}</option>
                {% endfor %}
            </select>
            {% if errors.id_couleur is defined %}
            <span class="error">{{ errors.id_couleur }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="description">Description :</label>
            <textarea class="form__input" name="description" id="description" rows="5" maxlength="1000" placeholder="Décrivez le livre...">{{ user.description|default('') }}</textarea>
            {% if errors.description is defined %}
            <span class="error">{{ errors.description }}</span>
            {% endif %}
        </div>

        <!-- <div class="form__contenu">
            <label class="form__label" for="fileToUpload">Image (Upload) :</label>
            <input class="form__input" type="file" name="fileToUpload" id="fileToUpload">
            {% if errors.fileToUpload is defined %}
            <span class="error">{{ errors.fileToUpload }}</span>
            {% endif %}
        </div> -->

        <button type="submit" class="btn">Créer</button>
    </form>

</main>

{{ include('layouts/footer.php') }}