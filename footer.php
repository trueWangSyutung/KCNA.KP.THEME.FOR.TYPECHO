<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<!-- 页脚 -->
<div class="footer page-footer">
    <div class="container signup-hide">
        <!-- 底部菜单 -->
        <div class="row footer-menu-container">
            <div class="col-md-12">
                <div class="col-md-12 menu-block">
                    <ul class="nav-menu first-line" style="text-align:center">
                        <li class="first"><a href="<?php $this->options->siteUrl(); ?>">最新新闻</a></li>
                        <li><a href="<?php $this->options->siteUrl(); ?>">主要新闻</a></li>
                        <li><a href="<?php $this->options->siteUrl(); ?>">国内新闻</a></li>
                        <li><a href="<?php $this->options->siteUrl(); ?>">国际新闻</a></li>
                        <li><a href="<?php $this->options->siteUrl(); ?>">对外关系</a></li>
                        <li><a href="<?php $this->options->siteUrl(); ?>">图片</a></li>
                        <li><a href="<?php $this->options->siteUrl(); ?>">视频</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
       
    <!-- 友情链接 -->
    <div class="container" style="padding:15px 0;">
        <?php 
        $friendLinks = $this->options->friendLinks;
        if (!empty($friendLinks)): 
            $links = explode("\n", trim($friendLinks));
            $links = array_filter(array_map('trim', $links));
        ?>
        <div class="sidebar widget14 ref-sites bbt">
            <div class="sidebar-content col-md-12 col-sm-12">
                <div style="text-align:center;margin-bottom:15px;color:#333;font-weight:bold;font-size:14px;">友情链接</div>
                <div style="text-align:center;">
                    <?php foreach ($links as $link): ?>
                    <?php 
                    $parts = explode('|', $link);
                    $name = isset($parts[0]) ? trim($parts[0]) : '';
                    $url = isset($parts[1]) ? trim($parts[1]) : '';
                    $imgUrl = isset($parts[2]) ? trim($parts[2]) : '';
                    $title = isset($parts[3]) ? trim($parts[3]) : $name;
                    if (!empty($name) && !empty($url)):
                    // 处理相对路径的图片
                    if (!empty($imgUrl) && strpos($imgUrl, 'http') !== 0) {
                        $imgUrl = Helper::options()->siteUrl . ltrim($imgUrl, '/');
                    }
                    // 如果没有图片，使用SVG占位
                    $finalImgUrl = !empty($imgUrl) ? htmlspecialchars($imgUrl) : 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="140" height="40"%3E%3Crect fill="%23ddd" width="140" height="40"/%3E%3Ctext x="50%25" y="50%25" text-anchor="middle" dy=".3em" fill="%23999" font-size="10px"%3E' . htmlspecialchars($name) . '%3C/text%3E%3C/svg%3E';
                    ?>
                        <a href="<?php echo htmlspecialchars($url); ?>" target="_blank" title="<?php echo htmlspecialchars($title); ?>">
                            <img src="<?php echo $finalImgUrl; ?>" alt="<?php echo htmlspecialchars($name); ?>" border="0" style="width:90px;height:40px; object-fit: fill; ">
                        </a>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- 版权信息 -->
<div class="footer-container">
        <div class="container">
            <div class="copy-right col-md-12 col-sm-12 lang-link-kp" style="text-align:center;padding:15px 0;color:#333;font-weight:bold;">
                <?php $this->options->title() ?> | Copyright © 2000-<?php echo date('Y'); ?> by OpenAcademic
            </div>
            <?php if ($this->options->icpNumber): ?>
            <div class="copy-right col-md-12 col-sm-12 lang-link-kp" style="text-align:center;padding:5px 0;color:#666;font-size:12px;">
                <?php $this->options->icpNumber(); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- 回到顶部按钮 -->
    <div class="scroll-to-top" style="display:none;position:fixed;right:15px;bottom:68px;width:30px;height:30px;border:4px solid #657383;border-radius:50%;cursor:pointer;text-align:center;line-height:22px;">
        <i class="fa fa-long-arrow-up" style="color:#657383;"></i>
    </div>
</div>

<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
// 回到顶部功能
$(window).scroll(function () {
    if ($(this).scrollTop() > 90) {
        $('.scroll-to-top').fadeIn();
    } else {
        $('.scroll-to-top').fadeOut();
    }
});

$('.scroll-to-top').click(function () {
    $('body,html').animate({
        scrollTop: 0
    }, 500);
    return false;
});

// 移动端菜单切换
$('.drop-list-lang i').click(function() {
    $('.mobile-bar .content').css("display", "none");
    $('.mobile-bar div').removeClass("active");
    $('.mobile-bar .drop-list-lang .content').slideDown("2000", function() {
        $('.mobile-bar .drop-list-lang .content').css("display", "block");
    });
    $('.mobile-bar .drop-list-lang').addClass("active");
});

$('.drop-list-category i').click(function() {
    $('.mobile-bar .content').css("display", "none");
    $('.mobile-bar div').removeClass("active");
    $('.mobile-bar .drop-list-category .content').slideDown("2000", function() {
        $('.mobile-bar .drop-list-category .content').css("display", "block");
    });
    $('.mobile-bar .drop-list-category').addClass("active");
});
</script>

<?php $this->footer(); ?>
</body>
</html>
