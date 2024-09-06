<?php
    $hostname='localhost';
	$username='root';
	$conn=mysql_connect($hostname,$username,'')
			or die("Impossibile stabilire una connessione con il server: ".mysql_error());
	$db=mysql_select_db('lettori')
			or die("Impossibile selezionare il database <i>Lettori</i>: ".mysql_error());
    $query="select codicesoggetto, cognome, nome from lettori order by cognome";
    $risultato=mysql_query($query)
        or die("Impossibile estrarre i nomi dei lettori ".mysql_error());
?>
<html>
    <head>
        <title>Selezione lettore da modificare</title>
    </head>
    <body>
        <form name="modificaLettore" action="modificaLettore.php" method="POST">
            <div align="center"><h2>Seleziona il lettore da modificare</h2>
                <select name="codiceSoggetto">
                    <?php
                        while($riga=mysql_fetch_row($risultato))
                        {
                            echo("<option value=".$riga[0].">".str_replace(' ','&nbsp;',$riga[1])." ".str_replace(' ','&nbsp;',$riga[2]));
                        }
                    ?>
                </select>
            </div>
        <br>
        <table border=0; width="100%">
            <tr>
                <td width="50%" align="right"><INPUT TYPE="SUBMIT" NAME="invio" VALUE="Avanti"></td>
                <td width="50%" align="left"><a href="index.html"><img src='Indietro.jpg' width="10%" height="10%"></a></td>
            </tr>
        </table>
        </form>
    </body>
</html>
<?php
    mysql_close($conn);
?>