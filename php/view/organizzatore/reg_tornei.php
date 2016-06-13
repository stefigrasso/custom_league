<div >
    <h2 class="icon-title" id="h-registrazione">Creazione Tornei</h2>
    <p>
        <strong>Organizzatore:</strong> <?= $user->getNome() ?> <?= $user->getCognome() ?>
    </p>
</div>
<?php
if (isset($elenchi_attivi) && count($elenchi_attivi) > 0) {
    ?>
    <h3>Elenco tornei non ancora registrati</h3>
    <table>
        <thead>
            <tr>
                <th>Elenco</th>
                <th>Luogo</th>
                <th>Indirizzo</th>
                <th>Disciplina</th>
                <th>Tipologia</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($elenchi_attivi as $elenco) {
                ?>
                <tr <?= $i % 2 == 0 ? 'class="alt-row"' : '' ?>>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <?php
                        if ($elenco->getTemplate()->getLuogo() != null) {
                            echo $elenco->getTemplate()->getLuogo();
                        } else {
                            echo 'Non inserito';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($elenco->getTemplate()->getIndirizzo() != null) {
                            echo $elenco->getTemplate()->getIndirizzo();
                        } else {
                            echo 'Non inserito';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($elenco->getTemplate()->getDisciplina() != null) {
                            echo $elenco->getTemplate()->getDisciplina();
                        } else {
                            echo 'Non inserito';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($elenco->getTemplate()->getTipologia() != null) {
                            echo $elenco->getTemplate()->getTipologia();
                        } else {
                            echo 'Non inserito';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="organizzatore/reg_tornei_step1?elenco=<?= $elenco->getId() ?><?= $vd->scriviToken('&') ?>" title="Modifica l'elenco">
                            <img  src="../images/edit.png" alt="Modifica"></a>
                        <a href="organizzatore/reg_tornei?cmd=r_del_elenco&amp;elenco=<?= $elenco->getId() ?><?= $vd->scriviToken('&') ?>" title="Elimina l'elenco">
                            <img  src="../images/trash.png" alt="Elimina"></a>
                    </td>

                </tr>
                </li>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>    
<div class="input-form">
    <form method="get" action="organizzatore/reg_tornei_step1">
        <?= $vd->scriviToken('', ViewDescriptor::post)?>
        <input type="hidden" name="cmd" value="r_nuovo"/>
        <input type="submit" value="Nuovo Elenco"/>
    </form>
</div>