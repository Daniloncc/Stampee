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
    lienTimbre: '/timbre/create?id=' ~ session.userId,
    lienTimbres: '/timbre/index',

}) }}
{% endif %}

<main class="main__form">
    <!-- si je ne mets pas un action je reviens a la meme page -->
    <form action="{{ base }}/timbre/update" method="post" class="form">
        <label for="id"></label>
        <input type="hidden" id="id" name="id" value="{{ timbre.id }}">
        <header>
            <h2 class="quicksand">Modifier un Timbre</h2>
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
            <label class="form__label" for="prix">Prix :</label>
            <input class="form__input" type="text" name="prix" id="prix" value="{{ timbre.prix|default('') }}" placeholder="Ex : 19,99">
            {% if errors.prix is defined %}
            <span class="error">{{ errors.prix }}</span>
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
            <input class="form__input" type="text" name="dimensions" id="dimensions" value="{{ timbre.dimensions|default('') }}" placeholder="Ex: 5,5 po x 3,5 po">
            {% if errors.dimensions is defined %}
            <span class="error">{{ errors.dimensions }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="idCertifie">Est certifie :</label>
            <select name="idCertifie" id="idCertifie" class="form__options">
                <option value="">Certifie</option>
                {% for certifie in certifies %}
                <option value="{{ certifie.id }}" {% if timbre.idCertifie is defined and timbre.idCertifie == certifie.id %}selected{% endif %}>{{ certifie.certifie }}</option>
                {% endfor %}
            </select>
            {% if errors.idCertifie is defined %}
            <span class="error">{{ errors.idCertifie }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="idPays">Pays :</label>
            <select name="idPays" id="idPays" class="form__options">
                <option value="">Pays</option>
                {% for pay in pays %}
                <option value="{{ pay.id }}" {% if timbre.idPays is defined and timbre.idPays == pay.id %}selected{% endif %}>{{ pay.pays }}</option>
                {% endfor %}
            </select>
            {% if errors.idPays is defined %}
            <span class="error">{{ errors.idPays }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="idEtat">Etat :</label>
            <select name="idEtat" id="idEtat" class="form__options">
                <option value="">Etat</option>
                {% for etat_ in etat %}
                <option value="{{ etat_.id }}" {% if timbre.idEtat is defined and timbre.idEtat == etat_.id %}selected{% endif %}>{{ etat_.etat }}</option>
                {% endfor %}
            </select>
            {% if errors.idEtat is defined %}
            <span class="error">{{ errors.idEtat }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="idCcouleur">Couleur :</label>
            <select name="idCouleur" id="idCouleur" class="form__options">
                <option value="">Couleur</option>
                {% for couleur in couleurs %}
                <option value="{{ couleur.id }}" {% if timbre.idCouleur is defined and timbre.idCouleur == couleur.id %}selected{% endif %}>{{ couleur.couleur }}</option>
                {% endfor %}
            </select>
            {% if errors.idCouleur is defined %}
            <span class="error">{{ errors.idCouleur }}</span>
            {% endif %}
        </div>

        <!-- <div class="form__contenu">
            <label class="form__label" for="images">Images:</label>
            <input type="file" name="images[]" id="images" multiple accept="image/*">
            {% if errors.images is defined %}
            <span class="error">{{ errors.images }}</span>
            {% endif %}
        </div> -->

        <div class="form__contenu">
            <label class="form__label" for="description">Description :</label>
            <textarea class="form__input" name="description" id="description" rows="5" maxlength="1000" placeholder="Décrivez le timbre...">{{ timbre.description|default('') }}</textarea>
            {% if errors.description is defined %}
            <span class="error">{{ errors.description }}</span>
            {% endif %}
        </div>
        <div class="form__contenu_btn">
            <a class="button button-rouge" href="{{ base }}/timbre/timbre?id={{ timbre.id }}">← Retourner</a>
            <div class="barre-division"> </div>
            <a class="button button-rouge" href="{{ base }}/timbre/delete?id={{ timbre.id }}">Supprimer</a>
            <!-- <form class="donnee__form" action="{{ base }}/" method="post">
                <input type="hidden" name="id" value="{{ timbre.id }}">
                <button type="submit" class="button button-rouge">Supprimer</button>
            </form> -->
            <a class="button button-joune" href="{{ base }}/timbre/timbre?id={{ timbre.id }}">Images</a>
            <button type="submit" class="button button-bleu">Modifier</button>
        </div>
    </form>
</main>

{{ include('layouts/footer.php') }}