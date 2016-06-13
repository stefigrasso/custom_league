<?php

$json = array();
$json['errori'] = $errori;
$json['tornei'] = array();
foreach($tornei as $torneo){
     /* @var $torneo Torneo */
    $element = array();
    $element['data_inizio'] = $torneo->getDataInizio()->format('d/m/Y');
    $element['nome'] = $torneo->getNome();
    $element['disciplina'] = $torneo->getDisciplina();
    $element['tipologia'] = $torneo->getTipologia();
    $element['torneo_id'] = $torneo->getId();
            
    $json['tornei'][] = $element;
    
}
echo json_encode($json);
?>
