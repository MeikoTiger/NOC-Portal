<?php  

error_reporting(E_ALL & ~E_NOTICE);
@header('Content-type: text/html; charset=UTF-8'); /* Datei ist -> UTF-8 <- Senden bei jeden Datensatz der abgerufen wird für Browser */ 
setlocale(LC_TIME, 'de_DE.utf8');   /* Locale Information setzen */
 
  
     //********************************************************
     //  ************** UTF - 8  ******************************
     //********************************************************


     //********************************************************
     //            Option  Klasse                             *
     //           -- <option> Felder zb. Zeit  --             *
     //                                                       *
     // Cod by Meiko Eichler                                  *
     // Copyright by Meiko Eichler                            *
     //                                                       *
     // Adresse:  Bauernring 2                                *
     //           04435 Schkeuditz                            *
     //                                                       *
     // E-Mail:   Somba@Somba.de oder Meiko@Somba.de          *
     // Internet: www.somba.de                                *
     //                                                       *
     // Telefon:  034204 451457                               *
     // Handy:    0171 9255832                                *
     //                                                       *
     // Datei Erstellt am: 09.11.2016                         *
     //                                                       *
     // Ordner: noc/klassen/                                   *
     // Datei:  unix_klasse.php                            *
     //                                                       *
     //******************************************************** 
   
   
   
   
class Unix 
{
	  var $c_stunde;
	  var $c_minute;
	  var $c_secunde;
	  var $c_tag;
	  var $c_monat;
	  var $c_jahr;
	  
	  function Unix() // Vordefinieren  ( Konstruktor )
    {
        $this->c_stunde  = date("H");
	      $this->c_minute  = date("i");
	      $this->c_secunde = date("s");
	      $this->c_tag     = date("d");
	      $this->c_monat   = date("m");
	      $this->c_jahr    = date("Y");
    }

	  
	  function option_bauen($was,$alt,$id)
	  {   
	  	   $id_name = $was."_".$id;
	  	   
	  	   if($was == "stunde")
	  	   {   $zahler[0] = 0;
	  	   	   $zahler[1] = 23; }
	  	   elseif($was == "minute" || $was == "secunde")
	  	   {   $zahler[0] = 0;
	  	   	   $zahler[1] = 60; }
	  	   elseif($was == "tag")
	  	   {   $zahler[0] = 1;
	  	   	   $zahler[1] = 31;  }
	  	   elseif($was == "monat")
	  	   {   $zahler[0] = 1;
	  	   	   $zahler[1] = 12;  }
	  	   elseif($was == "jahr")
	  	   {   $zahler[0] = 1940;
	  	   	   $zahler[1] = 2100;  }
	  	   else
	  	   {}
	  	 
	  	   $option = "<select id=\"$id_name\" name=\"$id_name\" size=\"1\" style=\"border-radius:3px;\" > \n";
	       $select = false; $temp_option = "";
	       for($i=$zahler[0];$i<=$zahler[1];$i++)
	       {
	       	   if($i < 10)$i_a = "0".$i; else $i_a = $i;
	       	   if($alt && $alt == $i ) /* Alter Eintrag wurde gefunden dort select hinsetzten */ 
	       	   {  $select = true;
	       	   	  $temp_option .= "<option selected value=\"$i\">$i_a</option> \n";  }
	       	   else
	       	      $temp_option .= "<option value=\"$i\">$i_a</option> \n";
	       	    
	       }
	       if($select == false) /* es wurde keine Stunde gefunden diesen Wert auf Leer setzten */
	         $option .= "<option selected value=\"\">--</option> $temp_option </select>";
         else	         
	         $option .= "$temp_option </select>";
	         
	       return $option;
	  }
	  
	  
	  function option($id_name,$stunde,$minute,$secunde,$tag,$monat,$jahr,$op = null)
	  {
	  	   if($op != "aus")
	  	   {  if($secunde == "")$secunde = $this->c_secunde; else {}
	  	      if($tag     == "")$tag     = $this->c_tag;     else {}
	  	      if($monat   == "")$monat   = $this->c_monat;   else {}
	  	      if($jahr    == "")$jahr    = $this->c_jahr;    else {}
	  	   }
	  	   else{}
	  	   
	  	   $ausgabe[stunde]  = $this->option_bauen("stunde"  ,$stunde  ,$id_name);  /* Stunde */
	  	   $ausgabe[minute]  = $this->option_bauen("minute"  ,$minute  ,$id_name);  /* minute */
	  	   $ausgabe[secunde] = $this->option_bauen("secunde" ,$secunde ,$id_name);  /* secunde */
	  	   $ausgabe[tag]     = $this->option_bauen("tag"     ,$tag     ,$id_name);  /* tag */
	  	   $ausgabe[monat]   = $this->option_bauen("monat"   ,$monat   ,$id_name);  /* monat */
	  	   $ausgabe[jahr]    = $this->option_bauen("jahr"    ,$jahr    ,$id_name);  /* jahr */
	  	  
	         
	       return $ausgabe;
	  }

}

$unix = new Unix();


?>