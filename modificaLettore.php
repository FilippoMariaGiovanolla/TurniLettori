<?php
    $codiceSoggetto=$_POST["codiceSoggetto"];
    //echo("Codice soggetto passato: ".$codiceSoggetto."<br>");
    $hostname='localhost';
	$username='root';
	$conn=mysql_connect($hostname,$username,'')
			or die("Impossibile stabilire una connessione con il server: ".mysql_error());
	$db=mysql_select_db('lettori')
			or die("Impossibile selezionare il database <i>Lettori</i>: ".mysql_error());
?>
<html>
    <head>
        <title>Modifica dati lettore</title>
    </head>
    <body>
        <h1><div align="center">Modifica i dati errati</div></h1>
        <form name="modificaLettore" action="effettuaModifica.php" method="POST">
        <?php
            $query="select * from lettori where codicesoggetto=".$codiceSoggetto;
            $risultato=mysql_query($query)
                or die("Impossibile estrarre i dati del lettore inserito: ".mysql_error());
            while($riga=mysql_fetch_row($risultato))
            {
                $riga[1]=str_replace(" ","&nbsp;",$riga[1]); // elimino gli eventuali spazi nel cognome e li sostituisco con &nbsp;
                $riga[2]=str_replace(" ","&nbsp;",$riga[2]); // elimino gli eventuali spazi nel nome e li sostituisco con &nbsp;
                $riga[3]=str_replace(" ","&nbsp;",$riga[3]); // elimino gli eventuali spazi nel telefono e li sostituisco con &nbsp;
                echo('
                    <table border="0" width="100%">
                        <tr>
                            <td width="20%"><font size="5">Cognome</font></td>
                            <td width="80%"><font size="5"><input type="text" name="cognome" size="30" value='.$riga[1].'></font></td>
                        </tr>
                        <tr>
                            <td width="20%"><font size="5">Nome</font></td>
                            <td width="80%"><font size="5"><input type="text" name="nome" size="30" value='.$riga[2].'></font></td>
                        </tr>
                        <tr>
                            <td width="20%"><font size="5">Telefono</font></td>
                            <td width="80%"><font size="5"><input type="text" name="telefono" size="30" value='.$riga[3].'></font></td>
                        </tr>
                        <tr>
                            <td width="20%"><font size="5">Preferenza prefestiva</font></td>
                            <td width="80%">');
                                if(strcmp($riga[4],'s')==0)
                                {
                                    echo("<select name='preferenzaPrefestiva'>
                                            <option value='s' selected>S&igrave;</option>
                                            <option value='n'>No</option>
                                           </select>");
                                }
                                else
                                {
                                    echo("<select name='preferenzaPrefestiva'>
                                            <option value='s'>S&igrave;</option>
                                            <option value='n' selected>No</option>
                                           </select>");
                                }
                            echo("</td>
                        </tr>
                        <tr>
                            <td width='20%'><font size='5'>Preferenza festiva</font></td>
                            <td width='80%'>");
                                if(strcmp($riga[5],'s')==0)
                                {
                                    echo("<select name='preferenzaFestiva'>
                                            <option value='s' selected>S&igrave;</option>
                                            <option value='n'>No</option>
                                           </select>");
                                }
                                else
                                {
                                    echo("<select name='preferenzaFestiva'>
                                            <option value='s'>S&igrave;</option>
                                            <option value='n' selected>No</option>
                                           </select>");
                                }                                
                            echo("</td>
                        </tr>
                        <tr>
                            <td width='20%'><font size='5'>Lettore in attivit&agrave;</font></td>
                            <td width='80%'>");
                                if(strcmp($riga[7],'s')==0)
                                {
                                    echo("<select name='attivo'>
                                            <option value='s' selected>S&igrave;</option>
                                            <option value='n'>No</option>
                                           </select>");
                                }
                                else
                                {
                                    echo("<select name='attivo'>
                                            <option value='s'>S&igrave;</option>
                                            <option value='n' selected>No</option>
                                           </select>");
                                }  
                                echo("</td>
                        </tr>
                    </table>
                ");
            }
            mysql_close($conn);
        ?>
        <br>
        <input type="hidden" name="codiceSoggetto" value="<?php echo($codiceSoggetto);?>">
        <div align="center"><input type="submit" name="invio" value="Salva modifiche"></div>
        </form>
    </body>
</html>