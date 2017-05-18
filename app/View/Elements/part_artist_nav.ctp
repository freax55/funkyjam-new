<div id="namenav">
    <div class="col-lg-12">
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


<div class="col-lg-9">
    <div class="row">
        <div class="col-xs-12">
            <div class="artistnav">
            <?php
            $list_contents =$this->common->getContentList();
            foreach($list_contents as $path => $label) {
                $btn_color = ($path == $action)? 'btn-on':'btn-artist';
                $path = ($path == 'index')? '' : $path ;
                print '<div class="btn ' . $btn_color . ' col-xs-6 col-sm-6 col-md-3 col-lg-3"><a href="/artist/' . $current . '/' . $path . '">' . $label . '</a></div>';
            }
            ?>
            </div>
        </div>
    </div>