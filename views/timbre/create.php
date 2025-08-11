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
    <h1 class="quicksand">Librairie <strong class="pompiere">Voyages imaginaires</strong></h1>
</header>

<main class="main__form">


    <!-- <form action="{{ base }}/livre/index" method="post" class="form" enctype="multipart/form-data">
        <header>
            <h2 class="quicksand">Ajouter un Livre</h2>
            <hr>
        </header>

        <div class="form__contenu">
            <label class="form__label" for="titre">Titre :</label>
            <input class="form__input" type="text" name="titre" id="titre" value="{{ livre.titre|default('') }}" placeholder="Min 2 lettres, Max 45">
            {% if errors.titre is defined %}
            <span class="error">{{ errors.titre }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="numero_pages">Nombre de pages :</label>
            <input class="form__input" type="number" name="numero_pages" id="numero_pages" value="{{ livre.numero_pages|default('') }}" placeholder="Entrez un nombre">
            {% if errors.numero_pages is defined %}
            <span class="error">{{ errors.numero_pages }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="edition">Édition :</label>
            <input class="form__input" type="number" name="edition" id="edition" value="{{ livre.edition|default('') }}" placeholder="Numéro d'édition">
            {% if errors.edition is defined %}
            <span class="error">{{ errors.edition }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="fileToUpload">Image (Upload) :</label>
            <input class="form__input" type="file" name="fileToUpload" id="fileToUpload">
            {% if errors.fileToUpload is defined %}
            <span class="error">{{ errors.fileToUpload }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="prix">Prix :</label>
            <input class="form__input" type="text" name="prix" id="prix" value="{{ livre.prix|default('') }}" placeholder="Ex : 19,99">
            {% if errors.prix is defined %}
            <span class="error">{{ errors.prix }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="id_editeur">Choisissez un Éditeur :</label>
            <select name="id_editeur" id="id_editeur" class="form__options">
                <option value="">Éditeur</option>
                {% for editeur in editeurs %}
                <option value="{{ editeur.id }}" {% if livre.id_editeur is defined and livre.id_editeur == editeur.id %}selected{% endif %}>{{ editeur.editeur }}</option>
                {% endfor %}
            </select>
            {% if errors.id_editeur is defined %}
            <span class="error">{{ errors.id_editeur }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="id_categorie">Choisissez une Catégorie :</label>
            <select name="id_categorie" id="id_categorie" class="form__options">
                <option value="">Catégorie</option>
                {% for categorie in categories %}
                <option value="{{ categorie.id }}" {% if livre.id_categorie is defined and livre.id_categorie == categorie.id %}selected{% endif %}>{{ categorie.categorie }}</option>
                {% endfor %}
            </select>
            {% if errors.id_categorie is defined %}
            <span class="error">{{ errors.id_categorie }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="id_auteur">Choisissez un Auteur :</label>
            <select name="id_auteur" id="id_auteur" class="form__options">
                <option value="">Auteur</option>
                {% for auteur in auteurs %}
                <option value="{{ auteur.id }}" {% if livre.id_auteur is defined and livre.id_auteur == auteur.id %}selected{% endif %}>{{ auteur.auteur }}</option>
                {% endfor %}
            </select>
            {% if errors.id_auteur is defined %}
            <span class="error">{{ errors.id_auteur }}</span>
            {% endif %}
        </div>

        <div class="form__contenu">
            <label class="form__label" for="description">Description :</label>
            <textarea class="form__input" name="description" id="description" rows="5" maxlength="1000" placeholder="Décrivez le livre...">{{ user.description|default('') }}</textarea>
            {% if errors.description is defined %}
            <span class="error">{{ errors.description }}</span>
            {% endif %}
        </div>

        <button type="submit" class="btn">Créer</button>
    </form> -->

</main>

{{ include('layouts/footer.php') }}