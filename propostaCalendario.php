<html>
    <head>
        <title>Proposta calendario</title>
    </head>
    <body>
        <?php
            $mese=$_POST["mese"]; // mese scelto dall'utente per iniziare la creazione del calendario lettori
            $meseDaPassare=$mese; // mese che verrà utilizzato da passare come hidden al passo successivo. Non utilizzo $mese perché uso quella variabile in un ciclo dove ne aumento il valore, mentre alla fase successiva devo passare il valore che ho ricevuto dalla pagina precedente
            //echo($mese."<br>");
            $numMesi=$_POST["numMesi"]; // numero di mesi da compilare
            //echo($numMesi."<br>");
            //$annoBisestile=false;
            $annoInCorso=date("Y");
            //echo($annoInCorso"<br>");
            $i=0; //indice da utilizzare nel ciclo di estrazione delle date da compilare

            /* $timestamp=strtotime("2024/08/21");
            echo(date('D',$timestamp)."<br>"); */


            //inizio controllo se l'anno in corso è bisestile: script ispirato da https://gabrieleromanato.com/2023/06/php-verificare-se-un-anno-e-bisestile
            if($annoInCorso % 400 === 0) 
            {
                $annoBisestile=true;
            }
            elseif ($annoInCorso % 100 === 0)
            {
                $annoBisestile=false;
            }
            elseif ($annoInCorso % 4 === 0)
            {
                $annoBisestile=true;
            }
            else
            {
                $annoBisestile=false;
            }
            //fine controllo per stabilire se l'anno in corso è bisestile
            //echo($annoBisestile."<br>");


            //script che calcola il giorno di Pasqua
            $pasqua=date("Y-m-d", easter_date($annoInCorso)); // verrà estratta la data della Pasqua nel formato YYYY-MM-GG
            $mesePasqua=date("m", easter_date($annoInCorso));
            $giornoPasqua=date("d", easter_date($annoInCorso));
            //echo("Pasqua: ".$pasqua."<br>");
            //echo("Mese Pasqua: ".$mesePasqua."<br>");
            //echo("Giorno Pasqua: ".$giornoPasqua."<br>");
            // fine script che calcola il giorno di Pasqua


            // script che calcola il giorno delle Ceneri
            $dataCeneri=strtotime('-46 day',strtotime($pasqua));
            $meseCeneri=date("m",$dataCeneri);
            $giornoCeneri=date("d",$dataCeneri);
            $dataCeneri=date('Y-m-d',$dataCeneri); // E' GIUSTO CHE $dataCeneri STIA DOPO IL MESE E IL GIORNO            
            //echo("Ceneri: ".$dataCeneri."<br>");
            //echo("Mese Ceneri: ".$meseCeneri."<br>");
            //echo("Giorno Ceneri: ".$giornoCeneri."<br>");
            // fine script che calcola il giorno delle ceneri


            // script che calcola il Giovedì Santo
            $dataGiovediSanto=strtotime('-3 day',strtotime($pasqua));
            $meseGiovediSanto=date("m",$dataGiovediSanto);
            $giornoGiovediSanto=date("d",$dataGiovediSanto);
            $dataGiovediSanto=date('Y-m-d',$dataGiovediSanto); // E' GIUSTO CHE $dataGiovediSanto STIA DOPO MESE E GIORNO            
            //echo("Gioved&igrave; Santo: ".$dataGiovediSanto."<br>");
            //echo("Mese Gioved&igrave; Santo: ".$meseGiovediSanto."<br>");
            //echo("Giorno Gioved&igrave; Santo: ".$giornoGiovediSanto."<br>");
            // fine script che calcola il Giovedì Santo


            // script che calcola il Venerdì Santo
            $dataVenerdiSanto=strtotime('-2 day',strtotime($pasqua));
            $meseVenerdiSanto=date("m",$dataVenerdiSanto);
            $giornoVenerdiSanto=date("d",$dataVenerdiSanto);
            $dataVenerdiSanto=date('Y-m-d',$dataVenerdiSanto); // E' GIUSTO CHE $dataVenerdiSanto STIA DOPO MESE E GIORNO            
            //echo("Venerd&igrave; Santo: ".$dataVenerdiSanto."<br>");
            //echo("Mese Venerd&igrave; Santo: ".$meseVenerdiSanto."<br>");
            //echo("Giorno Venerd&igrave; Santo: ".$giornoVenerdiSanto."<br>");
            // fine script che calcola il Venerdì Santo


            // script che calcola il Sabato Santo
            $dataSabatoSanto=strtotime('-1 day',strtotime($pasqua));
            $meseSabatoSanto=date("m",$dataSabatoSanto);
            $giornoSabatoSanto=date("d",$dataSabatoSanto);
            $dataSabatoSanto=date('Y-m-d',$dataSabatoSanto); // E' GIUSTO CHE $dataVenerdiSanto STIA DOPO MESE E GIORNO            
            //echo("Sabato Santo: ".$dataSabatoSanto."<br>");
            //echo("Mese Sabato Santo: ".$meseSabatoSanto."<br>");
            //echo("Giorno Sabato Santo: ".$giornoSabatoSanto."<br>");
            // fine script che calcola il Sabato Santo


            // script che calcola il Lunedì dell'Angelo
            $dataPasquetta=strtotime('+1 day',strtotime($pasqua));
            $mesePasquetta=date("m",$dataPasquetta);
            $giornoPasquetta=date("d",$dataPasquetta);
            $dataPasquetta=date('Y-m-d',$dataPasquetta); // E' GIUSTO CHE $dataPasquetta STIA DOPO IL MESE E IL GIORNO            
            //echo("Luned&igrave dell'Angelo: ".$dataPasquetta."<br>");
            //echo("Mese Luned&igrave dell'Angelo: ".$mesePasquetta."<br>");
            //echo("Giorno Luned&igrave dell'Angelo: ".$giornoPasquetta."<br>");
            // fine script che calcola il Lunedì dell'Angelo

            $calendario=array(); // definisco una variabile che sarà un array da passare bozzaTurni.php

            //funzione per l'output di giorno e data
            function outputGiornoData($k,$annoInCorso,$mese)
            {                
                global $calendario; // ridefinisco la variabile $calendario all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
                $quanti=count($calendario); //conta gli elementi presenti nell'array
                $giornoStampato=0;
                if($k<10)
                {
                    $giornoPerTimestamp="0".$k;
                }
                else
                {
                    $giornoPerTimestamp=$k;
                }
                $timestamp=strtotime($annoInCorso."/".$mese."/".$giornoPerTimestamp);

                // script per mostrare a video le abbreviazioni dei giorni in italiano anziché in inglese
                if(date('D',$timestamp)=="Mon") {$giornoItaliano="Lun";}
                elseif(date('D',$timestamp)=="Tue") {$giornoItaliano="Mar";}
                elseif(date('D',$timestamp)=="Wed") {$giornoItaliano="Mer";}
                elseif(date('D',$timestamp)=="Thu") {$giornoItaliano="Gio";}
                elseif(date('D',$timestamp)=="Fri") {$giornoItaliano="Ven";}
                elseif(date('D',$timestamp)=="Sat") {$giornoItaliano="Sab";}
                else {$giornoItaliano="Dom";}

                if(date('D',$timestamp)=="Sat" or date('D',$timestamp)=="Sun")
                {
                    echo("<div align='center'>".$giornoItaliano." ".$giornoPerTimestamp."/".$mese."</div>");
                    $calendario[$quanti][0]=$giornoItaliano;
                    $calendario[$quanti][1]=$giornoPerTimestamp;
                    $calendario[$quanti][2]=$mese;
                    $giornoStampato=$k;
                }
                
                //test per l'aggiunta nel calendario delle Messe che non sono di sabato e domenica
                if(
                    ($mese=="01" and $k==1 and $giornoStampato==0) or // primo gennaio
                    ($mese=="01" and $k==5 and $giornoStampato==0) or // prefestiva Epifania
                    ($mese=="01" and $k==6 and $giornoStampato==0) or // Epifania
                    ($mese=='$meseCeneri' and $k=='$giornoCeneri' and $giornoStampato==0) or // Ceneri
                    ($mese=='$meseGiovediSanto' and $k=='$giornoGiovediSanto' and $giornoStampato==0) or // Giovedì Santo
                    ($mese=='$meseVenerdiSanto' and $k=='$giornoVenerdiSanto' and $giornoStampato==0) or // Venerdì Santo
                    ($mese=='$meseSabatoSanto' and $k=='$giornoSabatoSanto' and $giornoStampato==0) or // Sabato Santo
                    ($mese=='$mesePasquetta' and $k=='$giornoPasquetta' and $giornoStampato==0) or // Lunedì dell'Angelo
                    ($mese=="08" and $k==14 and $giornoStampato==0) or // prefestiva Assunzione
                    ($mese=="08" and $k==15 and $giornoStampato==0) or // Assunzione
                    ($mese=="09" and $k==8 and $giornoStampato==0) or // Maria Bambina
                    ($mese=="10" and $k==31 and $giornoStampato==0) or // prefestiva Ognissanti
                    ($mese=="11" and $k==1 and $giornoStampato==0) or // Ognissanti
                    ($mese=="11" and $k==2 and $giornoStampato==0) or // Defunti
                    ($mese=="12" and $k==8 and $giornoStampato==0) or // Immacolata
                    ($mese=="12" and $k==24 and $giornoStampato==0) or // Veglia di Natale
                    ($mese=="12" and $k==25 and $giornoStampato==0) or // Natale
                    ($mese=="12" and $k==26 and $giornoStampato==0) or // Santo Stefano
                    ($mese=="12" and $k==31 and $giornoStampato==0) // prefestiva primo gennaio
                )
                {
                    echo("<div align='center'>".$giornoItaliano." ".$giornoPerTimestamp."/".$mese."</div>");
                    $calendario[$quanti][0]=$giornoItaliano;
                    $calendario[$quanti][1]=$giornoPerTimestamp;
                    $calendario[$quanti][2]=$mese;
                }
            }
            //fine funzione per l'output di giorno e data


            echo("<fieldset><legend align='center'><strong>Calendario proposto</strong></legend>");
            //inizio ciclo per l'estrazione dei giorni cui assegnare i lettori
            do
            {
                if($mese=="04" or $mese=="06" or $mese=="09" or $mese=="11")
                {
                    //echo("passo di qui<br>");
                    for($k=1;$k<=30;$k++)
                    {
                        outputGiornoData($k,$annoInCorso,$mese);
                    }
                }
                elseif($mese==01 or $mese==03 or $mese==05 or $mese==07 or $mese==08 or $mese==10 or $mese=12)
                {
                    for($k=1;$k<=31;$k++)
                    {
                        outputGiornoData($k,$annoInCorso,$mese);
                    }
                }
                else
                {
                    if($annoBisestile==true)
                    {
                        for($k=1;$k<=29;$k++)
                        {
                            outputGiornoData($k,$annoInCorso,$mese);
                        }
                    }
                    else
                    {
                        for($k=1;$k<=28;$k++)
                        {
                            outputGiornoData($k,$annoInCorso,$mese);
                        }
                    }
                }
                $mese=$mese+1;
                $i=$i+1;
            }
            while($i<$numMesi);
            // fine ciclo per l'estrazione dei giorni cui assegnare i lettori
            echo("</fieldset>");

            /*$arrayTest[0][0]="Sab";
            $arrayTest[0][1]="06";
            $arrayTest[0][2]="11";
            $arrayTest[1][0]="Dom";
            $arrayTest[1][1]="07";
            $arrayTest[1][2]="11";*/

            /* per effettuare il passaggio di un array tramite form seguo quanto scritto alla pagina
            https://www.andreaminini.com/php/come-passare-un-array-tramite-form-con-php */

            // Come prima cosa serializzo l'array tramite l'istruzione SERIALIZE()
            $calendario2=serialize($calendario);
            // In questo modo tutti gli elementi del vettore sono disposti in serie, separati tra loro da un carattere separatore, come un'unica informazione.
            
            // Il secondo passo consiste nella codifica della variabile serializzata tramite l'istruzione URLENCODE().
            $calendario3=urlencode($calendario2);
            // Così facendo evito che alcuni caratteri siano confusi con i simboli di separazione degli elementi dell'array.
            // la variabile $array3 sarà quella da passare nella form

            // script di debug per mandare a video gli elementi dell'array da inviare tramite form
            /*for($i=0;$i<count($calendario);$i++)
            {
                $j=0;
                echo($calendario[$i][$j]." ");
                $j++;
                echo($calendario[$i][$j]." ");
                $j++;
                echo($calendario[$i][$j]."<br>");
            }*/
        ?>
        <br>
        <form name="confermaCalendario" action="bozzaTurni.php" method="POST">
            <?php
                echo("<input name='mese' type='hidden' value='$meseDaPassare'>");
                echo("<input name='numMesi' type='hidden' value='$numMesi'>");
                echo("<input name='calendario3' type='hidden' value='$calendario3'>");
            ?>
            <table border=0; width="100%">
                <tr>
                    <td width="50%" align="right"><INPUT TYPE="SUBMIT" NAME="invio" VALUE="Avanti"></td>
                    <td width="50%" align="left"><a href="calcoloCalendario.php"><img src='Indietro.jpg' width="10%" height="10%"></a></td>
                </tr>
            </table>
        </form>
    </body>
</html>