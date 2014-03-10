<?php

/*
 @nom: constant
 @auteur: Idleman (idleman@idleman.fr)
 @description:  Classe de stockage des fonctions utiles (toutes disponibles en static)
 */

class Functions
{
    private $id;
    public $debug=0;

    /**
     * Securise la variable utilisateur entrée en parametre
     * @author Valentin
     * @param<String> variable a sécuriser
     * @param<Integer> niveau de securisation
     * @return<String> variable securisée
     */

    public static function secure($var,$level = 1){
        $var = htmlspecialchars($var, ENT_QUOTES, "UTF-8");
        if($level<1)$var = mysql_real_escape_string($var);
        if($level<2)$var = addslashes($var);
        return $var;
    }


    /**
     * Return l'environnement/serveur sur lequel on se situe, permet de changer les
     * connexions bdd en fonction de la dev, la préprod ou la prod
     */
    public static function whereImI(){

        $maps = array (
        'LOCAL'=>array('localhost','127.0.0.1','0.0.0.1','::0.0.0.0'),
        'LAN'=>array('192.168.10.','valentin'),
        'PWAN'=>array('test.sys1.fr'),
        'WAN'=>array('www.sys1.fr'),
        );


        $return = 'UNKNOWN';
        foreach($maps as $map=>$values){

            foreach($values as $ip){
                $pos = strpos(strtolower($_SERVER['HTTP_HOST']),$ip);
                if ($pos!==false){
                    $return = $map;
                }
            }
        }
        return $return;
    }

    public static function isLocal($perimeter='LOCAL'){
        $return = false;

        $localTab = array('localhost','127.0.0.1','0.0.0.1','::0.0.0.0');
        $lanTab = array('192.168.10.','valentin');

        switch($perimeter){
            case 'LOCAL':
                foreach($localTab as $ip){
                    $pos = strpos(strtolower($_SERVER['HTTP_HOST']),$ip);
                    if ($pos!==false){
                        $return = true;
                    }
                }
                break;
            case 'LAN':
                foreach($lanTab as $ip){
                    $pos = strpos(strtolower($_SERVER['HTTP_HOST']),$ip);
                    if ($pos!==false){
                        $return = true;
                    }
                }
                break;
            case 'ALL':
                foreach($localTab as $ip){
                    $pos = strpos(strtolower($_SERVER['HTTP_HOST']),$ip);
                    if ($pos!==false){
                        $return = true;
                    }
                }
                foreach($lanTab as $ip){
                    $pos = strpos(strtolower($_SERVER['HTTP_HOST']),$ip);
                    if ($pos!==false){
                        $return = true;
                    }
                }
                break;
        }

        return $return;
    }


    /**
     * Convertis la chaine passée en timestamp quel que soit sont format
     * (prend en charge les formats type dd-mm-yyy , dd/mm/yyy, yyyy/mm/ddd...)
     */
    public static function toTime($string){
        $string = str_replace('/','-',$string);
        $string = str_replace('\\','-',$string);

        $string = str_replace('Janvier','Jan',$string);
        $string = str_replace('Fevrier','Feb',$string);
        $string = str_replace('Mars','Mar',$string);
        $string = str_replace('Avril','Apr',$string);
        $string = str_replace('Mai','May',$string);
        $string = str_replace('Juin','Jun',$string);
        $string = str_replace('Juillet','Jul',$string);
        $string = str_replace('Aout','Aug',$string);
        $string = str_replace('Septembre','Sept',$string);
        $string = str_replace('Octobre','Oct',$string);
        $string = str_replace('Novembre','Nov',$string);
        $string = str_replace('Decembre','Dec',$string);
        return strtotime($string);
    }

    /**
     * Recupere l'ip de l'internaute courant
     * @author Valentin
     * @return<String> ip de l'utilisateur
     */

