<header id="header">

        <div id="skip-to-article"><a href="#content">본문 바로가기</a></div>

        <a href="<?php echo $this->layout->site_href(); ?>" class="logo">
            <h1><img src="<?php echo $this->layout->logo_src(); ?>" alt="<?php echo $this->layout->logo_title(); ?>"></h1>
        </a>
        


        <ul id="tnb">
            <?php if (!IS_MEMBER) { ?>
            <li><a href="<?php echo $this->layout->signin_href(); ?>">회원로그인</a></li>
            <li><a href="<?php echo $this->layout->site_dir(); ?>/sign/signup">회원가입</a></li>

            <?php } else { ?>
            <li><a href="<?php echo $this->layout->site_dir(); ?>/sign/signout">로그아웃</a></li>            
            <?php if ($MB['level'] == 1) { ?>
            <li><a href="<?php echo $this->layout->site_dir(); ?>/manage/">Manage</a></li>
            <?php } ?>
            
            <br>
 
            <li><a href="<?php echo $this->layout->site_dir(); ?>/message">Message <em><?php echo $this->layout->message_new_count(); ?></em></a></li>
            <li><a href="<?php echo $this->layout->site_dir(); ?>/alarm">Alarm <em><?php echo $this->layout->alarm_new_count(); ?></em></a></li>
                        

            <?php } ?>
        </ul>


    <nav>
        <ul id="gnb">
            <?php foreach ($SITEMAP as $gnb) { ?>
            <li>
                <a href="<?php echo $gnb['href']; ?>" data-category-key="<?php echo $gnb['idx']; ?>"><?php echo $gnb['title']; ?></a>
                <?php if (count($gnb['2d']) > 0) { ?>
                <div class="sound_only_ele">하위 메뉴</div>
                <ul>
                    <?php foreach ($gnb['2d'] as $gnb2) { ?>
                    <li>
                        <a href="<?php echo $gnb2['href']; ?>" data-category-key="<?php echo $gnb2['idx']; ?>"><?php echo $gnb2['title']; ?></a>
                        <?php if (count($gnb2['3d']) > 0) { ?>
                        <ul>
                            <?php foreach ($gnb2['3d'] as $gnb3) { ?>
                            <li><a href="<?php echo $gnb3['href']; ?>" data-category-key="<?php echo $gnb3['idx']; ?>"><?php echo $gnb3['title']; ?></a></li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </li>
            <?php } ?>
        </ul>
    </nav>


        
    <div href="#" id="slide-btn">
        <button><span></span></button>
        전체 메뉴 열기
    </div>

</header>

<!-- for mobile -->
<div id="slide-menu">
    <div class="inner">
        <ul id="mo-tnb">
            <?php if (!IS_MEMBER) { ?>
            <li><a href="<?php echo $this->layout->signin_href(); ?>">회원로그인</a></li>
            <li><a href="<?php echo $this->layout->site_dir(); ?>/sign/signup">회원가입</a></li>
            <?php } else { ?>
            <li><a href="<?php echo $this->layout->site_dir(); ?>/message">Message <em><?php echo $this->layout->message_new_count(); ?></em></a></li>
            <li><a href="<?php echo $this->layout->site_dir(); ?>/alarm">Alarm <em><?php echo $this->layout->alarm_new_count(); ?></em></a></li>
            <li><a href="<?php echo $this->layout->site_dir(); ?>/sign/signout">로그아웃</a></li>
            <?php } ?>
        </ul>

        <div id="mo-sch">
            <form action="<?php echo PH_DIR; ?>/search">
                <fieldset>
                    <legend>통합검색</legend>
                    <input type="text" name="keyword" class="inp" />
                    <button type="submit" class="sbm">검색</button>
                </fieldset>
            </form>
        </div>

        <ul id="mo-gnb">
            <?php foreach($SITEMAP as $gnb){ ?>
            <li>
                <a href="<?php echo $gnb['href']; ?>" data-category-key="<?php echo $gnb['idx']; ?>"><?php echo $gnb['title']; ?></a>
                <?php if(count($gnb['2d'])>0){ ?>
                <div class="sound_only_ele">하위 메뉴</div>
                <ul>
                    <?php foreach($gnb['2d'] as $gnb2){ ?>
                    <li>
                        <a href="<?php echo $gnb2['href']; ?>" data-category-key="<?php echo $gnb2['idx']; ?>"><?php echo $gnb2['title']; ?></a>
                        <?php if(count($gnb2['3d'])>0){ ?>
                        <ul>
                            <?php foreach($gnb2['3d'] as $gnb3){ ?>
                            <li><a href="<?php echo $gnb3['href']; ?>" data-category-key="<?php echo $gnb3['idx']; ?>"><?php echo $gnb3['title']; ?></a></li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </li>
            <?php } ?>
        </ul>

        <button type="button" id="slide-menu-close" class="sound_only_ele">전체 메뉴 닫기</button>
    </div>
</div>
<div id="slide-bg"></div>

<?php if (defined('MAINPAGE')) { ?>
<!-- Main page -->
<div id="main">
    <div id="content"> 

<?php } else { ?>
<!-- Sub page -->
<div id="sub">
    <div id="content">

        <?php if ($NAVIGATOR) { ?>
        <div id="sub-tit">
            <h2><?php echo $NAVIGATOR[count($NAVIGATOR)-1]['title']; ?></h2>
        </div>
        <?php } ?>

<?php } ?>
