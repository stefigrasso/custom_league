<ul>
    <li class="<?= $vd->getSottoPagina() == 'home' || $vd->getSottoPagina() == null ? 'current_page_item' : ''?>"><a href="partecipante/home<?= $vd->scriviToken('?')?>">Home</a></li>
    <li class="<?= $vd->getSottoPagina() == 'dati_personali' ? 'current_page_item' : '' ?>"><a href="partecipante/dati_personali<?= $vd->scriviToken('?')?>">Dati personali</a></li>
    <li class="<?= $vd->getSottoPagina() == 'tornei' ? 'current_page_item' : '' ?>"><a href="partecipante/tornei<?= $vd->scriviToken('?')?>">Miei Tornei</a></li>
    <li class="<?= $vd->getSottoPagina() == 'el_tornei' ? 'current_page_item' : '' ?>"><a href="partecipante/el_tornei<?= $vd->scriviToken('?')?>">Elenco Tornei</a></li>
</ul>