    public static function getIP(){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
            elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
                $ip = $_SERVER['HTTP_CLIENT_IP'];}
                else{ $ip = $_SERVER['REMOTE_ADDR'];}
                return $ip;
    }

    /**
     * Retourne une version tronquée au bout de $limit caracteres de la chaine fournie
     * @author Valentin
     * @param<String> message a tronquer
     * @param<Integer> limite de caracteres
     * @return<String> chaine tronquée
     */
    public static function truncate($msg,$limit){
        if(mb_strlen($msg)>$limit){
            $fin='…' ;
            $nb=$limit-mb_strlen($fin) ;
        }else{
            $nb=mb_strlen($msg);
            $fin='';
        }
        return mb_substr($msg, 0, $nb).$fin;
    }


    function getExtension($fileName){
        $dot = explode('.',$fileName);
        return $dot[sizeof($dot)-1];
    }

    /**
     * Definis si la chaine fournie est existante dans la reference fournie ou non
     * @param unknown_type $string
     * @param unknown_type $reference
     * @return false si aucune occurence du string, true dans le cas contraire
     */
    public static function contain($string,$reference){
        $return = true;
        $pos = strpos($reference,$string);
        if ($pos === false) {
            $return = false;
        }
        return strtolower($return);
    }

    /**
     * Définis si la chaine passée en parametre est une url ou non
     */
    public static function isUrl($url){
        $return =false;
        if (preg_match('/^(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?/i', $url)) {
            $return =true;
        }
        return $return;
    }

    /**
     * Définis si la chaine passée en parametre est une couleur héxadécimale ou non
     */
    public static function isColor($color){
        $return =false;
        if (preg_match('/^#(?:(?:[a-fd]{3}){1,2})$/i', $color)) {
            $return =true;
        }
        return $return;
    }

    /**
     * Définis si la chaine passée en parametre est un mail ou non
     */
    public static function isMail($mail){
        $return =false;
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $return =true;
        }
        return $return;
    }

    /**
     * Définis si la chaine passée en parametre est une IP ou non
     */
    public static function isIp($ip){
        $return =false;
        if (preg_match('^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$',$ip)) {
            $return =true;
        }
        return $return;
    }

    public static function sourceName($string){
        $name = strtolower($string);
        $name = str_replace(' ','-',$name);
        $name = str_replace('&#039;','-',$name);
        $name = str_replace('\'','-',$name);
        $name = str_replace(',','-',$name);
        $name = str_replace(':','-',$name);
        $name = str_replace('&agrave;','a',$name);
        $name = trim($name);
        $name = html_entity_decode($name,null,'UTF-8');
        return $name;
    }

    public static function makeCookie($name, $value, $expire='') {
        if($expire == '') {
            setcookie($name, $value, mktime(0,0,0, date("d"),
            date("m"), (date("Y")+1)),'/');
        }else {
            setcookie($name, '', mktime(0,0,0, date("d"),
            date("m"), (date("Y")-1)),'/');
        }
    }

    public static function destroyCookie($name){
        Fonction::makeCookie($name,'',time()-3600);
        unset($_COOKIE[$name]);
    }

    public static function wordwrap($str, $width = 75, $break = "\n", $cut = false)
    {
        $str = html_entity_decode($str);
        $str =  htmlentities (wordwrap($str,$width,$break,$cut));
        $str = str_replace('&lt;br/&gt;','<br/>',$str);
        $str = str_replace('&amp;','&',$str);
        return $str;
    }

    public static function createFile($filePath,$content){
        $fichier = fopen($filePath,"w+");
        $fwriteResult = fwrite($fichier,$content);
        fclose($fichier);
    }



    public static function convertFileSize($bytes)
    {
         if($bytes<1024){
             return round(($bytes / 1024), 2).' o';
         }elseif(1024<$bytes && $bytes<1048576){
             return round(($bytes / 1024), 2).' ko';
         }elseif(1048576<$bytes && $bytes<1073741824){
             return round(($bytes / 1024)/1024, 2).' Mo';
         }elseif(1073741824<$bytes){
             return round(($bytes / 1024)/1024/1024, 2).' Go';
         }
    }


    public static function hexaValue($str){
        $code = dechex(crc32($str));
          $code = substr($code, 0, 6);
          return $code;
    }

    public static function scanRecursiveDir($dir){
        $files = scandir($dir);
        $allFiles = array();
        foreach($files as $file){
            if($file!='.' && $file!='..'){
                if(is_dir($dir.$file)){
                    $allFiles = array_merge($allFiles,Fonction::scanRecursiveDir($dir.$file));
                }else{
                    $allFiles[]=str_replace('//','/',$dir.'/'.$file);
                }
            }
        }
        return $allFiles;
    }

    /** Permet la sortie directe de texte à l'écran, sans tampon.
        Source : http://php.net/manual/fr/function.flush.php
    */
    public static function triggerDirectOutput() {
        // La ligne de commande n'en a pas besoin.
        if ('cli'==php_sapi_name()) return;
        if (function_exists('apache_setenv')) {
            /* Selon l'hébergeur la fonction peut être désactivée. Alors Php
               arrête le programme avec l'erreur :
               "PHP Fatal error:  Call to undefined function apache_setenv()".
            */
            @apache_setenv('no-gzip', 1);
        }
        @ini_set('zlib.output_compression', 0);
        @ini_set('implicit_flush', 1);
        for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
        ob_implicit_flush(1);
    }

    public static function relativePath($from, $to, $ps = '/') {
        $arFrom = explode($ps, rtrim($from, $ps));
        $arTo = explode($ps, rtrim($to, $ps));
        while(count($arFrom) && count($arTo) && ($arFrom[0] == $arTo[0])) {
            array_shift($arFrom);
            array_shift($arTo);
        }
        return str_pad("", count($arFrom) * 3, '..'.$ps).implode($ps, $arTo);
    }


    // Nettoyage de l'url avant la mise en base
    public static function clean_url( $url ) {
        $url = str_replace('&amp;', '&', $url);
        return $url;
    }



    /**
    * Méthode de test de connexion.
    * @return true si ok
    * @param server
    * @param login
    * @param pass
    * @param db facultatif, si précisé alors tente de la séléctionner
    */
    public static function testDb($server, $login, $pass, $db=null) {
        /* Méthode hors des classes dédiées aux BDD afin de supporter le moins
           de dépendances possibles. En particulier, pas besoin que le fichier
           de configuration existe. */
        $link = mysql_connect($server, $login, $pass);
        if (false===$link) return false;
        if (!is_null($db) && false===mysql_select_db($db, $link)) return false;
        mysql_close($link);
        return true;
    }

    /**
    * @return les langues acceptées par le navigateur
    */
    public static function getBrowserLanguages() {
        /* http://www.w3.org/International/questions/qa-lang-priorities.en.php
         * ex: da, en-gb;q=0.8,en;q=0.7 --> array('da','en');
        */
        $languages = array();
        $chunks = preg_split('/,\s*/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach($chunks as $chunk) $languages []= substr($chunk, 0, 2);
        return array_unique($languages);
    }
    
	
	/* Retourner la premiere image superieure à une certaine taille d'un billet 
	 * Dans la version 2 il faudra ajouter un systeme de cache et aussi savoir parser aussi les .png sans les tlchs 
	 * Dans la version 1 on s'occupe uniquement des jpg 
	 * 
	 * @param string $text String dans laquelle chercher les images.
	 * @param integer $taille Taille minimale de l'image (pour exclure comme cela tout ce qui picto FB tweet...
	 * */
	public static function extractIMG($text, $taille = 200){
		$valretour = "";
		$doc = new DOMDocument();
		$doc->loadHTML($text);
		$list = $doc->getElementsByTagName('img');
		foreach ($list as $node) {
			if ($node->hasAttribute('src')) {
				$img_loc = $node->getAttribute('src');
				$filename = basename($img_loc);
				$extension = explode(".",$filename);
				// Si c'est un jpg on traite sinon suivant
				if (strtoupper(end($extension)) == "JPG"){ 
					$blah = getjpegsize($img_loc);
					// Si superieur au mini requis on sort c'est ok
					if ($blah[0] > $taille || $blah[1] > $taille){
						//echo "<br />src " . $src;
						//echo "<br />liste des images " . $filename;
						//$blah = getimagesize($src);
						//echo "<br />type= " . $type = $blah['mime'];
						//echo "<br />X= " . $blah[0]."x".$blah[1];
						//$node->setAttribute('src', 'http://static.images.monsite.com/images/' . $filename);
						$valretour = "<img src=\"".$img_loc."\"  class=\"align-left\" />";
						break;
					}
				}
			}
		}
		return $valretour;
	}

	/* Couper le texte d'un billet comme il faut en ignorant les balises HTML
	 * qui peuvent etre genante a img br (paragraphes vides) 
	 * puis renvoyer ce texte expurgé des balises img 
	 * 
	 * @param string $text String dans laquelle opérer.
	 * 
	 * */
	public static function txtCHAP($text){
		$text = truncateHtml($text, $length = 200, $ending = '...', $exact = false, $considerHtml = true);
		$doc = new DOMDocument();
		$doc->loadHTML($text);
		
		// ce qui suit fonctionne pas pour retirer tous les liens
		// surement un probleme d'index dans l'itérations
		/*
		$nodes=$doc->getElementsByTagName('img');
		foreach($nodes as $node){
			// suprimer le noeud (formule tordu, mais dom)
			$node->parentNode->removeChild($node);
		}
		*/
		
		// Voici ce qui fonctionne
		// On commence par les img
		$domNodeList = $doc->getElementsByTagname('img');
		$domElemsToRemove = array();
		foreach ( $domNodeList as $domElement ) {
			// ...do stuff with $domElement...
			$domElemsToRemove[] = $domElement;
		}
		
		// les url
		$domNodeList = $doc->getElementsByTagname('a');
		foreach ( $domNodeList as $domElement ) {
			// ...do stuff with $domElement...
			$domElemsToRemove[] = $domElement;
		}
		
		// les iframes (cas ou un billet contient uniquement une video youtube par exemple
		$domNodeList = $doc->getElementsByTagname('iframe');
		foreach ( $domNodeList as $domElement ) {
			// ...do stuff with $domElement...
			$domElemsToRemove[] = $domElement;
		}
		
		// les br
		$domNodeList = $doc->getElementsByTagname('br');
		foreach ( $domNodeList as $domElement ) {
			// ...do stuff with $domElement...
			$domElemsToRemove[] = $domElement;
		}
		
		// Suprimer les paragraphes vides
		$domNodeList = $doc->getElementsByTagname('p');
		foreach ( $domNodeList as $domElement ) {
			// si y a rien entre le paragraphe on vire
			if (strlen(trim($domElement->nodeValue)) == 0){
				$domElemsToRemove[] = $domElement;
			}
		}
		
		// Maintenant on fait réellment le job
		foreach( $domElemsToRemove as $domElement ){
			$domElement->parentNode->removeChild($domElement);
		} 
		$body = $doc->getElementsByTagName('body')->item(0);
		// On retourne que ce qu'il y a entre body car sinon c'est structure avec la descri du dom
		return innerHTML($body);
		//return htmlspecialchars(innerHTML($body));
		//return $doc->saveHTML();
	}
	
}

	/**
     * Permet à l'issue de l'utilisation de dom de retourner la chaine de caractere sinon 
     * c'est une vraie structure complète qui est retournée
     * 
     * */
	function innerHTML($el) {
		$doc = new DOMDocument();
		$doc->appendChild($doc->importNode($el, TRUE));
		$html = trim($doc->saveHTML());
		$tag = $el->nodeName;
		return preg_replace('@^<' . $tag . '[^>]*>|</' . $tag . '>$@', '', $html);
	}


    /**
     * Fonction trouvée sur http://alanwhipple.com/2011/05/25/php-truncate-string-preserving-html-tags-words/
	* truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
	*
	* @param string $text String to truncate.
	* @param integer $length Length of returned string, including ellipsis.
	* @param string $ending Ending to be appended to the trimmed string.
	* @param boolean $exact If false, $text will not be cut mid-word
	* @param boolean $considerHtml If true, HTML tags would be handled correctly
	*
	* @return string Trimmed string.
	*/
	function truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
		if ($considerHtml) {
			// if the plain text is shorter than the maximum length, return the whole text
			if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			// splits all html-tags to scanable lines
			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';
			foreach ($lines as $line_matchings) {
				// if there is any html-tag in this line, handle it and add it (uncounted) to the output
				if (!empty($line_matchings[1])) {
					// if it's an "empty element" with or without xhtml-conform closing slash
					if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
						// do nothing
					// if tag is a closing tag
					} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
						// delete tag from $open_tags list
						$pos = array_search($tag_matchings[1], $open_tags);
						if ($pos !== false) {
						unset($open_tags[$pos]);
						}
					// if tag is an opening tag
					} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
						// add tag to the beginning of $open_tags list
						array_unshift($open_tags, strtolower($tag_matchings[1]));
					}
					// add html-tag to $truncate'd text
					$truncate .= $line_matchings[1];
				}
				// calculate the length of the plain text part of the line; handle entities as one character
				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				if ($total_length+$content_length> $length) {
					// the number of characters which are left
					$left = $length - $total_length;
					$entities_length = 0;
					// search for html entities
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
						// calculate the real length of all entities in the legal range
						foreach ($entities[0] as $entity) {
							if ($entity[1]+1-$entities_length <= $left) {
								$left--;
								$entities_length += strlen($entity[0]);
							} else {
								// no more characters left
								break;
							}
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
					// maximum lenght is reached, so get off the loop
					break;
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}
				// if the maximum length is reached, get off the loop
				if($total_length>= $length) {
					break;
				}
			}
		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}
		// if the words shouldn't be cut in the middle...
		if (!$exact) {
			// ...search the last occurance of a space...
			$spacepos = strrpos($truncate, ' ');
			if (isset($spacepos)) {
				// ...and cut the text in this position
				$truncate = substr($truncate, 0, $spacepos);
			}
		}
		// add the defined ending to the text
		$truncate .= $ending;
		if($considerHtml) {
			// close all unclosed html-tags
			foreach ($open_tags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}

		
		
	/**
     * Retrieve JPEG width and height without downloading/reading entire image.
     */
	function getjpegsize($img_loc) {
		$handle = fopen($img_loc, "rb") or die("Invalid file stream.");
		$new_block = NULL;
		if(!feof($handle)) {
			$new_block = fread($handle, 32);
			$i = 0;
			if($new_block[$i]=="\xFF" && $new_block[$i+1]=="\xD8" && $new_block[$i+2]=="\xFF" && $new_block[$i+3]=="\xE0") {
				$i += 4;
				if($new_block[$i+2]=="\x4A" && $new_block[$i+3]=="\x46" && $new_block[$i+4]=="\x49" && $new_block[$i+5]=="\x46" && $new_block[$i+6]=="\x00") {
					// Read block size and skip ahead to begin cycling through blocks in search of SOF marker
					$block_size = unpack("H*", $new_block[$i] . $new_block[$i+1]);
					$block_size = hexdec($block_size[1]);
					while(!feof($handle)) {
						$i += $block_size;
						$new_block .= fread($handle, $block_size);
						if($new_block[$i]=="\xFF") {
							// New block detected, check for SOF marker
							$sof_marker = array("\xC0", "\xC1", "\xC2", "\xC3", "\xC5", "\xC6", "\xC7", "\xC8", "\xC9", "\xCA", "\xCB", "\xCD", "\xCE", "\xCF");
							if(in_array($new_block[$i+1], $sof_marker)) {
								// SOF marker detected. Width and height information is contained in bytes 4-7 after this byte.
								$size_data = $new_block[$i+2] . $new_block[$i+3] . $new_block[$i+4] . $new_block[$i+5] . $new_block[$i+6] . $new_block[$i+7] . $new_block[$i+8];
								$unpacked = unpack("H*", $size_data);
								$unpacked = $unpacked[1];
								$height = hexdec($unpacked[6] . $unpacked[7] . $unpacked[8] . $unpacked[9]);
								$width = hexdec($unpacked[10] . $unpacked[11] . $unpacked[12] . $unpacked[13]);
								return array($width, $height);
							} else {
								// Skip block marker and read block size
								$i += 2;
								$block_size = unpack("H*", $new_block[$i] . $new_block[$i+1]);
								$block_size = hexdec($block_size[1]);
							}
						} else {
							return FALSE;
						}
					}
				}
			}
		}
		return FALSE;
	}
?>
