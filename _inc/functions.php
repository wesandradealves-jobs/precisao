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
    function strip_tags_content($text, $tags = '', $invert = FALSE) { 

    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags); 
    $tags = array_unique($tags[1]); 
        
    if(is_array($tags) AND count($tags) > 0) { 
        if($invert == FALSE) { 
        return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text); 
        } 
        else { 
        return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text); 
        } 
    } 
    elseif($invert == FALSE) { 
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text); 
    } 
    return $text; 
    } 
?>