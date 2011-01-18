<?php
  /*
    NOTES:
      This is a list of languages, add more as needed
  */

  $allLangList = array(
        'af'        => "Afrikaans",
        'sq'        => "Albanian",
        'ar'        => "Arabic",
        'be'        => "Belarusian",
        'bg'        => "Bulgarian",
        'ca'        => "Catalan",
        'zh-cn'     => "Chinese (Simpl)",
        'zh-tw'     => "Chinese (Trad)",
        'hr'        => "Croatian",
        'cs'        => "Czech",
        'da'        => "Danish",
        'nl'        => "Dutch",
        'en'        => "English",
        'et'        => "Estonian",
        'tl'        => "Filipino",
        'fi'        => "Finnish",
        'fr'        => "French",
        'gl'        => "Galician",
        'de'        => "German",
        'el'        => "Greek",
        'ht'        => "Haitian Creole",
        'iw'        => "Hebrew",
        'hi'        => "Hindi",
        'hu'        => "Hungarian",
        'is'        => "Icelandic",
        'id'        => "Indonesian",
        'ga'        => "Irish",
        'it'        => "Italian",
        'ja'        => "Japanese",
        'ko'        => "Korean",
        'lv'        => "Latvian",
        'lt'        => "Lithuanian",
        'mk'        => "Macedonian",
        'ms'        => "Malay",
        'mt'        => "Maltese",
        'no'        => "Norwegian",
        'fa'        => "Persian",
        'pl'        => "Polish",
        'pt'        => "Portuguese",
        'ro'        => "Romanian",
        'ru'        => "Russian",
        'sr'        => "Serbian",
        'sk'        => "Slovak",
        'sl'        => "Slovenian",
        'es'        => "Spanish",
        'sw'        => "Swahili",
        'sv'        => "Swedish",
        'th'        => "Thai",
        'tr'        => "Turkish",
        'uk'        => "Ukrainian",
        'vi'        => "Vietnamese",
        'cy'        => "Welsh",
        'yi'        => "Yiddish",
  );

    function getLangFiles(){
        $langlist = array();

        $thisfile = "{$_SERVER['DOCUMENT_ROOT']}{$_SERVER['PHP_SELF']}";
        $path = substr($thisfile,0,strrpos($thisfile,"/"));
        $dh = opendir($path);
        while($file = readdir($dh)){
            if(preg_match("/lang\..+\.php/i",$file)){
                $langlist[] = strtolower($file);
            }
        }
        return $langlist;
    }

    function getLanguageList(){
        $langlist = array();

        $thisfile = "{$_SERVER['DOCUMENT_ROOT']}{$_SERVER['PHP_SELF']}";
        $path = substr($thisfile,0,strrpos($thisfile,"/"));
        $dh = opendir($path.'/lang');
        while($file = readdir($dh)){
            if(preg_match("/lang\.(?<langkey>.+)\.php/i",$file,$matches)){
                $langlist[] = $matches['langkey'];
            }
        }
        return $langlist;
    }
?>