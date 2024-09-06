<!-- suggerimenti utili in https://forum.mrw.it/threads/risolto-stampare-giorno-della-settimana-in-tabella-php.46323/ -->

<html>
    <head>
        <title>Generazione calendario</title>
    </head>
    <body>
        <?php
            $meseOdierno=0;
            $meseProposto=0;
            $meseOdierno=date("n"); // la funzione date() con parametro "n" restituisce il numero del mese senza l’eventuale zero iniziale. Quindi assumerà un valore compreso tra 1 e 12
            //echo($meseOdierno."<br>");
            if($meseOdierno<12)
            {
                $meseProposto=$meseOdierno+1;
            }
            else
            {
                $meseProposto=1;
            }
            //echo($meseProposto."<br>");
        ?>
        <div align="center"><h2>Creazione turno lettori</h2></div>
        <form name="propostaMese" action="propostaCalendario.php" method="POST">
        <fieldset><legend align="left">Passo 1</legend>
            <table border=0; align="center" width="100%">
                <tr>
                    <td width="50%" align="right">Mese di partenza&nbsp;
                    <select name="mese">
                        <?php
                            if($meseProposto==1)
                            {
                                echo('<option value="01" selected>Gennaio</option>');
                                echo('<option value="02">Febbraio</option>');
                                echo('<option value="03">Marzo</option>');
                                echo('<option value="04">Aprile</option>');
                                echo('<option value="05">Maggio</option>');
                                echo('<option value="06">Giugno</option>');
                                echo('<option value="07">Luglio</option>');
                                echo('<option value="08">Agosto</option>');
                                echo('<option value="09">Settembre</option>');
                                echo('<option value="10">Ottobre</option>');
                                echo('<option value="11">Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            elseif($meseProposto==2)
                            {
                                //echo('<option value="01">Gennaio</option>');
                                echo('<option value="02" selected>Febbraio</option>');
                                echo('<option value="03">Marzo</option>');
                                echo('<option value="04">Aprile</option>');
                                echo('<option value="05">Maggio</option>');
                                echo('<option value="06">Giugno</option>');
                                echo('<option value="07">Luglio</option>');
                                echo('<option value="08">Agosto</option>');
                                echo('<option value="09">Settembre</option>');
                                echo('<option value="10">Ottobre</option>');
                                echo('<option value="11">Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            elseif($meseProposto==3)
                            {
                                //echo('<option value="01">Gennaio</option>');
                                //echo('<option value="02">Febbraio</option>');
                                echo('<option value="03" selected>Marzo</option>');
                                echo('<option value="04">Aprile</option>');
                                echo('<option value="05">Maggio</option>');
                                echo('<option value="06">Giugno</option>');
                                echo('<option value="07">Luglio</option>');
                                echo('<option value="08">Agosto</option>');
                                echo('<option value="09">Settembre</option>');
                                echo('<option value="10">Ottobre</option>');
                                echo('<option value="11">Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            elseif($meseProposto==4)
                            {
                                //echo('<option value="01">Gennaio</option>');
                                //echo('<option value="02">Febbraio</option>');
                                //echo('<option value="03">Marzo</option>');
                                echo('<option value="04" selected>Aprile</option>');
                                echo('<option value="05">Maggio</option>');
                                echo('<option value="06">Giugno</option>');
                                echo('<option value="07">Luglio</option>');
                                echo('<option value="08">Agosto</option>');
                                echo('<option value="09">Settembre</option>');
                                echo('<option value="10">Ottobre</option>');
                                echo('<option value="11">Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            elseif($meseProposto==5)
                            {
                                //echo('<option value="01">Gennaio</option>');
                                //echo('<option value="02">Febbraio</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="04">Aprile</option>');
                                echo('<option value="05" selected>Maggio</option>');
                                echo('<option value="06">Giugno</option>');
                                echo('<option value="07">Luglio</option>');
                                echo('<option value="08">Agosto</option>');
                                echo('<option value="09">Settembre</option>');
                                echo('<option value="10">Ottobre</option>');
                                echo('<option value="11">Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            elseif($meseProposto==6)
                            {
                                //echo('<option value="01">Gennaio</option>');
                                //echo('<option value="02">Febbraio</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="04">Aprile</option>');
                                //echo('<option value="05">Maggio</option>');
                                echo('<option value="06" selected>Giugno</option>');
                                echo('<option value="07">Luglio</option>');
                                echo('<option value="08">Agosto</option>');
                                echo('<option value="09">Settembre</option>');
                                echo('<option value="10">Ottobre</option>');
                                echo('<option value="11">Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            elseif($meseProposto==7)
                            {
                                //echo('<option value="01">Gennaio</option>');
                                //echo('<option value="02">Febbraio</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="04">Aprile</option>');
                                //echo('<option value="05">Maggio</option>');
                                //echo('<option value="06">Giugno</option>');
                                echo('<option value="07" selected>Luglio</option>');
                                echo('<option value="08">Agosto</option>');
                                echo('<option value="09">Settembre</option>');
                                echo('<option value="10">Ottobre</option>');
                                echo('<option value="11">Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            elseif($meseProposto==8)
                            {
                                //echo('<option value="01">Gennaio</option>');
                                //echo('<option value="02">Febbraio</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="04">Aprile</option>');
                                //echo('<option value="05">Maggio</option>');
                                //echo('<option value="06">Giugno</option>');
                                //echo('<option value="07">Luglio</option>');
                                echo('<option value="08" selected>Agosto</option>');
                                echo('<option value="09">Settembre</option>');
                                echo('<option value="10">Ottobre</option>');
                                echo('<option value="11">Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            elseif($meseProposto==9)
                            {
                                //echo('<option value="01">Gennaio</option>');
                                //echo('<option value="02">Febbraio</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="04">Aprile</option>');
                                //echo('<option value="05">Maggio</option>');
                                //echo('<option value="06">Giugno</option>');
                                //echo('<option value="07">Luglio</option>');
                                //echo('<option value="08">Agosto</option>');
                                echo('<option value="09" selected>Settembre</option>');
                                echo('<option value="10">Ottobre</option>');
                                echo('<option value="11">Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            elseif($meseProposto==10)
                            {
                                //echo('<option value="01">Gennaio</option>');
                                //echo('<option value="02">Febbraio</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="04">Aprile</option>');
                                //echo('<option value="05">Maggio</option>');
                                //echo('<option value="06">Giugno</option>');
                                //echo('<option value="07">Luglio</option>');
                                //echo('<option value="08">Agosto</option>');
                                //echo('<option value="09">Settembre</option>');
                                echo('<option value="10" selected>Ottobre</option>');
                                echo('<option value="11">Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            elseif($meseProposto==11)
                            {
                                //echo('<option value="01">Gennaio</option>');
                                //echo('<option value="02">Febbraio</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="04">Aprile</option>');
                                //echo('<option value="05">Maggio</option>');
                                //echo('<option value="06">Giugno</option>');
                                //echo('<option value="07">Luglio</option>');
                                //echo('<option value="08">Agosto</option>');
                                //echo('<option value="09">Settembre</option>');
                                //echo('<option value="10">Ottobre</option>');
                                echo('<option value="11" selected>Novembre</option>');
                                echo('<option value="12">Dicembre</option>');
                            }
                            else
                            {
                                //echo('<option value="01">Gennaio</option>');
                                //echo('<option value="02">Febbraio</option>');
                                //echo('<option value="03">Marzo</option>');
                                //echo('<option value="04">Aprile</option>');
                                //echo('<option value="05">Maggio</option>');
                                //echo('<option value="06">Giugno</option>');
                                //echo('<option value="07">Luglio</option>');
                                //echo('<option value="08">Agosto</option>');
                                //echo('<option value="09">Settembre</option>');
                                //echo('<option value="10">Ottobre</option>');
                                //echo('<option value="11">Novembre</option>');
                                echo('<option value="12" selected>Dicembre</option>');
                            }
                        ?>
                        </select>
                    </td>
                    <td width="50%" align="left">Num. mesi da compilare&nbsp;
                        <?php
                            if($meseProposto==1)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=12>");
                            }
                            elseif($meseProposto==2)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=11>");
                            }
                            elseif($meseProposto==3)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=10>");
                            }
                            elseif($meseProposto==4)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=9>");
                            }
                            elseif($meseProposto==5)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=8>");
                            }
                            elseif($meseProposto==6)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=7>");
                            }
                            elseif($meseProposto==7)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=6>");
                            }
                            elseif($meseProposto==8)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=5>");
                            }
                            elseif($meseProposto==9)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=4>");
                            }
                            elseif($meseProposto==10)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=3>");
                            }
                            elseif($meseProposto==11)
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=2>");
                            }
                            else
                            {
                                echo("<input type='number' name='numMesi' value=3 min=1 max=1>");
                            }
                        ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        <br><br>
        <table border=0; width="100%">
            <tr>
                <td width="50%" align="right"><INPUT TYPE="SUBMIT" NAME="invio" VALUE="Avanti"></td>
                <td width="50%" align="left"><a href="index.html"><img src='Indietro.jpg' width="10%" height="10%"></a></td>
            </tr>
        </table>
        </form>
    </body>
</html>