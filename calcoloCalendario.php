<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Selezione Mese e Numero</title>
        <script>
            // Funzione per inizializzare il menù a tendina
            function initializeDropdown()
            {
                const monthSelect = document.getElementById('month'); // io qui non sto recuperando nessun valore, sto solo legando la variabile monthSelect di javascript all'elemento con id 'month' dell'html
                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();
                const currentMonth = currentDate.getMonth(); // Mese corrente (0-11)
                if (currentMonth === 11) // verifica se il mese in cui viene aperta la pagina è dicembre: se è dicembre, avvisa l'utente che il programma non si può utilizzare
                {
                    alert("ATTENZIONE: il mese in corso è dicembre e il programma non è pensato per saltare da un anno all'altro; si potranno creare nuovi turni solo a partire da gennaio, sapendo che i turni che verranno creati potranno partire solo da febbraio in poi, in quanto il programma permette di creare turni solo dal mese successivo a quello corrente.");
                }
                
                // Aggiungi i mesi al menù a tendina
                const months = [
                    "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
                    "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
                ];
                
                // Aggiungi solo i mesi successivi al mese corrente
                for (let i = currentMonth + 1; i <= 11; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = months[i];
                    monthSelect.appendChild(option); // qui sto inserendo a cascata tutte le option alla select del mese presente nell'html
                }
                
                // Impostiamo la selezione del mese corrente
                monthSelect.addEventListener('change', updateNumericField);
                updateNumericField();
            }

            // Funzione per aggiornare il campo numerico
            function updateNumericField() {
                const monthSelect = document.getElementById('month');
                const numericInput = document.getElementById('numericField');
                const selectedMonth = parseInt(monthSelect.value);
                const currentDate = new Date();
                const currentMonth = currentDate.getMonth(); // Mese corrente (0-11)
                const maxMonth = 11 - selectedMonth + 1; // Numero di mesi rimasti nell'anno

                // Impostiamo il valore proposto per il campo numerico in base al mese
                if (selectedMonth === 10) { // Novembre
                    numericInput.value = 2;
                } else if (selectedMonth === 11) { // Dicembre
                    numericInput.value = 1;
                } else {
                    numericInput.value = 3;
                }

                // Impostiamo il massimo valore per il campo numerico in base ai mesi rimanenti
                numericInput.setAttribute("max", maxMonth);
            }

            // Inizializza la pagina al caricamento
            window.onload = initializeDropdown;
        </script>
    </head>
    <body>
        <div align="center"><h2>Creazione turno lettori</h2></div>
        <form name="propostaMese" action="propostaCalendario.php" method="POST">
            <fieldset><legend align="left">Passo 1</legend>
                <table border=0; align="center" width="100%">
                    <tr>
                        <td width="50%" align="right">
                            <label for="month">Seleziona il mese:</label>
                            <select id="month" name="mese"></select>
                        </td>
                        <td width="50%" align="left">
                            <label for="numericField">Inserisci un numero:</label>
                            <input type="number" id="numericField" name="numMesi" min="1" max="12" value="3">
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br><br>
            <?php
            $timestamp=strtotime("now");
            $meseCorrente=date('m',$timestamp);
            //echo("Mese corrente: ".$meseCorrente."<br>");
            if($meseCorrente==12) // se siamo a dicembre, inibisco la presenza del pulsante "Avanti"
            {
                echo("
                    <table border=0; width='100%'>
                        <tr>
                            <td  align='center'><a href='index.html'><img src='Indietro.jpg' width='10%' height='10%'></a></td>
                         </tr>
                    </table>
                ");
            }
            else
             {
                echo("
                    <table border=0; width='100%'>
                        <tr>
                            <td width='50%' align='right'><INPUT TYPE='SUBMIT' NAME='invio' VALUE='Avanti'></td>
                            <td width='50%' align='left'><a href='index.html'><img src='Indietro.jpg' width='10%' height='10%'></a></td>
                         </tr>
                    </table>
                ");
            }  
            ?>
        </form>
    </body>
</html>