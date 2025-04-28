<header id="header">

        <div id="skip-to-article"><a href="#content">본문 바로가기</a></div>





        <ul id="tnb">
            <?php if (!IS_MEMBER) { ?>
            <li><a href="<?php echo $this->layout->signin_href(); ?>">회원로그인</a></li>
            <li><a href="<?php echo $this->layout->site_dir(); ?>/sign/signup">회원가입</a></li>

            <?php } else { ?>
            <li><a href="<?php echo $this->layout->site_dir(); ?>/sign/signout">로그아웃</a></li>

            <?php } ?>
        </ul>


        
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
            <li><a href="<?php echo $this->layout->site_dir(); ?>/sign/signout">로그아웃</a></li>
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
