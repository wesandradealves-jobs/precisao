<?php if($redes_sociais) : ?>
    <ul class="social-networks">
    <?php 
        $redes_sociais->execute();
        $redes_sociais->bind_result($RSSID, $rsnome, $rsurl);
        while($redes_sociais->fetch()) {
            $RSSID = $RSSID;
            $rsnome = $rsnome;
            $rsurl = $rsurl;
            echo '<li><a href="'.$rsurl.'" title="'.$rsnome.'" class="'.((to_permalink($rsnome) == 'rss') ? 'fas' : 'fab').' fa-'.((to_permalink($rsnome) == 'facebook') ? to_permalink($rsnome).'-f' : to_permalink($rsnome)).'"></a></li>';
        }
    ?>              
    </ul>
<?php endif; ?>