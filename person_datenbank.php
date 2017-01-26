<?php  
   
error_reporting(E_ALL & ~E_NOTICE);
header('Content-type: text/html; charset=UTF-8'); /* Datei ist -> UTF-8 <- Senden bei jeden Datensatz der abgerufen wird für Browser */ 
setlocale(LC_TIME, 'de_DE.utf8');   /* Locale Information setzen */
  
     //********************************************************
     //  ************** UTF - 8  ******************************
     //********************************************************


     //*****************************************************************************************//
     //                                                                                         // 
     //   -----  Person - Datenbank Ubergabe ----                                               // 
     //                                                                                         // 
     //                                                                                         // 
     //   Urheberrecht:                                                                         // 
     //   Copyright ©2017 Meiko Eichler Alle Rechte vorbehalten.                                //
     //   Alle Bilder, Texte, Grafiken, Ton-, Spiel-, Video- und sonstige                       //
     //   interaktiven Elemente unterliegen dem Urheberrecht sowie anderen Gesetzen zum         //
     //   Schutz geistigen Eigentums. Jede Veränderung, Weitergabe, Einbindung auf              //
     //   anderen Webseiten  oder sonstige Verwendung bedarf der schriftlichen                  //
     //   Genehmigung durch die primacom.                                                       //
     //                                                                                         //
     //   Technische Umsetzung:                                                                 //
     //   Meiko Eichler - Webmaster                                                             //
     //   Meiko Eichler - Metaprogrammierung                                                    //
     //   Meiko Eichler - Grafische Bearbeitungen                                               //
     //   04435 Schkeuditz                                                                      //
     //   Handy: 0163 7378481                                                                   // 
     //   E-Mail: Meiko.Eichler@Primacom.de oder Meiko@Somba.de                                 //
     //                                                                                         //
     //   Datei Erstellt am: 19.01.2017                                                         //
     //                                                                                         //
     //                                                                                         //
     //   Ordner: /noc/intern/person/                                                           //
     //   Datei Name:  person_datenbank.php                                                  //
     //                                                                                         //
     //*****************************************************************************************//
     
     
      
      @session_start();
      if(!$_SESSION["endned"] || !$_SESSION["rollalk"]){  echo "<h2>Zugriff verweigert!</h2>"; exit; }  else {} /* Schutz */
      @include("noc/klassen/alle_klassen_laden.php");    /* Klassen bereit stellen */
      @include("noc/sonstiges/schriften_sonstiges.php"); /* Schriften tabelen layout und sonstiges bereitstellen */  
      $web_browser   = $browser_weiche->webbrowser();    /* Webbroser bestimmen */
      $datenbank->db_name     = "noc_portal";
      
      
      if($person_wo == "neu-person" || $person_wo == "updaten-person")
      {
      	    $nachname    = trim($nachname); /* Leerzeichen am Anfang und ende entfernen */ 
      	    $vorname     = trim($vorname); 
      	    $firma       = trim($firma);
      	    $abteilung   = trim($abteilung);
      	    $festnetz    = trim($festnetz);
     	      $fax         = trim($fax);
     	      $handy       = trim($handy);
     	      $email       = trim($email);
     	      $personr     = trim($personr);
     	      $geburt_tag  = trim($geburt_tag);
     	      $geburt_monat = trim($geburt_monat);
     	      $geburt_jahr  = trim($geburt_jahr);
     	      $person_wo    = trim($person_wo);
     	      $einsatzort   = trim($einsatzort);
     	      $region       = trim($region);
     	   
     	      /* region prüfen ob Wert vorhanden ist wenn keiner dann deaktiveren und wert auf -1 setzen */ 
     	      if($region == "")$region = -1; else {}
     	      
     	      /* Geburtstag in Unix umwandeln */
     	      if($geburt_jahr != 0 && $geburt_monat != 0 && $geburt_tag != 0)
     	        $unix_geburtstag =  mktime(0,0,0,$geburt_monat,$geburt_tag,$geburt_jahr);
     	      else
     	        $unix_geburtstag = -1;
     	   
     	   /* ID von ausgelagerten Daten holen für Haupttabelle */
     	       
             /* Nachname:    per_n_name;
                +----------+-------------+------+-----+---------+----------------+
                | Field    | Type        | Null | Key | Default | Extra          |
                +----------+-------------+------+-----+---------+----------------+
                | nachname | varchar(50) | NO   |     | NULL    |                |
                | status   | tinyint(1)  | NO   |     | NULL    |                |
                | id       | int(11)     | NO   | PRI | NULL    | auto_increment |
                +----------+-------------+------+-----+---------+----------------+  
             */

             $spalten_nna[0]="nachname";   $inhalt_nna[0]=$nachname;
             $spalten_nna[1]="status";     $inhalt_nna[1]="0"; /* true -- Aktiv */
             $nachname_id = $db_verwaltung->amt("per_n_name","nachname='$nachname' and status='0' ",$spalten_nna,$inhalt_nna,$datenbank,"per_daten");  
      	     
      	     /* Vorname  per_v_name;
              +---------+-------------+------+-----+---------+----------------+
              | Field   | Type        | Null | Key | Default | Extra          |
              +---------+-------------+------+-----+---------+----------------+
              | vorname | varchar(50) | NO   |     | NULL    |                |
              | status  | tinyint(1)  | NO   |     | NULL    |                |
              | id      | int(11)     | NO   | PRI | NULL    | auto_increment |
              +---------+-------------+------+-----+---------+----------------+
             */
             
             $spalten_vna[0]="vorname";   $inhalt_vna[0]=$vorname;
             $spalten_vna[1]="status";    $inhalt_vna[1]="0";   /* true -- Aktiv */
             $vorname_id = $db_verwaltung->amt("per_v_name","vorname='$vorname' and status='0' ",$spalten_vna,$inhalt_vna,$datenbank,"per_daten");  
             
             /* Firma    per_firma;
             +---------------------+--------------+------+-----+---------+----------------+
             | Field               | Type         | Null | Key | Default | Extra          |
             +---------------------+--------------+------+-----+---------+----------------+
             | firma               | varchar(100) | NO   |     | NULL    |                |
             | status              | tinyint(1)   | NO   |     | NULL    |                |
             | per_daten_gruppe_id | int(11)      | NO   |     | NULL    |                |
             | id                  | int(11)      | NO   | PRI | NULL    | auto_increment |
             +---------------------+--------------+------+-----+---------+----------------+
             */
                   	     
             $spalten_firma[0]="firma";     $inhalt_firma[0]=$firma;
             $spalten_firma[1]="status";    $inhalt_firma[1]="0";   /* true -- Aktiv */
             $firma_id = $db_verwaltung->amt("per_firma","firma='$firma' and status='0' ",$spalten_firma,$inhalt_firma,$datenbank,"per_daten");  
               	  
             /* Abteilung  per_abteilung;
             +-----------+--------------+------+-----+---------+----------------+
             | Field     | Type         | Null | Key | Default | Extra          |
             +-----------+--------------+------+-----+---------+----------------+
             | abteilung | varchar(100) | NO   |     | NULL    |                |
             | status    | tinyint(1)   | NO   |     | NULL    |                |
             | id        | int(11)      | NO   | PRI | NULL    | auto_increment |
             +-----------+--------------+------+-----+---------+----------------+
             */
             
             $spalten_abteilung[0]="abteilung"; $inhalt_abteilung[0]=$abteilung;
             $spalten_abteilung[1]="status";    $inhalt_abteilung[1]="0";   /* true -- Aktiv */
             $abteilung_id = $db_verwaltung->amt("per_abteilung","abteilung='$abteilung' and status='0' ",$spalten_abteilung,$inhalt_abteilung,$datenbank,"per_daten");  
             
             /* Festnetz   per_festnetz;
             +----------+-------------+------+-----+---------+----------------+
             | Field    | Type        | Null | Key | Default | Extra          |
             +----------+-------------+------+-----+---------+----------------+
             | festnetz | varchar(30) | NO   |     | NULL    |                |
             | status   | tinyint(1)  | NO   |     | NULL    |                |
             | id       | int(11)     | NO   | PRI | NULL    | auto_increment |
             +----------+-------------+------+-----+---------+----------------+
             */
             
             $spalten_festnetz[0]="festnetz";  $inhalt_festnetz[0]=$festnetz;
             $spalten_festnetz[1]="status";    $inhalt_festnetz[1]="0";   /* true -- Aktiv */
             $festnetz_id = $db_verwaltung->amt("per_festnetz","festnetz='$festnetz' and status='0' ",$spalten_festnetz,$inhalt_festnetz,$datenbank,"per_daten");  
             
             /*  Fax  per_fax;
             +--------+-------------+------+-----+---------+----------------+
             | Field  | Type        | Null | Key | Default | Extra          |
             +--------+-------------+------+-----+---------+----------------+
             | fax    | varchar(30) | NO   |     | NULL    |                |
             | status | tinyint(1)  | NO   |     | NULL    |                |
             | id     | int(11)     | NO   | PRI | NULL  "0"  | auto_increment |
             +--------+-------------+------+-----+---------+----------------+
             */
             
             $spalten_fax[0]="fax";       $inhalt_fax[0]=$fax;
             $spalten_fax[1]="status";    $inhalt_fax[1]="0";   /* true -- Aktiv */
             $fax_id = $db_verwaltung->amt("per_fax","fax='$fax' and status='0' ",$spalten_fax,$inhalt_fax,$datenbank,"per_daten");  
            
             /* Handy  per_handy;
             +--------+-------------+------+-----+---------+----------------+
             | Field  | Type        | Null | Key | Default | Extra          |
             +--------+-------------+------+-----+---------+----------------+
             | handy  | varchar(30) | NO   |     | NULL    |                |
             | status | tinyint(1)  | NO   |     | NULL    |                |
             | id     | int(11)     | NO   | PRI | NULL    | auto_increment |
             +--------+-------------+------+-----+---------+----------------+
             */
             
             $spalten_handy[0]="handy";     $inhalt_handy[0]=$handy;
             $spalten_handy[1]="status";    $inhalt_handy[1]="0";   /* true -- Aktiv */
             $handy_id = $db_verwaltung->amt("per_handy","handy='$handy' and status='0' ",$spalten_handy,$inhalt_handy,$datenbank,"per_daten");  
            
             /* E-Mail   per_email;
             +--------+--------------+------+-----+---------+----------------+
             | Field  | Type         | Null | Key | Default | Extra          |
             +--------+--------------+------+-----+---------+----------------+
             | email  | varchar(100) | NO   |     | NULL    |                |
             | status | tinyint(1)   | NO   |     | NULL    |                |
             | id     | int(11)      | NO   | PRI | NULL    | auto_increment |
             +--------+--------------+------+-----+---------+----------------+
             */
             
             $spalten_email[0]="email";     $inhalt_email[0]=$email;
             $spalten_email[1]="status";    $inhalt_email[1]="0";   /* true -- Aktiv */
             $email_id = $db_verwaltung->amt("per_email","email='$email' and status='0' ",$spalten_email,$inhalt_email,$datenbank,"per_daten");  
            
             /* Einsatzort    per_einsatzort;
             +------------+--------------+------+-----+---------+----------------+
             | Field      | Type         | Null | Key | Default | Extra          |
             +------------+--------------+------+-----+---------+----------------+
             | einsatzort | varchar(100) | NO   |     | NULL    |                |
             | status     | tinyint(1)   | NO   |     | NULL    |                |
             | id         | int(11)      | NO   | PRI | NULL    | auto_increment |
             +------------+--------------+------+-----+---------+----------------+
             */
             
             $spalten_einsatzort[0]="einsatzort";     $inhalt_einsatzort[0]=$einsatzort;
             $spalten_einsatzort[1]="status";         $inhalt_einsatzort[1]="0";   /* true -- Aktiv */
             $einsatzort_id = $db_verwaltung->amt("per_einsatzort","einsatzort='$einsatzort' and status='0' ",$spalten_einsatzort,$inhalt_einsatzort,$datenbank,"per_daten");  
            
            
          /* Alle gesamelten Daten in Haupttabele eintragen */ 
             /* Hauptdaten:   per_daten"0"
             +-------------------+------------+------+-----+---------+----------------+
             | Field             | Type       | Null | Key | Default | Extra          |test
             +-------------------+------------+------+-----+---------+----------------+
             | per_v_name_id     | int(11)    | NO   |     | NULL    |                |
             | per_n_name_id     | int(11)    | NO   |     | NULL    |                | 
             | personalnummer    | int(11)    | NO   |     | NULL    |                |
             | region            | int(11)    | NO   |     | NULL    |                |
             | per_email_id      | int(11)    | NO   |     | NULL    |                |
             | per_fax_id        | int(11)    | NO   |     | NULL    |                 |
             | per_festnetz_id   | int(11)    | NO   |     | NULL    |                |
             | per_firma_id      | int(11)    | NO   |     | NULL    |                |
             | per_handy_id      | int(11)    | NO   |     | NULL    |                |
             | per_abteilung_id  | int(11)    | NO   |     | NULL    |                |
             | per_einsatzort_id | int(11)    | NO   |    | NULL    |                  |   
             | geburtstag_unix   | int(11)    | NO   |     | NULL    |                |
             | status            | tinyint(1) | NO   |     | NULL    |                |
             | id                | int(11)    | NO   | PRI | NULL    | auto_increment |
             +-------------------+------------+------+-----+---------+----------------+ 
             */

             $spalten_hdaten[0]="per_v_name_id";     $inhalt_hdaten[0]=$vorname_id;
             $spalten_hdaten[1]="per_n_name_id";     $inhalt_hdaten[1]=$nachname_id;
             $spalten_hdaten[2]="personalnummer";    $inhalt_hdaten[2]=$personr;
             $spalten_hdaten[3]="region";            $inhalt_hdaten[3]=$region;
             $spalten_hdaten[4]="per_email_id";      $inhalt_hdaten[4]=$email_id;
             $spalten_hdaten[5]="per_fax_id";        $inhalt_hdaten[5]=$fax_id;
             $spalten_hdaten[6]="per_festnetz_id";   $inhalt_hdaten[6]=$festnetz_id;
             $spalten_hdaten[7]="per_firma_id";      $inhalt_hdaten[7]=$firma_id;
             $spalten_hdaten[8]="per_handy_id";      $inhalt_hdaten[8]=$handy_id;
             $spalten_hdaten[9]="per_abteilung_id";  $inhalt_hdaten[9]=$abteilung_id;
             $spalten_hdaten[10]="per_einsatzort_id"; $inhalt_hdaten[10]=$einsatzort_id;
             $spalten_hdaten[11]="geburtstag_unix";   $inhalt_hdaten[11]=$unix_geburtstag;             
             $spalten_hdaten[12]="status";            $inhalt_hdaten[12]="0";   /* true -- Aktiv */
             $hdaten_id = $db_verwaltung->amt("per_daten","per_v_name_id='$vorname_id' and per_n_name_id='$nachname_id' and status='0' ",$spalten_hdaten,$inhalt_hdaten,$datenbank);
                
             if($hdaten_id != -1 )
               echo "<h1>Perfekt :-)</h1>";
             else
               echo "<h1>oh Nein  :-()</h1>";
      }
      elseif($person_wo == "person_puffer")
      {   /* Daten für Pufferung beim client aus DB holen und zu java senden Vorname und Nachname */ 
      	      
      	       $sql_was    = "select per_v_name.vorname,per_n_name.nachname,per_daten.id from per_daten,per_v_name,per_n_name where  per_v_name.id = per_daten.per_v_name_id and  per_n_name.id = per_daten.per_n_name_id and per_daten.status='0'";
         	     $db_abfr    = $datenbank->frage($sql_was);      // Frage ausführen und Ergebnis in Variable Speichern
               $zeilen     = @mysql_num_rows($db_abfr);     // Wieviel Zeilen es gibt ermitteln
               $ausgabe    = "";
               
               if($zeilen > 0)
               {   
               	    for($i=0;$i<$zeilen;$i++)
               	    {
                       $db_inh     = @mysql_fetch_array($db_abfr);
                       if($i==0)$ausgabe  =     "".$db_inh[0]."|td|".$db_inh[1]."|td|".$db_inh[2]."";
                       else     $ausgabe .= "|tr|".$db_inh[0]."|td|".$db_inh[1]."|td|".$db_inh[2]."";
                    }      
                    mysql_free_result($db_abfr);
               }
               else {}
               
               echo $ausgabe;
      }
      else {  }
?>          