<?php
    $cognome=addslashes($_POST["cognome"]); // cognome del lettore
    //echo("Cognome: ".$cognome."<br>");
    $nome=addslashes($_POST["nome"]); // nome del lettore
    //echo("Nome: ".$nome."<br>");
    $telefono=$_POST["telefono"]; // telefono del lettore
    //echo("Telefono: ".$telefono."<br>");
    $preferenzaPrefestiva=$_POST["preferenzaPrefestiva"];
    //echo("Preferenza prefestiva: ".$preferenzaPrefestiva."<br>");
    $preferenzaFestiva=$_POST["preferenzaFestiva"];
    //echo("Preferenza festiva: ".$preferenzaFestiva."<br>");
    $attivo=$_POST["attivo"];
    //echo("Lettore attivo: ".$attivo."<br>");
    $preferenzaVespertina=$_POST["preferenzaVespertina"];
    //echo("Preferenza vespertina (nascosta): ".$preferenzaVespertina."<br>");

    $hostname='localhost';
	$username='root';
	$conn=mysql_connect($hostname,$username,'')
			or die("Impossibile stabilire una connessione con il server: ".mysql_error());
	$db=mysql_select_db('lettori')
			or die("Impossibile selezionare il database <i>Lettori</i>: ".mysql_error());

    $query="select count(*) from lettori";
    $risultato=mysql_query($query)
        or die("Impossibile contare gli lettori gi&agrave; presenti nel database: ".mysql_error());
    while($riga=mysql_fetch_row($risultato))
    {
        $quantiLettori=$riga[0];
    }
    
    $codiceSoggetto=$quantiLettori+1;
    
    $query="insert into lettori values (".$codiceSoggetto.",'".$cognome."','".$nome."','".$telefono."','".$preferenzaPrefestiva."','".$preferenzaFestiva."','".$preferenzaVespertina."','".$attivo."')";
    //echo("Query: ".$query."<br>");
    $risultato=mysql_query($query)
        or die("Impossibile inserire i dati del nuovo lettore: ".mysql_error());
?>
<html>
    <head>
        <title>Conferma inserimento</title>
    </head>
    <body>
        <div align="center"><h2>Inserimento effettuato con i seguenti dati:</h2></div>
        <?php
            $query="select * from lettori where codicesoggetto=".$codiceSoggetto;
            $risultato=mysql_query($query)
                or die("Impossibile estrarre i dati del lettore inserito: ".mysql_error());
            while($riga=mysql_fetch_row($risultato))
            {
                echo("
                    <table border='0' width='100%'>
                        <tr>
                            <td width='20%'><font size='5'>Cognome</font></td>
                            <td width='80%'><font size='5'>$riga[1]</font></td>
                        </tr>
                        <tr>
                            <td width='20%'><font size='5'>Nome</font></td>
                            <td width='80%'><font size='5'>$riga[2]</font></td>
                        </tr>
                        <tr>
                            <td width='20%'><font size='5'>Telefono</font></td>
                            <td width='80%'><font size='5'>$riga[3]</font></td>
                        </tr>
                        <tr>
                            <td width='20%'><font size='5'>Preferenza prefestiva</font></td>
                            <td width='80%'>");
                                if(strcmp($riga[4],'s')==0)
                                {
                                    echo("<font size='5'>S&igrave;</font>");
                                }
                                else
                                {
                                    echo("<font size='5'>No</font>");
                                }
                            echo("</td>
                        </tr>
                        <tr>
                            <td width='20%'><font size='5'>Preferenza festiva</font></td>
                            <td width='80%'>");
                                if(strcmp($riga[5],'s')==0)
                                {
                                    echo("<font size='5'>S&igrave;</font>");
                                }
                                else
                                {
                                    echo("<font size='5'>No</font>");
                                }                                
                            echo("</td>
                        </tr>
                        <tr>
                            <td width='20%'><font size='5'>Lettore in attivit&agrave;</font></td>
                            <td width='80%'>");
                                if(strcmp($riga[7],'s')==0)
                                {
                                    echo("<font size='5'>S&igrave;</font>");
                                }
                                else
                                {
                                    echo("<font size='5'>No</font>");
                                }  
                                echo("</td>
                        </tr>
                    </table>
                ");
            }
        ?>
        <br><br>
        <div align="center">
            <form name="modificaDati" action="modificaLettore.php" method="POST">
                <input type="hidden" name="codiceSoggetto" value="<?php echo($codiceSoggetto);?>">
                <input type="submit" name="invio" value="Modifica dati">
            </form>
        </div>
        <br>
        <table border="0" width="100%">
            <tr>
                <td width="50%" align="center"><a href="inserimentoLettore.html"><h2>Inserisci nuovo lettore</h2></a></td>
                <td width="50%" align="center"><a href="index.html"><h2>Torna alla pagina iniziale</h2></a></td>
            </tr>
        </table>
    </body>
</html>
<?php
    mysql_close($conn);
?>