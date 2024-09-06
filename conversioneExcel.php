<?php
    $mese=$_POST["mese"]; // mese scelto dall'utente per iniziare la creazione del calendario lettori
    //echo("Mese: ".$mese."<br>");
    $meseNumerico=intval($mese); // conversione in numero della stringa corrispondente al mese passato dalla pagina precedente
    //echo("Mese numerico: ".$meseNumerico."<br>");
    $numMesi=$_POST["numMesi"]; // numero di mesi da compilare
    //echo("Num mesi: ".$numMesi."<br>");
    $annoInCorso=date("Y"); // anno in corso
    //echo("Anno in corso: ".$annoInCorso."<br>");
    $meseFinaleDaCompilare=$meseNumerico+$numMesi-1;
    $numGiorniMeseFinaleDaCompilare=cal_days_in_month(CAL_GREGORIAN, $meseFinaleDaCompilare, $annoInCorso); // La funzione cal_days_in_month() restituisce il numero di giorni del mese passato come secondo argomento nell'anno passato come terzo argomento (l'anno è importante per i bisestili, che possono far variare il numero di giorni di febbraio)
    $ultimoGiornoIntervalloScelto=strval($numGiorniMeseFinaleDaCompilare)."/".strval($meseFinaleDaCompilare)."/".strval($annoInCorso);
    //echo($ultimoGiornoIntervalloScelto."<br>");

    // qui ricevo l'array codificato con il calendario
    $calendario3=$_POST["calendario3"];
    /*Una volta ricevuta l'informazione nella pagina di destinazione, devo compiere le operazioni inverse, ossia decodificare e deserializzare la variabile array utilizzando le istruzioni URLDECODE() e UNSERIALIZE(). */
    $calendario=unserialize(urldecode($calendario3));
    // script di debug per mandare a video gli elementi dell'array ricevuto
    /*for($i=0;$i<count($calendario);$i++)
    {
        $j=0;
        echo($calendario[$i][$j]." ");
        $j++;
        echo($calendario[$i][$j]." ");
        $j++;
        echo($calendario[$i][$j]."<br>");
    }*/
    
    // qui ricevo l'array codificato dei lettori prefestivi
    $lettoriPrefestivi3=$_POST["lettoriPrefestivi3"];
    $lettoriPrefestivi=unserialize(urldecode($lettoriPrefestivi3));
    //print_r($lettoriPrefestivi);echo("<br>");

    // qui ricevo l'array codificato dei lettori festivi
    $lettoriFestivi3=$_POST["lettoriFestivi3"];
    $lettoriFestivi=unserialize(urldecode($lettoriFestivi3));
    //print_r($lettoriFestivi);echo("<br>");

    //creo array multidimensionale dove inserisco i mesi dell'anno
    $mesi[0][0]="01"; $mesi[0][1]="GEN"; $mesi[0][2]="Gennaio";
    $mesi[1][0]="02"; $mesi[1][1]="FEB"; $mesi[1][2]="Febbraio";
    $mesi[2][0]="03"; $mesi[2][1]="MAR"; $mesi[2][2]="Marzo";
    $mesi[3][0]="04"; $mesi[3][1]="APR"; $mesi[3][2]="Aprile";
    $mesi[4][0]="05"; $mesi[4][1]="MAG"; $mesi[4][2]="Maggio";
    $mesi[5][0]="06"; $mesi[5][1]="GIU"; $mesi[5][2]="Giugno";
    $mesi[6][0]="07"; $mesi[6][1]="LUG"; $mesi[6][2]="Luglio";
    $mesi[7][0]="08"; $mesi[7][1]="AGO"; $mesi[7][2]="Agosto";
    $mesi[8][0]="09"; $mesi[8][1]="SET"; $mesi[8][2]="Settembre";
    $mesi[9][0]="10"; $mesi[9][1]="OTT"; $mesi[9][2]="Ottobre";
    $mesi[10][0]="11"; $mesi[10][1]="NOV"; $mesi[10][2]="Novembre";
    $mesi[11][0]="12"; $mesi[11][1]="DIC"; $mesi[11][2]="Dicembre";

    /* script di debug per mandare a video il contenuto dell'array definito appena sopra
    for($i=0;$i<12;$i++)
    {
        $j=0;
        echo($mesi[$i][$j]." ");
        $j++;
        echo($mesi[$i][$j]." ");
        $j++;
        echo($mesi[$i][$j]."<br>");
    }
    */

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


    //script che calcola la Domenica delle Palme
    $dataPalme=strtotime('-7 day',strtotime($pasqua));
    $mesePalme=date("m",$dataPalme);
    $giornoPalme=date("d",$dataPalme);
    $dataPalme=date('Y-m-d',$dataPalme); // E' GIUSTO CHE $dataPalme STIA DOPO IL MESE E IL GIORNO            
    //echo("Palme: ".$dataPalme."<br>");
    //echo("Mese Palme: ".$mesePalme."<br>");
    //echo("Giorno Palme: ".$giornoPalme."<br>");
    // fine script che calcola il giorno delle Palme


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

    // inizio script creazione array che conterrà i dati della prima colonna del turno lettori
    $messe=array();
    $inserisci=false;
    for($i=0;$i<count($calendario);$i++)
    {
        if($calendario[$i][1]==$giornoPasqua and $calendario[$i][2]==$mesePasqua)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",PASQUA";
            $inserisci=true;
        }
        elseif($calendario[$i][1]==$giornoCeneri and $calendario[$i][2]==$meseCeneri)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",CENERI";
            $inserisci=true;
        }
        elseif($calendario[$i][1]==$giornoPalme and $calendario[$i][2]==$mesePalme)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",PALME";
        }
        elseif($calendario[$i][1]==$giornoGiovediSanto and $calendario[$i][2]==$meseGiovediSanto)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",GIOVED&Iacute; SANTO";
            $inserisci=true;
        }
        elseif($calendario[$i][1]==$giornoVenerdiSanto and $calendario[$i][2]==$meseVenerdiSanto)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",VENERD&Iacute; SANTO";
            $inserisci=true;
        }
        elseif($calendario[$i][1]==$giornoPasquetta and $calendario[$i][2]==$mesePasquetta)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",LUNED&Iacute; dell'Angelo";
            $inserisci=true;
        }
        elseif(intval($calendario[$i][1])==1 and intval($calendario[$i][2])==1)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",MARIA SS. MADRE DI DIO";
            $inserisci=true;
        }
        elseif(intval($calendario[$i][1])==5 and intval($calendario[$i][2])==1)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].",EPIFANIA";
            $inserisci=true;
        }
        elseif(intval($calendario[$i][1])==14 and intval($calendario[$i][2])==8)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].",ASSUNZIONE";
            $inserisci=true;
        }
        elseif(intval($calendario[$i][1])==8 and intval($calendario[$i][2])==9 and (strcmp($calendario[$i][0],"Sab")!=0) and (strcmp($calendario[$i][0],"Dom")!=0))
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",MARIA BAMBINA";
            $inserisci=true;
        }
        elseif(intval($calendario[$i][1])==31 and intval($calendario[$i][2])==10)
        {
            if($mese=="10" and $numMesi==1)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",TUTTI I SANTI";
                $inserisci=true;
            }
            else
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].",TUTTI I SANTI";
                $inserisci=true;
            }
        }
        elseif(intval($calendario[$i][1])==2 and intval($calendario[$i][2])==11 and (strcmp($calendario[$i][0],"Sab")!=0) and (strcmp($calendario[$i][0],"Dom")!=0))
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",FEDELI DEFUNTI";
            $inserisci=true;
        }
        elseif(intval($calendario[$i][1])==8 and intval($calendario[$i][2])==12)
        {
            $daInserire=$calendario[$i-1][1]."/".$calendario[$i-1][2]." - ".$calendario[$i][1]."/".$calendario[$i][2].",IMMACOLATA";
            $inserisci=true;
        }
        elseif(intval($calendario[$i][1])==24 and intval($calendario[$i][2])==12)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].",NATALE";
            $inserisci=true;
        }
        elseif(intval($calendario[$i][1])==26 and intval($calendario[$i][2])==12 and (strcmp($calendario[$i][0],"Sab")!=0) and (strcmp($calendario[$i][0],"Dom")!=0))
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",SANTO STEFANO";
            $inserisci=true;
        }
        elseif(intval($calendario[$i][1])==31 and intval($calendario[$i][2])==12)
        {
            $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",PREF. MARIA MADRE DI DIO";
            $inserisci=true;
        }
        else
        {
            if(strcmp($calendario[$i][0],"Sab")==0 and ($i!=(count($calendario)-1)))
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].", "; // lo spazio dopo la virgola concatenata alla fine è intenzionale
                $inserisci=true;
            }
            elseif(strcmp($calendario[$i][0],"Sab")==0 and ($i==(count($calendario)-1)))
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].", "; // lo spazio dopo la virgola concatenata alla fine è intenzionale
                $inserisci=true;
            }
        }
        
        //aggiungo $daInserire all'array $messe
        if($inserisci==true)
        {
            array_push($messe,$daInserire);
        }
        $inserisci=false;
    }
    // fine script creazione array che conterrà i dati della prima colonna del turno lettori

    //script di debug per controllare il contenuto dell'array $messe
    $quanteMesse=count($messe);
    /*
    for($i=0;$i<$quanteMesse;$i++)
    {
        echo($messe[$i]."<br>");
    }*/

    $hostname='localhost';
	$username='root';
	$conn=mysql_connect($hostname,$username,'')
			or die("Impossibile stabilire una connessione con il server: ".mysql_error());
	$db=mysql_select_db('lettori')
			or die("Impossibile selezionare il database <i>Lettori</i>: ".mysql_error());

    
    $query="select count(*) from lettori where attivo='S'";
    $risultato=mysql_query($query)
        or die("Impossibile contare i lettori attivi presenti nel database ".mysql_error());
    while($lettoriAttivi=mysql_fetch_row($risultato))
    {
        $numLettoriAttivi=$lettoriAttivi[0];
    }
    //echo("I lettori attivi presenti nel db sono ".$numLettoriAttivi."<br>");

    //funzione inserisciRighe che verrà usata nel <body> per popolare la tabella dei turni
    function inserisciRighe($quante)
    {
        global $messe; // ridefinisco la variabile $messe all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        global $quanteMesse; // ridefinisco la variabile $quanteMesse all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        global $meseFinaleDaCompilare; // ridefinisco la variabile $meseFinaleDaCompilare all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        global $annoInCorso; // ridefinisco la variabile $annoInCorso all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        global $ultimoGiornoIntervalloScelto; // ridefinisco la variabile $ultimoGiornoIntervalloScelto all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        global $numLettoriAttivi; // ridefinisco la variabile $numLettoriAttivi all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        

        //variabili per lettori prefestivi
        $prefestiviScorsi=0; //aumenta di uno ogni volta che mando a video un prefestivo e si riazzera per permettere di continuare a mandare a video i prefestivi
        global $lettoriPrefestivi; // ridefinisco la variabile $lettoriPrefestivi all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        $quantiLettoriPrefestivi=0;

        //variabili per lettori festivi
        $festiviScorsi=0; //aumenta di uno ogni volta che mando a video un festivo e si riazzera per permettere di continuare a mandare a video i festivi
        global $lettoriFestivi; // ridefinisco la variabile $lettoriFestivi all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        $quantiLettoriFestivi=0;

        //estraggo lettori e numeri di telefono in ordine alfabetico e li metto in due array separati
        $lettori=array();
        $telefoni=array();
        $query="select cognome, nome, telefono from lettori where attivo='S' order by cognome";
        $risultato=mysql_query($query)
            or die("Impossibile estrarre i nomi dei lettori in ordine alfabetico: ".mysql_error());
        while($riga=mysql_fetch_row($risultato))
        {
            $lettoreDaInserire=$riga[0]." ".$riga[1];
            array_push($lettori,$lettoreDaInserire);
            array_push($telefoni,$riga[2]);
        }
        //print_r($lettori);echo("<br>");
        //print_r($telefoni);

        for($i=0;$i<$quante;$i++)
        {
            $sonoPassato=false; // diventa vera se passo in una delle condizioni if($prefestiviScorsi<$quantiLettoriPrefestivi)
            $sonoPassatoFestivo=false; // come sopra, ma per i festivi
            echo("<tr>");
                //colonna messe
                if($i<$quanteMesse)
                {
                    $messa=explode(",",$messe[$i]);
                    $dataDaConfrontare=substr($messa[0],-5,2)."/".strval($meseFinaleDaCompilare)."/".strval($annoInCorso);
                    if(strcmp($messa[1]," ")==0)
                    {
                        if(strlen($messa[0])==5)
                        {
                            if(strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)==0)
                            {
                                $mesePerIntegrazione=$meseFinaleDaCompilare+1;
                                if($mesePerIntegrazione==13){$mesePerIntegrazione=1;}
                                $stringaIntegrazione="01/".strval($mesePerIntegrazione);
                                echo("<td align='center' width='20%'>".$messa[0]." - <font color='red'><strong>".$stringaIntegrazione."</strong></font></td>");
                            }
                            else
                            {
                                echo("<td align='center' width='20%'>".$messa[0]."</td>");
                            }
                        }
                        else
                        {
                            echo("<td align='center' width='20%'>".$messa[0]."</td>");
                        }
                    }
                    else
                    {
                        if(strlen($messa[0])==5)
                        {
                            if(strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)==0)
                            {
                                $mesePerIntegrazione=$meseFinaleDaCompilare+1;
                                if($mesePerIntegrazione==13){$mesePerIntegrazione=1;}
                                $stringaIntegrazione="01/".strval($mesePerIntegrazione);
                                echo("<td align='center' width='20%'><strong>".$messa[1]."</strong><br>".$messa[0]." - <font color='red'><strong>".$stringaIntegrazione."</strong></font></td>");
                            }
                            else
                            {
                                echo("<td align='center' width='20%'><strong>".$messa[1]."</strong><br>".$messa[0]."</td>");
                            }
                        }
                        else
                        {
                            echo("<td align='center' width='20%'><strong>".$messa[1]."</strong><br>".$messa[0]."</td>");
                        }
                    }
                }
                else
                {
                    echo("<td align='center' width='20%'>&nbsp;</td>");
                }
                //fine colonna messe


                //colonna lettori prefestivi
                echo("<td align='center' width='20%'>");
                    //$j=0;
                    if($i==0)
                    {
                        $query="select count(*) from lettori where preferenzaPrefestiva='S' and attivo='S'";
                        $risultato=mysql_query($query)
                            or die ("Impossibile effettuare il conteggio degli elettori prefestivi: ".mysql_error());
                        while($riga=mysql_fetch_row($risultato))
                        {
                            $quantiLettoriPrefestivi=$riga[0];
                            //echo($quantiLettoriPrefestivi."<br>");
                        }                     
                    }
                    //print_r($lettoriPrefestivi); // funzione che manda a video gli elementi di un array senza fare un ciclo
                    //echo("<br>");
                    //echo("Sono passato? ".$sonoPassato."<br>");
                    if(($prefestiviScorsi<$quantiLettoriPrefestivi) and ($i<$quanteMesse))
                    {
                        echo($lettoriPrefestivi[$prefestiviScorsi]."<br>");
                        $prefestiviScorsi++;
                        $sonoPassato=true;
                        //echo(" prefestivi scorsi: ".$prefestiviScorsi." ");
                        //echo(" passo<br>");
                    }
                    if(($prefestiviScorsi<$quantiLettoriPrefestivi) and ($i<$quanteMesse))
                    {
                        echo($lettoriPrefestivi[$prefestiviScorsi]);
                        $prefestiviScorsi++;
                        $sonoPassato=true;
                        //echo(" prefestivi scorsi: ".$prefestiviScorsi." ");
                        //echo(" passo ancora<br>");
                    }
                    elseif($prefestiviScorsi==$quantiLettoriPrefestivi and $sonoPassato==true and $i<$quanteMesse)
                    {
                        echo($lettoriPrefestivi[0]);
                        $prefestiviScorsi=1;
                        //echo(" prefestivi scorsi: ".$prefestiviScorsi." ");
                        //echo(" passo ancora e ancora<br>");
                    }
                    elseif($prefestiviScorsi==$quantiLettoriPrefestivi and $sonoPassato==false and $i<$quanteMesse)
                    {
                        echo($lettoriPrefestivi[0]."<br>".$lettoriPrefestivi[1]);
                        $prefestiviScorsi=2;
                    }                 
                echo("</td>");
                //fine colonna lettori prefestivi

                
                //colonna lettori festivi
                echo("<td align='center' width='20%'>");
                //$k=0;
                $dataDaConfrontare=substr($messa[0],-5,2)."/".strval($meseFinaleDaCompilare)."/".strval($annoInCorso);
                //echo($dataDaConfrontare."<br>");
                if($i==0)
                {
                    $query="select count(*) from lettori where preferenzaFestiva='S' and attivo='S'";
                    $risultato=mysql_query($query)
                        or die ("Impossibile effettuare il conteggio degli elettori festivi: ".mysql_error());
                    while($riga=mysql_fetch_row($risultato))
                    {
                        $quantiLettoriFestivi=$riga[0];
                        //echo($quantiLettoriFestivi."<br>");
                    }                      
                }
                //print_r($lettoriFestivi); // funzione che manda a video gli elementi di un array senza fare un ciclo
                //echo("<br>");
                //echo("Sono passato? ".$sonoPassatoFestivo."<br>");
                if(($festiviScorsi<$quantiLettoriFestivi) and ($i<$quanteMesse))
                {
                    if(strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)<>0)
                    {
                        echo($lettoriFestivi[$festiviScorsi]."<br>");
                        $festiviScorsi++;
                        $sonoPassatoFestivo=true;
                    }
                    else
                    {
                        echo("<font color='red'><strong>".$lettoriFestivi[$festiviScorsi]."</strong></font><br>");
                        $festiviScorsi++;
                        $sonoPassatoFestivo=true;
                        //echo("passo nel rosso<br>");
                    }
                    //echo(" festivi scorsi: ".$festiviScorsi." ");
                    //echo(" passo<br>");
                }
                if(($festiviScorsi<$quantiLettoriFestivi) and ($i<$quanteMesse))
                {
                    if(strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)<>0)
                    {
                        echo($lettoriFestivi[$festiviScorsi]);
                        $festiviScorsi++;
                        $sonoPassatoFestivo=true;
                    }
                    else
                    {
                        echo("<font color='red'><strong>".$lettoriFestivi[$festiviScorsi]."</strong></font>");
                        $festiviScorsi++;
                        $sonoPassatoFestivo=true;
                        //echo("passo nel rosso<br>");
                    }
                    //echo(" festivi scorsi: ".$festiviScorsi." ");
                    //echo(" passo ancora<br>");
                }
                elseif($festiviScorsi==$quantiLettoriFestivi and $sonoPassatoFestivo==true and $i<$quanteMesse)
                {
                    if(strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)<>0)
                    {
                        echo($lettoriFestivi[0]);
                        $festiviScorsi=1;
                    }
                    else
                    {
                        echo("<font color='red'><strong>".$lettoriFestivi[0]."</strong></font>");
                        $festiviScorsi=1;
                        //echo("passo nel rosso<br>");
                    }
                    //echo(" festivi scorsi: ".$festiviScorsi." ");
                    //echo(" passo ancora e ancora<br>");
                }
                elseif($festiviScorsi==$quantiLettoriFestivi and $sonoPassatoFestivo==false and $i<$quanteMesse)
                {
                    if(strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)<>0)
                    {
                        echo($lettoriFestivi[0]."<br>".$lettoriFestivi[1]);
                        $festiviScorsi=2;
                    }
                    else
                    {
                        echo("<font color='red'><strong>".$lettoriFestivi[0]."<br>".$lettoriFestivi[1]."</strong></font>");
                        $festiviScorsi=2;
                        //echo("passo nel rosso<br>");
                    }
                }                 
                echo("</td>");
                //fine colonna lettori festivi


                // colonna dei nomi dei lettori in ordine alfabetico (per cognome)
                echo("<td align='center' width='20%' valign='center'>");
                if($i<$numLettoriAttivi)
                {
                    echo($lettori[$i]);
                }
                else
                {
                    echo("&nbsp;");
                }
                echo("</td>");
                //fine colonna dei nomi in ordine alfabetico


                // colonna dei numeri di telefono degli elettori in ordine alfabetico (per cognome)
                echo("<td align='center' width='20%' valign='center'>");
                if($i<$numLettoriAttivi)
                {
                    echo($telefoni[$i]);
                }
                else
                {
                    echo("&nbsp;");
                }
                echo("</td>");
                // fine colonna dei numeri di telefono degli elettori in ordine alfabetico (per cognome)
            echo("</tr>");
        }
    }

    $primoMeseIntervallo=$mesi[$meseNumerico-1][2]; //stabilisco il primo mese dell'intervallo scelto dall'utente
    $secondoMeseIntervallo="";
    for($i=$meseNumerico-1;$i<($meseNumerico-1+$numMesi);$i++)
    {
        $secondoMeseIntervallo=$mesi[$i][2];                        
    }
    if(strcmp($primoMeseIntervallo,$secondoMeseIntervallo)==0) // se l'utente ha scelto di fare i turni per un mese solo
    {
        $filename="Turno lettori ".$primoMeseIntervallo." ".$annoInCorso.".xls";
    }
    else
    {
        $filename="Turno lettori ".$primoMeseIntervallo."-".$secondoMeseIntervallo." ".$annoInCorso.".xls";
    }

    //istruzioni specifiche della conversione Excel
	header ("Content-Type: application/vnd.ms-excel");
	header ("Content-Disposition: inline; filename=$filename");
    // fine istruzioni specifiche della conversione Excel
