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
            <h2 class="old-standard-tt-regular">
                {{ page }}
            </h2>
            <small class="quicksand">Tous les options | 12 sur 231</small>
        </header>
        <!--  -->
        <div class="grille-cartes">
            <article class="carte">
                <i class="fa-solid fa-star preference"></i>
                <picture>
                    <img src="./assets/img/autralie_cangurou.webp" alt="timbre autralie cangourou">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Cangourou d’Australie 1913</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Première Émission Fédérale</h4>
                        <small>Stock Code: AUC1913F001</small>
                    </div>
                    <footer>
                        <small><strong>$265</strong></small>
                        <div>|</div>
                        <small>2 jours restans</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <i class="fa-solid fa-star preference"></i>
                <picture>
                    <img src="./assets/img/canada_lion_de_mer.webp" alt="timbre Canadien lion de mer">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Lion de Mer du Canada 1954</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Série Faune Côtière Canadienne</h4>
                        <small>Stock Code: CAN1954L001</small>
                    </div>
                    <footer>
                        <small><strong>$120</strong></small>
                        <div>|</div>
                        <small>5 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <picture>
                    <img src="./assets/img/eliot_british.webp" alt="timbre Lord Anglais">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Lord Eliot 1927</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Portraits de l'Aristocratie Britannique</h4>
                        <small>Stock Code: GBR1927E001</small>
                    </div>
                    <footer>
                        <small><strong>$490</strong></small>
                        <div>|</div>
                        <small>1 jour restant</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <picture>
                    <img src="./assets/img/elisabeth_1th.webp" alt="timbre Elisabeth I">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Elisabeth Ière 1588</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Dynastie Tudor en Philatélie</h4>
                        <small>Stock Code: GBR1588E001</small>
                    </div>
                    <footer>
                        <small><strong>$325</strong></small>
                        <div>|</div>
                        <small>3 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <picture>
                    <img src="./assets/img/migration_oeseaux.webp" alt="timbre migration oiseaux">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Oiseaux Migrateurs 1981</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Réserve Ornithologique Internationale</h4>
                        <small>Stock Code: INT1981M001</small>
                    </div>
                    <footer>
                        <small><strong>$42</strong></small>
                        <div>|</div>
                        <small>4 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <picture>
                    <img src="./assets/img/omnibus_1880.webp" alt="Timbre omnibus 1880">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Omnibus Impérial 1880</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Transport Urbain Victorien</h4>
                        <small>Stock Code: UKG1880O001</small>
                    </div>
                    <footer>
                        <small><strong>$88</strong></small>
                        <div>|</div>
                        <small>6 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <i class="fa-solid fa-star preference"></i>
                <picture>
                    <img src="./assets/img/papillon.webp" alt="Timbre Papillon">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Papillon Bleu 1935</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Beautés Naturelles du Monde</h4>
                        <small>Stock Code: WLD1935B001</small>
                    </div>
                    <footer>
                        <small><strong>$370</strong></small>
                        <div>|</div>
                        <small>12 heures restantes</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <picture>
                    <img src="./assets/img/poste_armenie.webp" alt="Timbre Arménie">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Poste d'Arménie 1921</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">République Transcaucasienne</h4>
                        <small>Stock Code: ARM1921P001</small>
                    </div>
                    <footer>
                        <small><strong>$212</strong></small>
                        <div>|</div>
                        <small>7 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <i class="fa-solid fa-star preference"></i>
                <picture>
                    <img src="./assets/img/republique_guine.webp" alt="Timbre République Guinée">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Guinée Indépendante 1960</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Scott #226 - Émission Historique</h4>
                        <small>Stock Code: GUI1960I001</small>
                    </div>
                    <footer>
                        <small><strong>$35</strong></small>
                        <div>|</div>
                        <small>8 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <picture>
                    <img src="./assets/img/u.s_postage_3_cents.webp" alt="Timbre 3 cents USA">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Benjamin Franklin 1861</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Émission Classique Américaine</h4>
                        <small>Stock Code: USA1861B001</small>
                    </div>
                    <footer>
                        <small><strong>$59</strong></small>
                        <div>|</div>
                        <small>3 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <i class="fa-solid fa-star preference"></i>
                <picture>
                    <img src="./assets/img/cuba_mosieur.webp" alt="Timbre monsieur cubain">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Dr. Gutiérrez 1940</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Scott #364 - Médecine et Histoire</h4>
                        <small>Stock Code: CUB1940G001</small>
                    </div>
                    <footer>
                        <small><strong>$143</strong></small>
                        <div>|</div>
                        <small>1 jour restant</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>

            <article class="carte">
                <picture>
                    <img src="./assets/img/oaseux_nouvelle_zelandie.webp" alt="Timbre oiseaux Nouvelle-Zélande">
                </picture>
                <div class="carte__contenu forme-enchere">
                    <header>
                        <h3 class="cinzel">Oiseaux du Pacifique 1985</h3>
                    </header>
                    <div>
                        <h4 class="old-standard-tt-regular">Faune Endémique de Nouvelle-Zélande</h4>
                        <small>Stock Code: NZL1985P001</small>
                    </div>
                    <footer>
                        <small><strong>$98</strong></small>
                        <div>|</div>
                        <small>6 jours restants</small>
                    </footer>
                </div>
                <button class="button">Voir plus <i class="fa-solid fa-arrow-right"></i></button>
            </article>
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