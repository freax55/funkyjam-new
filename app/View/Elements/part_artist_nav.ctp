<div id="namenav">
    <div class="container-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">   
                <p class="news-name"><?= $ary_names[$current]['en'] ?></p>
            </div>
            <div class="snsbar">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <a href="https://www.facebook.com/toshinobukubota" target="_blank">
                    <i class="fa fa-facebook-official snsicon" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/kubota_4_real" target="_blank">
                    <i class="fa fa-twitter-square snsicon" aria-hidden="true"></i></a>
                    <a href="https://www.youtube.com/user/toshinobukubotaSMEJ" target="_blank">
                    <i class="fa fa-youtube-square snsicon" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="otherartist">
    <div class="container-txt">
        <div class="row resp artistnav">
        <?php
        foreach($ary_params as $v) {
            $color = ($v == $current)?'btn-on5':'btn-on4';
            print '<div class="btn ' . $color . ' col-xs-6 col-sm-3 col-md-3 col-lg-3">';
            print '<a href="/artist/' . $v . '">';
            print $ary_names[$v]['en'];
            print '</a></div>';
        }
        ?>
        </div>
    </div>
</div>

<div id="artistnav">
    <div class="container-txt">
        <div class="row resp artistnav">
            <?php
            $list_contents =$this->common->getContentList();
            foreach($list_contents as $path => $label) {
                $btn_color = ($path == $action)? 'btn-on':'btn-artist';
                $path = ($path == 'index')? '' : $path ;
                print '<div class="btn ' . $btn_color . ' col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/' . $current . '/' . $path . '">' . $label . '</a></div>';
            }
            ?>
            <div class="btn btn-baribari col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/kubota/fanclub">Bari Bari Crew</a>
            </div>
        </div>
    </div>
</div>