<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : ''?>"><a href="organizzatore/home<?= $vd->scriviToken('?')?>">Home</a></li>
    <li class="<?= $vd->getSottoPagina() == 'dati_personali' ? 'current_page_item' : '' ?>"><a href="organizzatore/dati_personali<?= $vd->scriviToken('?')?>">Dati personali</a></li>
    <li class="<?= $vd->getSottoPagina() == 'reg_tornei' ? 'current_page_item' : '' ?>"><a href="organizzatore/reg_tornei<?= $vd->scriviToken('?')?>">Crea Torneo</a></li>
    <li class="<?= $vd->getSottoPagina() == 'tornei' ? 'current_page_item' : '' ?>"><a href="organizzatore/tornei<?= $vd->scriviToken('?')?>">Miei Tornei</a></li>
</ul>