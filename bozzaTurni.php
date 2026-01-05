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

    // qui ricevo l'array codificato da propostaCalendario.php
    $calendario3=$_POST["calendario3"];
    /*Una volta ricevuta l'informazione nella pagina di destinazione, devo compiere le operazioni inverse, ossia decodificare e deserializzare la variabile array utilizzando le istruzioni URLDECODE() e UNSERIALIZE(). */
    $calendario=unserialize(urldecode($calendario3));
    //echo("Gli elementi dell'array passato tramite form sono ".count($calendario)."<br>");
    
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
            if($calendario[$i][1]==$giornoSabatoSanto and $calendario[$i][2]==$mesePasqua)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].",Pasqua";
                $inserisci=true;
            }
            elseif($calendario[$i][1]==$giornoCeneri and $calendario[$i][2]==$meseCeneri)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Ceneri";
                $inserisci=true;
            }
            elseif($calendario[$i][1]==$giornoPalme and $calendario[$i][2]==$mesePalme)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Palme";
            }
            elseif($calendario[$i][1]==$giornoGiovediSanto and $calendario[$i][2]==$meseGiovediSanto)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Gioved&igrave; Santo";
                $inserisci=true;
            }
            elseif($calendario[$i][1]==$giornoVenerdiSanto and $calendario[$i][2]==$meseVenerdiSanto)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Venerd&igrave; Santo";
                $inserisci=true;
            }
            elseif($calendario[$i][1]==$giornoPasquetta and $calendario[$i][2]==$mesePasquetta)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Luned&igrave; dell'Angelo";
                $inserisci=true;
            }
            elseif(intval($calendario[$i][1])==1 and intval($calendario[$i][2])==1)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Maria SS. Madre di Dio";
                $inserisci=true;
            }
            elseif(intval($calendario[$i][1])==5 and intval($calendario[$i][2])==1)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].",Epifania";
                $inserisci=true;
            }
            elseif(intval($calendario[$i][1])==14 and intval($calendario[$i][2])==8)
            {
                if(strcmp($calendario[$i][0],"Dom")==0)
                {
                    $daInserire=$calendario[$i+1][1]."/".$calendario[$i+1][2].",Assunzione"; // se il 14 agosto è domenica, sulla messa dell'Assunzione non deve esserci prefestiva
                }
                else
                {
                    $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].",Assunzione";
                }
                $inserisci=true;
            }
            elseif(intval($calendario[$i][1])==8 and intval($calendario[$i][2])==9 and (strcmp($calendario[$i][0],"Sab")!=0) and (strcmp($calendario[$i][0],"Dom")!=0))
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Maria Bambina";
                $inserisci=true;
            }
            elseif($calendario[$i][0]=="Lun" and intval($calendario[$i][1])<>31 and intval($calendario[$i][2])==10)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Ufficio dei Defunti";
                $inserisci=true;
            }
            elseif(intval($calendario[$i][1])==31 and intval($calendario[$i][2])==10)
            {
                if($mese=="10" and $numMesi==1)
                {
                    if(strcmp($calendario[$i][0],"Dom")<>0) // se il 31/10 è domenica ed è stato selezionato solo il turno di ottobre, non ci deve essere nessuna menzione della messa di tutti i Santi, per cui le due istruzioni che seguono verranno svolte solo se l'utente sceglie il turno del solo mese di ottobre e se il 31/10 non è domenica
                    {
                        $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Tutti i Santi";
                        $inserisci=true;
                    }
                }
                else
                {
                    if($i==count($calendario))
                    {
                        if(strcmp($calendario[$i][0],"Dom")==0) // se il 31/10 è domenica e l'utente prevede anche l'estrazione di turni oltre il mese di ottobre, la festa di Tutti i Santi non ha messa prefestiva
                        {
                            $daInserire=$calendario[$i+1][1]."/".$calendario[$i+1][2].",Tutti i Santi";
                        }
                        else
                        {
                            $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].",Tutti i Santi";
                        }
                        $inserisci=true;
                    }
                    else
                    {
                        if(strcmp($calendario[$i][0],"Dom")==0) // se il 31/10 è domenica e l'utente prevede anche l'estrazione di turni oltre il mese di ottobre, la festa di Tutti i Santi non ha messa prefestiva
                        {
                            $daInserire="01/11,Tutti i Santi";
                        }
                        else
                        {
                            $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - 01/11,Tutti i Santi";
                        }
                        $inserisci=true;
                    }
                }
            }
            elseif(intval($calendario[$i][1])==2 and intval($calendario[$i][2])==11 and (strcmp($calendario[$i][0],"Sab")!=0) and (strcmp($calendario[$i][0],"Dom")!=0))
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Fedeli Defunti";
                $inserisci=true;
            }
            elseif(intval($calendario[$i][1])==8 and intval($calendario[$i][2])==12)
            {
                if(strcmp($calendario[$i][0],"Lun")==0) // se l'8 dicembre è lunedì, non c'è messa prefestiva
                {
                    $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Immacolata";
                }
                else
                {
                    $daInserire="07/12 - ".$calendario[$i][1]."/".$calendario[$i][2].",Immacolata";
                }
                $inserisci=true;
            }
            elseif(intval($calendario[$i][1])==24 and intval($calendario[$i][2])==12)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].",Natale";
                $inserisci=true;
            }
            elseif(intval($calendario[$i][1])==26 and intval($calendario[$i][2])==12 and (strcmp($calendario[$i][0],"Sab")!=0) and (strcmp($calendario[$i][0],"Dom")!=0))
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Santo Stefano";
                $inserisci=true;
            }
            elseif(intval($calendario[$i][1])==31 and intval($calendario[$i][2])==12)
            {
                $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - 01/01,Maria SS. Madre di Dio";
                $inserisci=true;
            }
            else
            {
                if(strcmp($calendario[$i][0],"Sab")==0 and ($i!=(count($calendario)-1)) and ($calendario[$i][1]!=$giornoSabatoSanto) and ($calendario[$i][2]!=$meseSabatoSanto)) // qui estraggo le ordinarie coppie sabato-domenica, ad eccezione che si tratti del weekend di Pasqua
                {
                    if(($calendario[$i][1]==$giornoPalme-1) and ($calendario[$i][2]==$mesePalme))
                    {
                        //echo("Passo 1");
                        $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].",Palme";
                        $inserisci=true;
                    }
                    else
                    {
                        //echo("Passo 2");
                        if(($calendario[$i][1]==15 and intval($calendario[$i][2])==8) or ($calendario[$i][1]==1 and intval($calendario[$i][2])==11) or ($calendario[$i][1]==8 and intval($calendario[$i][2])==12)) // se l'Assunzione, Tutti i Santi o l'Immacolata sono di sabato, la domenica che cade il giorno dopo non deve avere la prefestiva
                        {
                            $daInserire=$calendario[$i+1][1]."/".$calendario[$i+1][2].", "; // lo spazio dopo la virgola concatenata alla fine è intenzionale
                        }
                        else
                        {
                            $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].", "; // lo spazio dopo la virgola concatenata alla fine è intenzionale
                        }
                        $inserisci=true;
                    }
                }
                elseif(strcmp($calendario[$i][0],"Sab")==0 and ($i==(count($calendario)-1)) and ($calendario[$i][1]!=$giornoSabatoSanto) and ($calendario[$i][2]!=$meseSabatoSanto)) // qui estraggo le ordinarie coppie sabato-domenica, ad eccezione che si tratti del weekend di Pasqua
                {
                    if(($calendario[$i][1]==$giornoPalme-1) and ($calendario[$i][2]==$mesePalme))
                    {
                        //echo("Passo 3");
                        $daInserire=$calendario[$i][1]."/".$calendario[$i][2].",Palme";
                        $inserisci=true;
                    }
                    else
                    {
                        //echo("Passo 4");
                        $daInserire=$calendario[$i][1]."/".$calendario[$i][2].", "; // lo spazio dopo la virgola concatenata alla fine è intenzionale
                        $inserisci=true;
                    }
                }
                else
                {
                    $dataBreveSabatoSanto=substr($dataSabatoSanto,-5);
                    $concatenazioneGiornoMese=$calendario[$i][1]."-".$calendario[$i][2]; 
                    /*echo("Data sabato santo: ".$dataSabatoSanto."<br>");
                    echo("Data breve sabato santo: ".$dataBreveSabatoSanto."<br>");
                    echo("ConcatenazioneGiornoMese: ".$concatenazioneGiornoMese."<br>");*/
                    if((strcmp($calendario[$i][0],"Sab")==0) and (strcmp($dataBreveSabatoSanto,$concatenazioneGiornoMese))<>0) // se si tratta di un sabato e se non è il sabato santo
                    {
                        $daInserire=$calendario[$i][1]."/".$calendario[$i][2]." - ".$calendario[$i+1][1]."/".$calendario[$i+1][2].", "; // lo spazio dopo la virgola concatenata alla fine è intenzionale
                        $inserisci=true;
                    }
                }
            }
            
            //aggiungo $daInserire all'array $messe
            if($inserisci==true)
            {
                //echo("Ecco l'attuale contenuto di daInserire<br>");
                //echo($daInserire."<br>");
                array_push($messe,$daInserire);
            }
            $inserisci=false;
        }
    // fine script creazione array che conterrà i dati della prima colonna del turno lettori
    
    //inizio script per l'aggiunta delle messe di gennaio, nel caso in cui l'utente scelga di produrre i turni comprendendo il mese di dicembre (questo si rende necessario in quanto il programma consente di selezionare solo i mesi successivi al mese corrente e senza scavallare l'anno, quindi, di fatto, consente di creare turni solo da febbraio a dicembre, con gennaio non selezionabile. Visto che gennaio non è selezionabile, lo estraggo io d'ufficio se l'utente sceglie dicembre -> avrà cioè il turno di dicembre dell'anno n e di gennaio dell'anno n+1)
    if(intval($calendario[$i-1][2])==12) // se l'ultimo mese scelto dall'utente è dicembre, parto con lo script
    {
        $annoProssimo=$annoInCorso+1;
        $giornoNumericoPerTimestamp=2;
        do
        {
            if($giornoNumericoPerTimestamp<10)
                $giornoPerTimestamp="0".$giornoNumericoPerTimestamp;
            else
                $giornoPerTimestamp=$giornoNumericoPerTimestamp;
            $timestamp=strtotime($annoProssimo."/01/".$giornoPerTimestamp);
            //echo(date('D',$timestamp)."<br>");
            if(date('D',$timestamp)=="Mon") {$giornoItaliano="Lun";}
            elseif(date('D',$timestamp)=="Tue") {$giornoItaliano="Mar";}
            elseif(date('D',$timestamp)=="Wed") {$giornoItaliano="Mer";}
            elseif(date('D',$timestamp)=="Thu") {$giornoItaliano="Gio";}
            elseif(date('D',$timestamp)=="Fri") {$giornoItaliano="Ven";}
            elseif(date('D',$timestamp)=="Sat") {$giornoItaliano="Sab";}
            else {$giornoItaliano="Dom";}
            // qui adesso devono partire tutti i ragionamenti per valorizzare la variabile $daInserire (come già valorizzata nelle righe sopra di questo file) e farne la push nell'array $messe con l'istruzione array_push($messe,$daInserire);
            if((strcmp($giornoItaliano,"Dom")==0) and $giornoNumericoPerTimestamp==2)
            {
                $daInserire="02/01, ";
                array_push($messe,$daInserire);
            }
            if((strcmp($giornoItaliano,"Sab")==0) and $giornoNumericoPerTimestamp<31 and $giornoNumericoPerTimestamp<>6 and $giornoNumericoPerTimestamp<>5)
            {
                $seguente=$giornoPerTimestamp+1;
                if($seguente<10)
                    $seguente="0".$seguente;
                $daInserire=$giornoPerTimestamp."/01 - ".$seguente."/01, ";
                array_push($messe,$daInserire);
            }
            if((strcmp($giornoItaliano,"Dom")==0) and $giornoNumericoPerTimestamp==7)
            {
                $daInserire="07/01, ";
                array_push($messe,$daInserire);
            }
            if((strcmp($giornoItaliano,"Sab")==0) and $giornoNumericoPerTimestamp==31)
            {
                $daInserire="31/01 - 01/02, ";
                array_push($messe,$daInserire);
            }
            if((strcmp($giornoItaliano,"Dom")<>0) and $giornoNumericoPerTimestamp==5)
            {
                $daInserire="05/01 - 06/01,Epifania";
                array_push($messe,$daInserire);
            }
            if((strcmp($giornoItaliano,"Lun")==0) and $giornoNumericoPerTimestamp==6)
            {
                $daInserire="06/01,Epifania";
                array_push($messe,$daInserire);
            }
            $giornoNumericoPerTimestamp++;
        }
        while($giornoNumericoPerTimestamp<32);
    }
    //fine script per l'aggiunta delle messe di gennaio, nel caso in cui l'utente scelta di produrre i turni comprendendo il mese di dicembre
    
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

    $lettoriFestivi=array();
    $lettoriPrefestivi=array();


    //funzione inserisciRighe che verrà usata nel <body> per popolare la tabella dei turni
    function inserisciRighe($quante)
    {
        global $messe; // ridefinisco la variabile $messe all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        global $quanteMesse; // ridefinisco la variabile $quanteMesse all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        global $meseFinaleDaCompilare; // ridefinisco la variabile $meseFinaleDaCompilare all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        global $annoInCorso; // ridefinisco la variabile $annoInCorso all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        global $ultimoGiornoIntervalloScelto; // ridefinisco la variabile $ultimoGiornoIntervalloScelto all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        global $numLettoriAttivi; // ridefinisco la variabile $numLettoriAttivi all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        
        $stringaIntegrazione="";

        //variabili per lettori prefestivi
        $prefestiviScorsi=0; //aumenta di uno ogni volta che mando a video un prefestivo e si riazzera per permettere di continuare a mandare a video i prefestivi
        global $lettoriPrefestivi; // ridefinisco la variabile $lettoriPrefestivi all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        $quantiLettoriPrefestivi=0;

        //variabili per lettori festivi
        $festiviScorsi=0; //aumenta di uno ogni volta che mando a video un festivo e si riazzera per permettere di continuare a mandare a video i festivi
        global $lettoriFestivi; // ridefinisco la variabile $lettoriFestivi all'interno di questa funzione con scope global, così mi riferisco alla variabile omonima definita fuori dalla funzione stessa
        $quantiLettoriFestivi=0;
        $lettoriFestiviInRosso=false;

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
            $stringaSuperamentoIntervallo=""; // stringa che si valorizza solo se la domenica dell'ultimo weekend estratto è il primo giorno del mese successivo all'invervallo di mesi scelto
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
                                if($mesePerIntegrazione==13)
                                {
                                    $mesePerIntegrazione=1;
                                }
                                if(strval($mesePerIntegrazione)<10)
                                {
                                    $stringaIntegrazione="01/0".strval($mesePerIntegrazione);
                                }
                                else
                                {
                                    $stringaIntegrazione="01/".strval($mesePerIntegrazione);
                                }
                                if(strcmp($stringaIntegrazione,"01/1")==0) // il 31/12 è sabato
                                {
                                    echo("<td align='center' colspan='2' width='20%'>".$messa[0]."</td>");
                                }
                                else
                                {
                                    echo("<td align='center' colspan='2' width='20%'>".$messa[0]." - <font color='red'><strong>".$stringaIntegrazione."</strong></font></td>");
                                    $lettoriFestiviInRosso=true;
                                    $stringaSuperamentoIntervallo=$messa[0]." - ".$stringaIntegrazione;
                                }                                
                            }
                            else
                            {
                                echo("<td align='center' colspan='2' width='20%'>".$messa[0]."</td>");
                            }
                        }
                        else
                        {
                            echo("<td align='center' colspan='2' width='20%'>".$messa[0]."</td>");
                        }
                    }
                    else
                    {
                        if(strlen($messa[0])==5)
                        {
                            if(strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)==0)
                            {
                                $mesePerIntegrazione=$meseFinaleDaCompilare+1;
                                if($mesePerIntegrazione==13)
                                {
                                    $mesePerIntegrazione=1;
                                }
                                if(strval($mesePerIntegrazione)<10)
                                {
                                    $stringaIntegrazione="01/0".strval($mesePerIntegrazione);
                                }
                                else
                                {
                                    $stringaIntegrazione="01/".strval($mesePerIntegrazione);
                                }
                                if(strcmp($stringaIntegrazione,"01/1")==0) // il 31/12 è sabato
                                {
                                    echo("<td align='center' colspan='2' width='20%'><strong>".$messa[1]."</strong><br>".$messa[0]."</td>");
                                }
                                else
                                {
                                    echo("<td align='center' colspan='2' width='20%'><strong>".$messa[1]."</strong><br>".$messa[0]." - <font color='red'><strong>".$stringaIntegrazione."</strong></font></td>");
                                    $lettoriFestiviInRosso=true;
                                    $stringaSuperamentoIntervallo=$messa[0]." - ".$stringaIntegrazione;
                                }                          
                            }
                            else
                            {
                                echo("<td align='center' colspan='2' width='20%'><strong>".$messa[1]."</strong><br>".$messa[0]."</td>");
                            }
                        }
                        else
                        {
                            // qui recupero i mesi delle due date presenti in $messa[0]
                            $primoMese=strval(substr($messa[0],0,2));
                            $secondoMese=strval(substr($messa[0],-2,2));

                            if($secondoMese>$meseFinaleDaCompilare)
                            {
                                echo("<td align='center' colspan='2' width='20%'><strong>".$messa[1]."</strong><br>".substr($messa[0],0,5)." - <font color='red'><strong>01/".$secondoMese."</strong></font></td>");
                                $lettoriFestiviInRosso=true;
                                $stringaSuperamentoIntervallo=substr($messa[0],0,5)."01/".$secondoMese;
                            }
                            else
                            {
                                echo("<td align='center' colspan='2' width='20%'><strong>".$messa[1]."</strong><br>".$messa[0]."</td>");
                                /*echo("<td align='center' colspan='2' width='20%'><strong>".$messa[1]."</strong><br>".$messa[0]."<br>Ultimo giorno intervallo scelto: ".$ultimoGiornoIntervalloScelto."<br>Data da confrontare: ".$dataDaConfrontare."</td>");*/
                            }
                        }
                    }
                }
                else
                {
                    echo("<td align='center' colspan='2' width='20%'>&nbsp;</td>");
                }
                //fine colonna messe

                //echo("Stringa superamento intervallo: ".$stringaSuperamentoIntervallo."<br>");
                
                //colonna lettori prefestivi
                echo("<td align='center' width='20%'>");
                    $j=0;
                    if($i==0)
                    {
                        $query="select count(*) from lettori where preferenzaPrefestiva='S' and attivo='S'";
                        $risultato=mysql_query($query)
                            or die ("Impossibile effettuare il conteggio dei lettori prefestivi: ".mysql_error());
                        while($riga=mysql_fetch_row($risultato))
                        {
                            $quantiLettoriPrefestivi=$riga[0];
                            //echo($quantiLettoriPrefestivi."<br>");
                        }
                        $query="select cognome, nome from lettori where preferenzaPrefestiva='S' and attivo='S'";
                        $risultato=mysql_query($query)
                            or die("Impossibile estrarre i lettori da assegnare alle messe prefestive: ".mysql_error());
                        while($riga=mysql_fetch_row($risultato))
                        {
                            $lettoriPrefestivi[$j]=$riga[0]." ".$riga[1];
                            //echo($lettoriPrefestivi[$j]."<br>");
                            $j++;
                        }
                        shuffle($lettoriPrefestivi); //mescolo a caso gli elementi dell'array $lettoriPrefestivi                        
                    }
                    //print_r($lettoriPrefestivi); // funzione che manda a video gli elementi di un array senza fare un ciclo
                    //echo("<br>");
                    //echo("Sono passato? ".$sonoPassato."<br>");
                    if(($prefestiviScorsi<$quantiLettoriPrefestivi) and ($i<$quanteMesse))
                    {
                        if(strcmp($messa[1],"Santo Stefano")==0)
                            echo("/"); // se è Santo Stefano, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Luned&igrave; dell'Angelo")==0)
                            echo("/"); // se è il lunedì dell'Angelo, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Ufficio dei Defunti")==0)
                            echo("/"); // se è il lunedì della sagra, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Maria Bambina")==0)
                            echo("/"); // se è Maria Bambina, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Ceneri")==0)
                            echo("/"); // se è il Mercoledì delle Ceneri, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Gioved&igrave; Santo")==0)
                            echo("/"); // se è il Giovedì Santo, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Venerd&igrave; Santo")==0)
                            echo("/"); // se è il Venerdì Santo, non devono essere mostrati lettori prefestivi
                        elseif((strlen($messa[0])==5) and (strcmp($stringaSuperamentoIntervallo,"")==0) and  strcmp($messa[1],"Pasqua")<>0)
                            echo("/"); /* questa condizione si verifica se nella colonna delle date c'è una data sola, cioè:
                                - se il 14 agosto è domenica -> in questo caso sulla messa dell'Assunzione non deve esserci prefestiva, quindi niente lettori prefestivi
                                - se il 31/10 è domenica e l'utente prevede anche l'estrazione di turni oltre il mese di ottobre -> in questo caso la festa di Tutti i Santi non ha messa prefestiva, quindi niente lettori prefestivi
                                - se l'8 dicembre è lunedì -> in questo caso non c'è messa prefestiva, quindi niente lettori prefestivi
                                - se l'Assunzione, Tutti i Santi o l'Immacolata sono di sabato -> in questo caso la domenica che cade il giorno dopo non deve avere la prefestiva, quindi niente lettori prefestivi della domenica se il giorno precedente è l'Assunzione, Tutti i Santi o l'Immacolata
                            */
                        else
                        {
                            echo($lettoriPrefestivi[$prefestiviScorsi]."<br>");
                            $prefestiviScorsi++;
                        }
                        $sonoPassato=true;
                        //echo(" prefestivi scorsi: ".$prefestiviScorsi." ");
                        //echo(" passo<br>");
                    }
                    if(($prefestiviScorsi<$quantiLettoriPrefestivi) and ($i<$quanteMesse))
                    {
                        if(strcmp($messa[1],"Santo Stefano")==0)
                            echo("/"); // se è Santo Stefano, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Luned&igrave; dell'Angelo")==0)
                            echo("/"); // se è il lunedì dell'Angelo, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Ufficio dei Defunti")==0)
                            echo("/"); // se è il lunedì della sagra, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Maria Bambina")==0)
                            echo("/"); // se è Maria Bambina, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Ceneri")==0)
                            echo("/"); // se è il Mercoledì delle Ceneri, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Gioved&igrave; Santo")==0)
                            echo("/"); // se è il Giovedì Santo, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Venerd&igrave; Santo")==0)
                            echo("/"); // se è il Venerdì Santo, non devono essere mostrati lettori prefestivi
                        elseif((strlen($messa[0])==5) and (strcmp($stringaSuperamentoIntervallo,"")==0) and  strcmp($messa[1],"Pasqua")<>0)
                            echo("/"); /* questa condizione si verifica se nella colonna delle date c'è una data sola, cioè:
                                - se il 14 agosto è domenica -> in questo caso sulla messa dell'Assunzione non deve esserci prefestiva, quindi niente lettori prefestivi
                                - se il 31/10 è domenica e l'utente prevede anche l'estrazione di turni oltre il mese di ottobre -> in questo caso la festa di Tutti i Santi non ha messa prefestiva, quindi niente lettori prefestivi
                                - se l'8 dicembre è lunedì -> in questo caso non c'è messa prefestiva, quindi niente lettori prefestivi
                                - se l'Assunzione, Tutti i Santi o l'Immacolata sono di sabato -> in questo caso la domenica che cade il giorno dopo non deve avere la prefestiva, quindi niente lettori prefestivi della domenica se il giorno precedente è l'Assunzione, Tutti i Santi o l'Immacolata
                            */
                        else
                        {
                            //echo("Messe[1]: ".$messe[1]."<br>");
                            echo($lettoriPrefestivi[$prefestiviScorsi]);
                            $prefestiviScorsi++;
                        }
                        $sonoPassato=true;
                        //echo(" prefestivi scorsi: ".$prefestiviScorsi." ");
                        //echo(" passo ancora<br>");
                    }
                    elseif($prefestiviScorsi==$quantiLettoriPrefestivi and $sonoPassato==true and $i<$quanteMesse)
                    {
                        if(strcmp($messa[1],"Santo Stefano")==0)
                            echo("/"); // se è Santo Stefano, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Luned&igrave; dell'Angelo")==0)
                            echo("/"); // se è il lunedì dell'Angelo, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Ufficio dei Defunti")==0)
                            echo("/"); // se è il lunedì della sagra, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Maria Bambina")==0)
                            echo("/"); // se è Maria Bambina, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Ceneri")==0)
                            echo("/"); // se è il Mercoledì delle Ceneri, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Gioved&igrave; Santo")==0)
                            echo("/"); // se è il Giovedì Santo, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Venerd&igrave; Santo")==0)
                            echo("/"); // se è il Venerdì Santo, non devono essere mostrati lettori prefestivi
                        elseif((strlen($messa[0])==5) and (strcmp($stringaSuperamentoIntervallo,"")==0) and  strcmp($messa[1],"Pasqua")<>0)
                            echo("/"); /* questa condizione si verifica se nella colonna delle date c'è una data sola, cioè:
                                - se il 14 agosto è domenica -> in questo caso sulla messa dell'Assunzione non deve esserci prefestiva, quindi niente lettori prefestivi
                                - se il 31/10 è domenica e l'utente prevede anche l'estrazione di turni oltre il mese di ottobre -> in questo caso la festa di Tutti i Santi non ha messa prefestiva, quindi niente lettori prefestivi
                                - se l'8 dicembre è lunedì -> in questo caso non c'è messa prefestiva, quindi niente lettori prefestivi
                                - se l'Assunzione, Tutti i Santi o l'Immacolata sono di sabato -> in questo caso la domenica che cade il giorno dopo non deve avere la prefestiva, quindi niente lettori prefestivi della domenica se il giorno precedente è l'Assunzione, Tutti i Santi o l'Immacolata
                            */
                        else
                        {
                            echo($lettoriPrefestivi[0]);
                            $prefestiviScorsi=1;
                        }
                        //echo(" prefestivi scorsi: ".$prefestiviScorsi." ");
                        //echo(" passo ancora e ancora<br>");
                    }
                    elseif($prefestiviScorsi==$quantiLettoriPrefestivi and $sonoPassato==false and $i<$quanteMesse)
                    {
                        if(strcmp($messa[1],"Santo Stefano")==0)
                            echo("/"); // se è Santo Stefano, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Luned&igrave; dell'Angelo")==0)
                            echo("/"); // se è il lunedì dell'Angelo, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Ufficio dei Defunti")==0)
                            echo("/"); // se è il lunedì della sagra, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Maria Bambina")==0)
                            echo("/"); // se è Maria Bambina, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Ceneri")==0)
                            echo("/"); // se è il Mercoledì delle Ceneri, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Gioved&igrave; Santo")==0)
                            echo("/"); // se è il Giovedì Santo, non devono essere mostrati lettori prefestivi
                        elseif(strcmp($messa[1],"Venerd&igrave; Santo")==0)
                            echo("/"); // se è il Venerdì Santo, non devono essere mostrati lettori prefestivi
                        elseif((strlen($messa[0])==5) and (strcmp($stringaSuperamentoIntervallo,"")==0) and  strcmp($messa[1],"Pasqua")<>0)
                            echo("/"); /* questa condizione si verifica se nella colonna delle date c'è una data sola, cioè:
                                - se il 14 agosto è domenica -> in questo caso sulla messa dell'Assunzione non deve esserci prefestiva, quindi niente lettori prefestivi
                                - se il 31/10 è domenica e l'utente prevede anche l'estrazione di turni oltre il mese di ottobre -> in questo caso la festa di Tutti i Santi non ha messa prefestiva, quindi niente lettori prefestivi
                                - se l'8 dicembre è lunedì -> in questo caso non c'è messa prefestiva, quindi niente lettori prefestivi
                                - se l'Assunzione, Tutti i Santi o l'Immacolata sono di sabato -> in questo caso la domenica che cade il giorno dopo non deve avere la prefestiva, quindi niente lettori prefestivi della domenica se il giorno precedente è l'Assunzione, Tutti i Santi o l'Immacolata
                            */
                        else
                        {
                            echo($lettoriPrefestivi[0]."<br>".$lettoriPrefestivi[1]);
                            $prefestiviScorsi=2;
                        }
                    }
                echo("</td>");
                //fine colonna lettori prefestivi

                //colonna lettori festivi
                $hoScrittoAzioneCattolica=0;
                echo("<td align='center' width='20%'>");
                $k=0;
                $dataDaConfrontare=substr($messa[0],-5,2)."/".strval($meseFinaleDaCompilare)."/".strval($annoInCorso);
                //echo($dataDaConfrontare."<br>");
                if($i==0)
                {
                    $query="select count(*) from lettori where preferenzaFestiva='S' and attivo='S'";
                    $risultato=mysql_query($query)
                        or die ("Impossibile effettuare il conteggio dei lettori festivi: ".mysql_error());
                    while($riga=mysql_fetch_row($risultato))
                    {
                        $quantiLettoriFestivi=$riga[0];
                        //echo($quantiLettoriFestivi."<br>");
                    }
                    $query="select cognome, nome from lettori where preferenzaFestiva='S' and attivo='S'";
                    $risultato=mysql_query($query)
                        or die("Impossibile estrarre i lettori da assegnare alle messe prefestive: ".mysql_error());
                    while($riga=mysql_fetch_row($risultato))
                    {
                        $lettoriFestivi[$k]=$riga[0]." ".$riga[1];
                        //echo($lettoriFestivi[$k]."<br>");
                        $k++;
                    }
                    shuffle($lettoriFestivi); //mescolo a caso gli elementi dell'array $lettoriFestivi                        
                }
                //print_r($lettoriFestivi); // funzione che manda a video gli elementi di un array senza fare un ciclo
                //echo("<br>");
                //echo("Sono passato? ".$sonoPassatoFestivo."<br>");
                if(($festiviScorsi<$quantiLettoriFestivi) and ($i<$quanteMesse))
                {
                    if((strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)<>0) and ($lettoriFestiviInRosso==false))
                    {
                        if((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==0)
                        {
                            echo("<strong>AZIONE<br>CATTOLICA</strong>");
                            $hoScrittoAzioneCattolica=1;
                        }
                        elseif((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==1)
                        {
                            echo(""); // se è l'immacolata ed è già stato scritto azione cattolica, non c'è da fare niente
                        }
                        else
                        {
                            echo($lettoriFestivi[$festiviScorsi]."<br>");
                            $festiviScorsi++;
                        }
                        $sonoPassatoFestivo=true;
                    }
                    else
                    {
                        /*echo("FestiviScorsi: ".$festiviScorsi."<br>");
                        echo("QuantiLettoriFestivi: ".$quantiLettoriFestivi."<br>");
                        echo("i: ".$i."<br>");
                        echo("QuanteMesse: ".$quanteMesse."<br>");
                        echo("UltimoGiornoIntervalloScelto: ".$ultimoGiornoIntervalloScelto."<br>");
                        echo("DataDaConfrontare: ".$dataDaConfrontare."<br>");
                        echo("LettoriFestiviInRosso: ".$lettoriFestiviInRosso."<br>");*/
                        if($lettoriFestiviInRosso==true)
                        {
                            if(strcmp($stringaIntegrazione,"01/1")==0) // il 31/12 è sabato
                            {
                                echo("/");
                            }
                            else
                            {
                                echo("<font color='red'><strong>".$lettoriFestivi[$festiviScorsi]."</strong></font><br>");
                            }
                        }
                        else
                        {
                            if(strcmp($stringaIntegrazione,"01/1")==0) // il 31/12 è sabato
                            {
                                echo("/");
                            }
                            else
                            {
                                if((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==0)
                                {
                                    echo("<strong>AZIONE<br>CATTOLICA</strong>");
                                    $hoScrittoAzioneCattolica=1;
                                }
                                elseif((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==1)
                                {
                                    echo(""); // se è l'immacolata ed è già stato scritto azione cattolica, non c'è da fare niente
                                }
                                else
                                {
                                    echo($lettoriFestivi[$festiviScorsi]."<br>");
                                }
                            }
                        }
                        //echo("Stringa integrazione: ".$stringaIntegrazione." - passo qui 1<br>");
                        $festiviScorsi++;
                        $sonoPassatoFestivo=true;
                    }
                    //echo(" festivi scorsi: ".$festiviScorsi." ");
                    //echo(" passo<br>");
                }
                if(($festiviScorsi<$quantiLettoriFestivi) and ($i<$quanteMesse))
                {
                    if((strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)<>0) and ($lettoriFestiviInRosso==false))
                    {
                        if((strcmp($messa[1],"Santo Stefano")==0) or (strcmp($messa[1],"Luned&igrave; dell'Angelo")==0) or (strcmp($messa[1],"Ufficio dei Defunti")==0) or (strcmp($messa[1],"Maria Bambina")==0))
                        {
                            echo("/"); // se è Santo Stefano, il lunedì dell'angelo, l'ufficio dei defunti alla sagra o la festa di Maria Bambina, serve un lettore solo
                        }
                        else
                        {
                            if((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==0)
                            {
                                echo("<strong>AZIONE<br>CATTOLICA</strong>");
                                $hoScrittoAzioneCattolica=1;
                            }
                            elseif((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==1)
                            {
                                echo(""); // se è l'immacolata ed è già stato scritto azione cattolica, non c'è da fare niente
                            }
                            else
                            {
                                echo($lettoriFestivi[$festiviScorsi]);
                                $festiviScorsi++;
                            }
                        }
                        $sonoPassatoFestivo=true;
                    }
                    else
                    {
                        if($lettoriFestiviInRosso==true)
                        {
                            if(strcmp($stringaIntegrazione,"01/1")==0) // il 31/12 è sabato
                            {
                                echo("/");
                            }
                            else
                            {
                                echo("<font color='red'><strong>".$lettoriFestivi[$festiviScorsi]."</strong></font><br>");
                            }
                        }
                        else
                        {
                             if(strcmp($stringaIntegrazione,"01/1")==0) // il 31/12 è sabato
                            {
                                echo("/");
                            }
                            else
                            {
                                if((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==0)
                                {
                                    echo("<strong>AZIONE<br>CATTOLICA</strong>");
                                    $hoScrittoAzioneCattolica=1;
                                }
                                elseif((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==1)
                                {
                                    echo(""); // se è l'immacolata ed è già stato scritto azione cattolica, non c'è da fare niente
                                }
                                else
                                {
                                    echo($lettoriFestivi[$festiviScorsi]."<br>");
                                }
                            }
                        }
                        //echo("Stringa integrazione: ".$stringaIntegrazione." - passo qui 2<br>");
                        $festiviScorsi++;
                        $sonoPassatoFestivo=true;
                    }
                    //echo(" festivi scorsi: ".$festiviScorsi." ");
                    //echo(" passo ancora<br>");
                }
                elseif($festiviScorsi==$quantiLettoriFestivi and $sonoPassatoFestivo==true and $i<$quanteMesse)
                {
                   if((strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)<>0) and ($lettoriFestiviInRosso==false))
                    {
                        if((strcmp($messa[1],"Santo Stefano")==0) or (strcmp($messa[1],"Luned&igrave; dell'Angelo")==0) or (strcmp($messa[1],"Ufficio dei Defunti")==0) or (strcmp($messa[1],"Maria Bambina")==0))
                        {
                            echo("/"); // se è Santo Stefano, il lunedì dell'angelo, l'ufficio dei defunti alla sagra o la festa di Maria Bambina, serve un lettore solo
                        }
                        else
                        {
                            if((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==0)
                            {
                                echo("<strong>AZIONE<br>CATTOLICA</strong>");
                                $hoScrittoAzioneCattolica=1;
                            }
                            elseif((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==1)
                            {
                                echo(""); // se è l'immacolata ed è già stato scritto azione cattolica, non c'è da fare niente
                            }
                            else
                            {
                                echo($lettoriFestivi[0]);
                                $festiviScorsi=1;
                            }
                        }
                    }
                    else
                    {
                        if($lettoriFestiviInRosso==true)
                        {
                            echo("<font color='red'><strong>".$lettoriFestivi[0]."</strong></font><br>");
                        }
                        else
                        {
                            if((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==0)
                            {
                                echo("<strong>AZIONE<br>CATTOLICA</strong>");
                                $hoScrittoAzioneCattolica=1;
                            }
                            elseif((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==1)
                            {
                                echo(""); // se è l'immacolata ed è già stato scritto azione cattolica, non c'è da fare niente
                            }
                            else
                            {
                                echo($lettoriFestivi[0]."<br>");
                            }
                        }
                        //echo("passo qui 3<br>");
                        $festiviScorsi=1;
                    }
                    //echo(" festivi scorsi: ".$festiviScorsi." ");
                    //echo(" passo ancora e ancora<br>");
                }
                elseif($festiviScorsi==$quantiLettoriFestivi and $sonoPassatoFestivo==false and $i<$quanteMesse)
                {
                   if((strcmp($ultimoGiornoIntervalloScelto,$dataDaConfrontare)<>0) and ($lettoriFestiviInRosso==false))
                    {
                        if((strcmp($messa[1],"Santo Stefano")==0) or (strcmp($messa[1],"Luned&igrave; dell'Angelo")==0) or (strcmp($messa[1],"Ufficio dei Defunti")==0) or (strcmp($messa[1],"Maria Bambina")==0))
                        {
                            echo($lettoriFestivi[0]."<br> /"); // se è Santo Stefano, il lunedì dell'angelo, l'ufficio dei defunti alla sagra o la festa di Maria Bambina, serve un lettore solo
                            $festiviScorsi=1;
                        }
                        else
                        {
                            if((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==0)
                            {
                                echo("<strong>AZIONE<br>CATTOLICA</strong>");
                                $hoScrittoAzioneCattolica=1;
                            }
                            elseif((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==1)
                            {
                                echo(""); // se è l'immacolata ed è già stato scritto azione cattolica, non c'è da fare niente
                            }
                            else
                            {
                                echo($lettoriFestivi[0]."<br>".$lettoriFestivi[1]);
                                $festiviScorsi=2;
                            }
                        }
                    }
                    else
                    {
                        if($lettoriFestiviInRosso==true)
                        {
                            if(strcmp($stringaIntegrazione,"01/1")==0) // il 31/12 è sabato
                            {
                                echo("//");
                            }
                            else
                            {
                                echo("<font color='red'><strong>".$lettoriFestivi[0]."<br>".$lettoriFestivi[1]."</strong></font><br>");
                            }
                        }
                        else
                        {
                            if(strcmp($stringaIntegrazione,"01/1")==0) // il 31/12 è sabato
                            {
                                echo("//");
                            }
                            else
                            {
                                if((strcmp($messa[1],"Santo Stefano")==0) or (strcmp($messa[1],"Luned&igrave; dell'Angelo")==0) or (strcmp($messa[1],"Ufficio dei Defunti")==0) or (strcmp($messa[1],"Maria Bambina")==0))
                                {
                                        echo($lettoriFestivi[0]."<br>/<br>"); // se è Santo Stefano, il lunedì dell'angelo, l'ufficio dei defunti alla sagra o la festa di Maria Bambina, serve un lettore solo
                                        $festiviScorsi=1;
                                }
                                else
                                {
                                    if((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==0)
                                    {
                                        echo("<strong>AZIONE<br>CATTOLICA</strong>");
                                        $hoScrittoAzioneCattolica=1;
                                    }
                                    elseif((strcmp($messa[1],"Immacolata")==0) and $hoScrittoAzioneCattolica==1)
                                    {
                                        echo(""); // se è l'immacolata ed è già stato scritto azione cattolica, non c'è da fare niente
                                    }
                                    else
                                    {
                                        echo($lettoriFestivi[0]."<br>".$lettoriFestivi[1]."<br>");
                                        $festiviScorsi=2;
                                    }
                                }
                            }
                        }
                        //echo("passo qui 4<br>");
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


                // colonna dei numeri di telefono dei lettori in ordine alfabetico (per cognome)
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
                // fine colonna dei numeri di telefono dei lettori in ordine alfabetico (per cognome)
            echo("</tr>");
        }
    }
?>
<html>
    <head>
        <title>Bozza turni</title>
    </head>
    <body>
        <table border=1 width="100%" bgcolor="yellow">
            <tr>
                <td width="100%"><div align="center"><font size=5><strong>TURNO LETTORI</strong></font></div></td>               
            <tr>
            <?php
                $primoMeseIntervallo=$mesi[$meseNumerico-1][2]; //stabilisco il primo mese dell'intervallo scelto dall'utente
                $secondoMeseIntervallo="";
                for($i=$meseNumerico-1;$i<($meseNumerico-1+$numMesi);$i++)
                {
                    $secondoMeseIntervallo=$mesi[$i][2];                        
                }
                $annoProssimo=$annoInCorso+1;
                if(strcmp($primoMeseIntervallo,$secondoMeseIntervallo)==0) // se l'utente ha scelto di fare i turni per un mese solo
                {
                    if(strcmp($secondoMeseIntervallo,"Dicembre")==0) // se il mese con cui finisce il turno è dicembre, nel titolo inserisco anche gennaio dell'anno dopo
                    {
                        echo("<td width='100%'><div align='center'><font size=5><strong>".$primoMeseIntervallo." ".$annoInCorso." e Gennaio ".$annoProssimo."</strong></font></div></td>");
                    }
                    else
                    {
                        echo("<td width='100%'><div align='center'><font size=5><strong>".$primoMeseIntervallo." ".$annoInCorso."</strong></font></div></td>");
                    }
                }
                else
                {
                    if(strcmp($secondoMeseIntervallo,"Dicembre")==0) // se il mese con cui finisce il turno è dicembre, nel titolo inserisco anche gennaio dell'anno dopo
                    {
                        echo("<td width='100%'><div align='center'><font size=5><strong>".$primoMeseIntervallo." - ".$secondoMeseIntervallo." ".$annoInCorso." e Gennaio ".$annoProssimo."</strong></font></div></td>");
                    }
                    else
                    {
                        echo("<td width='100%'><div align='center'><font size=5><strong>".$primoMeseIntervallo." - ".$secondoMeseIntervallo." ".$annoInCorso."</strong></font></div></td>");
                    }
                }
            ?> 
        </table>
        <table border=1 bgcolor="#add8e6" width="100%">
            <tr>
                <td width="20%"><div align="center"><strong>DATA</strong></div></td>
                <td width="20%"><div align="center"><strong>PREFESTIVA</strong></div></td>
                <td width="20%"><div align="center"><strong>ORE 09:45</strong></div></td>
                <td width="20%"><div align="center"><strong>LETTORE</strong></div></td>
                <td width="20%"><div align="center"><strong>TELEFONO</strong></div></td>
            </tr>
        </table>
        <table border=1 width="100%"><?php
            if($numLettoriAttivi>$quanteMesse)
            {
                inserisciRighe($numLettoriAttivi);
            }
            else
            {
                inserisciRighe($quanteMesse);
            }
        ?></table>
        <br><br>
        <div align="justify"><strong>
            Come di consueto si raccomanda di cercare un sostituto in caso di assenza.
            <br><br>
            <?php
                if(($meseNumerico==1 and $numMesi>6) or ($meseNumerico==2 and $numMesi>5) or ($meseNumerico==3 and $numMesi>4) or ($meseNumerico==4 and $numMesi>3) or ($meseNumerico==5 and $numMesi>2) or ($meseNumerico==6 and $numMesi>1) or $meseNumerico==7 or $meseNumerico==8)
                {
                    echo("Considerato il periodo estivo e le probabili assenze per le vacanze, si richiede particolare attenzione e la disponibilit&agrave; a leggere nel caso risulti assente il lettore di turno.<br><br>");
                }
            ?>
            Grazie a tutti per l'impegno e la collaborazione.
        </strong></div>
        <table border=0 width="100%">
            <tr>
                <td width="33%">&nbsp;</td>
                <td width="34%">&nbsp;</td>
                <td width="33%"><div align="center"><strong>Don Stefano</strong></div></td>
            </tr>
        </table>
    <?php
    mysql_close($conn);    

    /* per effettuare il passaggio di un array tramite form seguo quanto scritto alla pagina
    https://www.andreaminini.com/php/come-passare-un-array-tramite-form-con-php */
    // Come prima cosa serializzo l'array tramite l'istruzione SERIALIZE()
    $calendario2=serialize($calendario);
    $lettoriPrefestivi2=serialize($lettoriPrefestivi);
    $lettoriFestivi2=serialize($lettoriFestivi);
    // In questo modo tutti gli elementi del vettore sono disposti in serie, separati tra loro da un carattere separatore, come un'unica informazione.
    // Il secondo passo consiste nella codifica della variabile serializzata tramite l'istruzione URLENCODE().
    $calendario3=urlencode($calendario2);
    $lettoriPrefestivi3=urldecode($lettoriPrefestivi2);
    $lettoriFestivi3=urlencode($lettoriFestivi2);
    // Così facendo evito che alcuni caratteri siano confusi con i simboli di separazione degli elementi dell'array.
    // la variabile $array3 sarà quella da passare nella form
    ?>

    <hr size=2>
    <form name="conversioneExcel" action="conversioneExcel.php" method="POST">
        <?php
            echo("<input name='mese' type='hidden' value='$mese'>");
            echo("<input name='numMesi' type='hidden' value='$numMesi'>");
            echo("<input name='calendario3' type='hidden' value='$calendario3'>");
            echo("<input name='lettoriPrefestivi3' type='hidden' value='$lettoriPrefestivi3'>");
            echo("<input name='lettoriFestivi3' type='hidden' value='$lettoriFestivi3'>");
        ?>
        <center><input type="submit" name="invio" value="Esporta in Excel"></center>
    </form>
    </body>
</html>