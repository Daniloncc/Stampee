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
    lien8: '/timbre/create?id=' ~ session.userId,
    lien15: '/timbre/index',
    
}) }}
{% endif %}
<header>
    <h1 class="quicksand">Bonjour, {{ user.prenom }}</h1>
</header>

<main class="main__form">
    <div class="donnee">
        <h2 class="quicksand">Votre Profil</h2>
        <hr>
        <p class="pompiere-regular"><strong>Nom: </strong>{{ user.nom }}</p>
        <p class="pompiere-regular"><strong>Prenom: </strong>{{ user.prenom }}</p>
        <p class="pompiere-regular"><strong>Addresse: </strong>{{ user.adresse }}</p>
        <p class="pompiere-regular"><strong>Telehone: </strong>{{ user.telephone }}</p>
        <p class="pompiere-regular"><strong>Courriel: </strong>{{ user.courriel }}</p>

        <hr>
        <form class="donnee__form" action="{{ base }}/user/delete" method="post">
            <input type="hidden" name="id" value="{{ user.id }}">
            <a href="{{ base }}/user/edit?id={{ user.id }}" class="button button-bleu">Edit profil</a>
            <button type="submit" class="button button-rouge">Delete profil</button>
            <div class="barre-division"> </div>
            <a href="{{ base }}/timbre/create?id={{ user.id }}" class="button button-joune">Ajouter Timbre</a>
        </form>
    </div>
</main>

{{ include('layouts/footer.php') }}