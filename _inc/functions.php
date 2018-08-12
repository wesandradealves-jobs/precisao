<?php 
    function to_permalink($str)
    {
        if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
        $str = strtolower( trim($str, '-') );
        return $str;
    }
    function slugify($str)
    {
      // replace non letter or digits by -
      $str = preg_replace('~[^\pL\d]+~u', '-', $str);
    
      // transliterate
      $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
    
      // remove unwanted characters
      $str = preg_replace('~[^-\w]+~', '', $str);
    
      // trim
      $str = trim($str, '-');
    
      // remove duplicate -
      $str = preg_replace('~-+~', '-', $str);
    
      // lowercase
      $str = strtolower($str);
    
      if (empty($str)) {
        return 'n-a';
      }
    
      return $str;
    }
    function removeSpecialChars($string)
    {
        $string = utf8_decode($string);

        // Código ASCII das vogais
        $ascii['a'] = array_merge(range(192, 198), range(224, 230));
        $ascii['e'] = array_merge(range(200, 203), range(232, 235));
        $ascii['i'] = array_merge(range(204, 207), range(236, 239));
        $ascii['o'] = array_merge(range(210, 214), range(242, 246), [240, 248]);
        $ascii['u'] = array_merge(range(217, 220), range(249, 252));

        // Código ASCII dos outros caracteres
        $ascii['b'] = [223];
        $ascii['c'] = [199, 231];
        $ascii['d'] = [208];
        $ascii['n'] = [241];
        $ascii['y'] = [253, 255];

        foreach ($ascii as $key=>$item) {
            $acentos = '';
            foreach ($item AS $codigo) $acentos .= chr($codigo);
            $troca[$key] = '/['.$acentos.']/i';
        }

        return preg_replace(array_values($troca), array_keys($troca), $string);
    }
?>