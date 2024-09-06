<?php
    $codiceSoggetto=$_POST["codiceSoggetto"];
    //echo("Codice soggetto passato: ".$codiceSoggetto."<br>");
    $cognome=addslashes($_POST["cognome"]);
    //echo("Cognome passato: ".$cognome."<br>");
    $nome=addslashes($_POST["nome"]);
    //echo("Nome passato: ".$nome."<br>");
    $telefono=$_POST["telefono"];
    //echo("Telefono passato: ".$telefono."<br>");
    $preferenzaPrefestiva=$_POST["preferenzaPrefestiva"];
    //echo("Preferenza prefestiva: ".$preferenzaPrefestiva."<br>");
    $preferenzaFestiva=$_POST["preferenzaFestiva"];
    //echo("Preferenza festiva: ".$preferenzaFestiva."<br>");
    $attivo=$_POST["attivo"];
    //echo("Lettore attivo: ".$attivo."<br>");
    $hostname='localhost';
	$username='root';
	$conn=mysql_connect($hostname,$username,'')
			or die("Impossibile stabilire una connessione con il server: ".mysql_error());
	$db=mysql_select_db('lettori')
			or die("Impossibile selezionare il database <i>Lettori</i>: ".mysql_error());
    $query="update lettori set cognome='".$cognome."',nome='".$nome."',telefono='".$telefono."',preferenzaprefestiva='".$preferenzaPrefestiva."',preferenzafestiva='".$preferenzaFestiva."',attivo='".$attivo."' where codicesoggetto=".$codiceSoggetto;
    //echo($query);
    $risultato=mysql_query($query)
        or die("Impossibile aggiornare i dati del lettore desiderato: ".mysql_error());
?>
<html>
    <head>
        <title>Conferma modifica</title>
    </head>
    <body>
        <div align="center"><h2>Modifica effettuata con i seguenti dati:</h2></div>
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