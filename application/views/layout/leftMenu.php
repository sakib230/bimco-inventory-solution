<div class="col-md-3 col-sm-3 col-xs-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo base_url() ?>" class="site_title"><i class="fa fa-book"></i> <span><?php echo PROJECT_NAME ?></span></a>
        </div>
        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?php echo base_url() ?>assets/images/user/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $this->session->userdata('fullName') ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->

        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <?php
                $userPermittedPageCodeArr = explode(',', $this->session->userdata('permittedPageCode'));
                $menuArr = getLeftMenu();
                ?>

                <ul class="nav side-menu">
                    <?php
                    foreach ($menuArr as $menu => $eachMenu) {
                        $levelOneIsactive = '';
                        $childMenuIsBlock = '';
                        $levelTwoStr = '';
                        $childMenuBlockFlag = 0;
                        foreach ($eachMenu['levelTwo'] as $levelTwo => $levelTwoElement) {
                            $currentPage = '';

                            if (in_array($levelTwoElement['levelTwoCode'], $userPermittedPageCodeArr)) {
                                if ($currentPageCode == $levelTwoElement['levelTwoCode']) {
                                    $currentPage = 'current-page';
                                    $childMenuBlockFlag = 1;
                                }
                                $levelTwoStr .= '<li class="' . $currentPage . '"><a href="' . base_url() . $levelTwoElement['levelTwoUrl'] . '">' . $levelTwoElement['levelTwoHeading'] . '</a></li>';
                            }
                        }

                        if ($levelTwoStr) {
                            if ($childMenuBlockFlag) {
                                $levelOneIsactive = 'active';
                                $childMenuIsBlock = 'style="display:block"';
                            }
                            echo '<li class="' . $levelOneIsactive . '"><a><i class="' . $eachMenu['levelOneIcon'] . '"></i> ' . $eachMenu['levelOneHeading'] . ' <span class="fa fa-chevron-down"></span></a>';
                            echo '<ul class="nav child_menu" ' . $childMenuIsBlock . ' >';
                            echo $levelTwoStr;
                            echo '</ul>';
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>