?>
<html>
    <head>
        <title>Turni definitivi</title>
    </head>
    <body>
        <table border=1 width="100%">
            <tr bgcolor="yellow">
                <td width="20%" colspan="5"><div align="center"><font size=5><strong>TURNO LETTORI</strong></font></div></td>               
            </tr>
            <tr bgcolor="yellow">
            <?php
                $primoMeseIntervallo=$mesi[$meseNumerico-1][2]; //stabilisco il primo mese dell'intervallo scelto dall'utente
                $secondoMeseIntervallo="";
                for($i=$meseNumerico-1;$i<($meseNumerico-1+$numMesi);$i++)
                {
                    $secondoMeseIntervallo=$mesi[$i][2];                        
                }
                if(strcmp($primoMeseIntervallo,$secondoMeseIntervallo)==0) // se l'utente ha scelto di fare i turni per un mese solo
                {
                    echo("<td width='20%' colspan='5'><div align='center'><font size=5><strong>".$primoMeseIntervallo." ".$annoInCorso."</strong></font></div></td>");
                }
                else
                {
                    echo("<td width='20%' colspan='5'><div align='center'><font size=5><strong>".$primoMeseIntervallo." - ".$secondoMeseIntervallo." ".$annoInCorso."</strong></font></div></td>");
                }
            ?>
            </tr>
            <tr bgcolor="#add8e6">
                <td width="20%"><div align="center"><strong>DATA</strong></div></td>
                <td width="20%"><div align="center"><strong>PREFESTIVA</strong></div></td>
                <td width="20%"><div align="center"><strong>ORE 09:45</strong></div></td>
                <td width="20%"><div align="center"><strong>LETTORE</strong></div></td>
                <td width="20%"><div align="center"><strong>TELEFONO</strong></div></td>
            </tr>
            <?php
            if($numLettoriAttivi>$quanteMesse)
            {
                inserisciRighe($numLettoriAttivi);
            }
            else
            {
                inserisciRighe($quanteMesse);
            }
            ?>
        </table>
        <!-- <table border=1 bgcolor="#add8e6" width="100%">
            
        </table> 
        <table border=1 width="100%"></table>-->
        <br><br>
        <div align="justify">
            <strong>Come di consueto si raccomanda di cercare un sostituto in caso di assenza.</strong>
            <br><br>
            <?php
                if($meseNumerico==6 or $meseNumerico==7 or $meseNumerico==8)
                {
                    echo("<strong>Considerato il periodo estivo e le probabili assenze per le vacanze, si richiede particolare attenzione e la disponibilit&agrave; a leggere nel caso risulti assente il lettore di turno.</strong><br><br>");
                }
            ?>
            <strong>Grazie a tutti per l'impegno e la collaborazione.</strong>
        </div><br>
        <table border=0 width="100%">
            <tr>
                <td width="25%">&nbsp;</td>
                <td width="25%">&nbsp;</td>
                <td width="25%">&nbsp;</td>
                <td width="25%"><div align="center"><strong>Don Marco</strong></div></td>
            </tr>
        </table>
    <?php
    mysql_close($conn);
    ?>
    </body>
</html>