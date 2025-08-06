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
    lien2: '/rrrrr',
    lien7: '/user/create',

}) }}
<header class="entete entete-accueil">
    <picture>
        <img src="{{ asset }}/img/gerdarme_royale.jpg" alt="gerdarme royale">
    </picture>
    <div class="entete__opacite"></div>
    <div class="entete__contenu">
        <h1 class="italianno-regular">Le Lord Ronald Stampee <strong class="old-standard-tt-bold">III</strong></h1>
        <p class="pompiere-regular">
            vous souhaite la bienvenue sur son prestigieux site d'enchères.
            Passionné et collectionneur depuis toujours, il est fier de vous
            proposer les plus rares et exquis timbres jamais vendus. Faites vos
            offres!
        </p>
    </div>
</header>

{{ include('layouts/footer.php') }}