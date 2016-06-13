$(document).ready(function () {
    
    $(".error").hide();
    $("#tabella_tornei").hide();
    
    $('#filtra').click(function(e) {
        // impedisco il submit
        e.preventDefault();
        var _nome = $("#nome").val();
        var _disciplina = $("#disciplina").val();
        var _tipologia = $("#tipologia option:selected").attr('value');
        if(_tipologia === 'qualsiasi'){
            _tipologia = '';
        }
        
        var par = {
            nome: _nome,
            disciplina: _disciplina,
            tipologia: _tipologia
        };
        $.ajax({
            url: 'partecipante/filtra_tornei',
            data: par,
            dataType: 'json',
            success: function (data, state) {
                if(data['errori'].length === 0) {
                    // nessun errore
                    $(".error").hide();
                    if(data['tornei'].length === 0) {
                        // mostro il messaggio per nessun elemento
                        $("#nessuno").show();                       
                        // nascondo la tabella
                        $("#tabella_tornei").hide();
                    } else {
                        // nascondo il messaggio per nessun elemento
                        $("#nessuno").hide();
                        $("#tabella_tornei").show();
                        //cancello tutti gli elementi dalla tabella
                        $("#tabella_tornei tbody").empty();
                       
                        // aggiungo le righe
                        var i = 0;
                        for(var key in data['tornei']) {
                            var torneo = data['tornei'][key];
                            $("#tabella_tornei tbody").append(
                                "<tr id=\"row_" + i + "\" >\n\
                                       <td>test</td>\n\
                                       <td>test</td>\n\
                                       <td>test</td>\n\
                                       <td>test</td>\n\
                                       <td>test</td>\n\
                                 </tr>");
                            if(i%2 == 0) {
                                $("#row_" + i).addClass("alt-row");
                            } 
                            var colonne = $("#row_"+ i +" td");
                            $(colonne[0]).text(torneo['data_inizio']);
                            $(colonne[1]).text(torneo['nome']);
                            $(colonne[2]).text(torneo['disciplina']);
                            $(colonne[3]).text(torneo['tipologia']);
                            $(colonne[4]).text('').
                                append("<a href=\"partecipante/torneo_dettagli?torneo=" + torneo['torneo_id'] + "&\" \n\
                                    title=\"Dettagli sul torneo\" target=\"_blank\"> \n\
                                    <img  src=\"../images/zoom.png\" alt=\"Dettagli\"></a>").
                                append("<a href=\"partecipante/tornei?cmd=torneo_iscrivi&amp;torneo=" + torneo['torneo_id'] + "&\" \n\
                                    title=\"Iscriviti al torneo\"> \n\
                                    <img  src=\"../images/subscribe.png\" alt=\"Iscriviti\"> </a>");
                            i++;   
                        }
                    }
                } else {
                    $(".error").show();
                    $(".error ul").empty();
                    for(var k in data['errori']){
                        $(".error ul").append("<li>"+ data['errori'][k] + "<\li>");
                    }
                }
               
            },
            error: function (data, state) {
            }
        
        });
        
    })
});
