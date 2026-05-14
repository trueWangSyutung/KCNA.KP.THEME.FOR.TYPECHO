<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php 
/**
 * KCNA 朝鲜中央通讯社风格模板
 *
 * @package 朝鲜中央通讯社风格模板
 * @author 朝鲜中央通讯社风格模板
 * @version 1.2
 */
// 检查是否为 gallery 页面（需要在加载 header 之前检查）
$isGallery = false;
$galleryCid = 0;
$galleryPostTitle = '';
$galleryPostDate = '';
$galleryPermalink = '';
$galleryImages = array();

if (isset($_GET['gallery']) && isset($_GET['cid'])) {
    $galleryCid = intval($_GET['cid']);
    if ($galleryCid > 0) {
        $db = Typecho_Db::get();
        $row = $db->fetchRow($db->select('cid', 'title', 'created', 'text')
            ->from('table.contents')
            ->where('cid = ?', $galleryCid)
            ->where('status = ?', 'publish'));
        
        if ($row) {
            $isGallery = true;
            $galleryPostTitle = $row['title'];
            $galleryPostDate = date('Y.m.d.', $row['created']);
            $galleryPermalink = Helper::options()->siteUrl . 'index.php/archives/' . $galleryCid . '/';
            
            // 尝试匹配多种图片格式
            $postContent = $row['text'];
            preg_match_all('/<img[^>]+src=[\'"]?([^\'"\s>]+)[\'"]?[^>]*>/i', $postContent, $imgMatches);
            if (isset($imgMatches[1]) && !empty($imgMatches[1])) {
                $galleryImages = $imgMatches[1];
            } else {
                preg_match_all('/!\[[^\]]*\]\(([^)]+)\)/i', $postContent, $mdMatches);
                if (isset($mdMatches[1]) && !empty($mdMatches[1])) {
                    $galleryImages = $mdMatches[1];
                } else {
                    preg_match_all('/^\s*\[\d+\]\s*:\s*(\S+)/im', $postContent, $refMatches);
                    if (isset($refMatches[1]) && !empty($refMatches[1])) {
                        $galleryImages = $refMatches[1];
                    }
                }
            }
            
            foreach ($galleryImages as &$img) {
                if (strpos($img, 'http') !== 0) {
                    $img = Helper::options()->siteUrl . ltrim($img, '/');
                }
            }
            unset($img);
        } else {
            $galleryCid = 0;
        }
    }
}

// 如果是 gallery 页面，直接输出，不加载 header 和 footer
if ($isGallery && !empty($galleryImages)): 
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($galleryPostTitle); ?> | 图片展示</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #fff;
            overflow-x: hidden;
        }
        .title {
            text-align: center;
            padding: 20px 0;
            margin-bottom: 15px;
            position: relative;
        }
        .title .main {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }
        .title .main a {
            color: #333;
            text-decoration: none;
        }
        .title .button-close {
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
        }
        .fSpecCs {
            font-weight: bold;
            font-size: 1.1em;
            color: #AE0101;
        }
        .main-container {
            height: calc(100vh - 119px);
            position: relative;
        }
        .content {
            text-align: center;
            padding: 20px 0;
        }
        .content img {
            display: none;
            max-height: 833px;
            max-width: 100%;
            margin: 0 auto;
        }
        .content img.active {
            display: block;
        }
        .button {
            display: inline-block;
            padding: 8px 12px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 5px;
        }
        .button a {
            color: #333;
            text-decoration: none;
        }
        .button-close {
            background: #AE0101;
            border-color: #AE0101;
            padding: 6px 10px;
            margin: 0;
        }
        .button-close a {
            color: #fff;
        }
        .carousel-indicators {
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }
        .carousel-indicators span {
            margin: 0 10px;
            font-size: 14px;
            color: #666;
        }
        .img-1{
            cursor: none;
        }
        .carousel-indicators .button {
            padding: 5px 10px;
            font-size: 12px;
        }
        .carousel-indicators #photo_index,
        .carousel-indicators #photo_count {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body class="gallery">
    <div class="col-md-1"></div>
    <div class="col-md-10 col-sm-12 col-xs-12">
        <div class="title">
            <a href="<?php echo $galleryPermalink; ?>">
                <div class="main">
                    <span><?php echo function_exists('processContentWithImportantText') ? processContentWithImportantText($galleryPostTitle) : htmlspecialchars($galleryPostTitle); ?></span>
                </div>
            </a>
            <div class="button button-close"><a class="link media_goback" href="<?php echo $galleryPermalink; ?>"><i class="fa fa-power-off"></i></a></div>
        </div>
        <div class="main-container">
            <div class="content">
                <?php foreach ($galleryImages as $index => $img): ?>
                <img class="img-1 <?php echo ($index === 0) ? 'active' : ''; ?>" 
                     src="<?php echo htmlspecialchars($img); ?>" 
                     alt="<?php echo htmlspecialchars($galleryPostTitle); ?>" 
                     style="max-height: 833px;">
                <?php endforeach; ?>
            </div>
        </div>
        <div class="carousel-indicators">
            <span class="button button-previous gallery-control" data-action="prev"><i class="fa fa-chevron-left"></i></span>
            <span><span id="photo_index">1</span> / <span id="photo_count"><?php echo count($galleryImages); ?></span></span>
            <span class="button button-next gallery-control" data-action="next"><i class="fa fa-chevron-right"></i></span>
        </div>
    </div>
    <div class="col-md-1"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        var currentIndex = 0;
        var totalImages = <?php echo count($galleryImages); ?>;
        
        function showImage(index) {
            $('.content img').removeClass('active');
            $('.content img').eq(index).addClass('active');
            currentIndex = index;
            $('#photo_index').text(currentIndex + 1);
        }
        
        $('.button-next').click(function() {
            currentIndex = (currentIndex + 1) % totalImages;
            showImage(currentIndex);
        });
        
        $('.button-previous').click(function() {
            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
            showImage(currentIndex);
        });
        
        $(document).keydown(function(e) {
            if (e.key === 'ArrowLeft') {
                $('.button-previous').click();
            } else if (e.key === 'ArrowRight') {
                $('.button-next').click();
            }
        });
    });
    </script>
</body>
</html>
<?php exit; ?>
<?php endif; ?>

<?php $this->need('header.php'); ?>

<div class="page-container">
    <div class="container">
        <!-- 移动端搜索 -->
        <div class="col-sm-12 col-xs-12 mobile-search-container">
            <form class="search-form form-inline" method="post" action="<?php $this->options->siteUrl(); ?>">
                <div class="search-div">
                    <input type="text" class="search-text col-md-6" name="s" value="" placeholder="搜索">
                    <input type="submit" class="search-btn" value="搜索">
                </div>
            </form>
        </div>
        
        <div class="split"></div>
        
        <!-- 主内容区 -->
        <div class="col-md-8 col-sm-8 col-xs-12">
            
            <?php 
            $posts = array();
            $carouselImages = array();
            
            $db = Typecho_Db::get();
            $rows = $db->fetchAll($db->select('cid', 'title', 'created', 'text')
                ->from('table.contents')
                ->where('status = ?', 'publish')
                ->where('type = ?', 'post')
                ->order('created', Typecho_Db::SORT_DESC));
            
            foreach ($rows as $row) {
                $cid = $row['cid'];
                $title = $row['title'];
                $postDate = date('Y.m.d.', $row['created']);
                $content = $row['text'];
                $permalink = Helper::options()->siteUrl . 'index.php/archives/' . $cid . '/';
                $galleryUrl = Helper::options()->siteUrl . 'index.php?gallery=1&cid=' . $cid;
                
                $allImages = array();
                $hasImage = false;
                $imageUrl = '';
                
                if (!empty($content)) {
                    // 尝试匹配 HTML img 标签
                    preg_match_all('/<img[^>]+src=[\'"]?([^\'"\s>]+)[\'"]?[^>]*>/i', $content, $imgMatches);
                    
                    if (isset($imgMatches[1]) && !empty($imgMatches[1])) {
                        $allImages = $imgMatches[1];
                    } else {
                        // 尝试匹配 Markdown 内联格式: ![alt](url)
                        preg_match_all('/!\[[^\]]*\]\(([^)]+)\)/i', $content, $mdMatches);
                        if (isset($mdMatches[1]) && !empty($mdMatches[1])) {
                            $allImages = $mdMatches[1];
                        } else {
                            // 尝试匹配 Markdown 引用式格式
                            preg_match_all('/^\s*\[\d+\]\s*:\s*(\S+)/im', $content, $refMatches);
                            if (isset($refMatches[1]) && !empty($refMatches[1])) {
                                $allImages = $refMatches[1];
                            }
                        }
                    }
                    
                    if (!empty($allImages)) {
                        $hasImage = true;
                        $imageUrl = $allImages[0];
                        
                        foreach ($allImages as &$img) {
                            if (strpos($img, 'http') !== 0) {
                                $img = Helper::options()->siteUrl . ltrim($img, '/');
                            }
                        }
                        unset($img);
                        
                        $imageUrl = $allImages[0];
                    }
                }
                
                if ($hasImage) {
                    $carouselImages[] = array(
                        'title' => $title,
                        'permalink' => $permalink,
                        'date' => $postDate,
                        'imageUrl' => $imageUrl
                    );
                }
                
                $posts[] = array(
                    'title' => $title,
                    'permalink' => $permalink,
                    'galleryUrl' => $galleryUrl,
                    'date' => $postDate,
                    'content' => $content,
                    'hasImage' => $hasImage,
                    'imageUrl' => $imageUrl,
                    'allImages' => $allImages
                );
            }
            
            if (!empty($posts)): 
            ?>
            
            <div class="activity-background" style="margin-bottom:30px;">
                <div class="col-md-6 col-sm-6 col-xs-12 gallerys">
                    <?php if (!empty($carouselImages)): ?>
                    <div class="gallery active" id="mainCarousel">
                        <?php foreach ($carouselImages as $index => $carouselItem): ?>
                        <div class="item <?php echo ($index === 0) ? 'active' : 'hidden'; ?>" data-index="<?php echo $index; ?>">
                            <div class="img">
                                <a href="<?php echo $carouselItem['permalink']; ?>">
                                    <img class="img-paper" src="<?php echo $carouselItem['imageUrl']; ?>" alt="<?php echo htmlspecialchars($carouselItem['title']); ?>" style="max-height: 309.667px; width: 100%; object-fit: cover;">
                                </a>
                            </div>
                        <div class="img-title">
                            <a href="<?php echo $carouselItem['permalink']; ?>" id="carousel-title-link">
                                <nobr><?php echo function_exists('processContentWithImportantText') ? processContentWithImportantText($carouselItem['title']) : $carouselItem['title']; ?></nobr>
                            </a>
                            <span class="datemark" id="carousel-datetime">
                                <nobr>[<?php echo $carouselItem['date']; ?>]</nobr>
                            </span>
                        </div>
                        </div>

                        <?php endforeach; ?>
                        
                        
                        <?php if (count($carouselImages) > 1): ?>
                        <div class="carousel-controls" style="position:absolute;top:50%;transform:translateY(-50%);left:10px;z-index:10;">
                            <button class="carousel-prev" onclick="changeSlide(-1)"
  style="background:rgba(0,0,0,0.5);color:#fff;border:none;padding:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;">
  ❮
</button>
 </div>
                        
                        
                        <div class="carousel-controls-right" style="position:absolute;top:50%;transform:translateY(-50%);right:10px;z-index:10;">
                            <button class="carousel-next" onclick="changeSlide(1)"
  style="background:rgba(0,0,0,0.5);color:#fff;border:none;padding:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;">
  ❯
</button>

                        </div>
                        
                        <div class="carousel-indicators" style="position:absolute;bottom:40px;left:50%;transform:translateX(-50%);z-index:-999;">
                            <?php foreach ($carouselImages as $index => $carouselItem): ?>
                            <span class="indicator <?php echo ($index === 0) ? 'active' : ''; ?>" onclick="goToSlide(<?php echo $index; ?>)" style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#fff;margin:0 5px;cursor:pointer;"></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="gallery active">
                        <div class="item">
                            <div class="img" style="background:#f0f0f0;display:flex;align-items:center;justify-content:center;height:309.667px;">
                                <i class="fa fa-image" style="font-size:48px;color:#ccc;"></i>
                            </div>
                        </div>
                        <div class="img-title">
                            <a href="<?php echo $posts[0]['permalink']; ?>">
                                <?php echo function_exists('processContentWithImportantText') ? processContentWithImportantText($posts[0]['title']) : $posts[0]['title']; ?>
                            </a>
                            <span class="datemark">
                                <nobr>[<?php echo $posts[0]['date']; ?>]</nobr>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6 col-sm-6 col-xs-12 articles">
                    <?php 
                    $displayCount = min(5, count($posts));
                    for ($i = 0; $i < $displayCount; $i++): 
                        $post = $posts[$i];
                    ?>
                    <p class="pointer2">
                        <a href="<?php echo $post['permalink']; ?>">
                            <?php echo function_exists('processContentWithImportantText') ? processContentWithImportantText($post['title']) : $post['title']; ?>
                        </a>
                        <?php if ($post['hasImage']): ?>
                        <a href="<?php echo $post['galleryUrl']; ?>" title="查看图片">
                            <i class="fa fa-camera" style="margin-left:5px;"></i>
                        </a>
                        <?php endif; ?>
                        <span class="datemark"><nobr>[<?php echo $post['date']; ?>]</nobr></span>
                    </p>
                    <?php endfor; ?>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <?php if (count($posts) > 5): ?>
            <div class="activity-background" style="margin-bottom:20px;">
                <div class="cat-title col-md-12 col-sm-12 col-xs-12">
                    <span>更多新闻</span>
                </div>
                <div class="clearfix"></div>
                <div class="widget-content" style="padding:20px;">
                    <?php for ($i = 5; $i < count($posts); $i++): 
                        $post = $posts[$i];
                    ?>
                    <p class="pointer1">
                        <a href="<?php echo $post['permalink']; ?>">
                            <?php echo function_exists('processContentWithImportantText') ? processContentWithImportantText($post['title']) : $post['title']; ?>
                        </a>
                        <?php if ($post['hasImage']): ?>
                        <a href="<?php echo $post['galleryUrl']; ?>" title="查看图片">
                            <i class="fa fa-camera" style="margin-left:5px;"></i>
                        </a>
                        <?php endif; ?>
                        <span class="datemark"><nobr>[<?php echo $post['date']; ?>]</nobr></span>
                    </p>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php endif; ?>
            
            <nav class="pagination" style="text-align:center;margin-top:30px;">
                <?php if ($this->is('index')) {
                    $this->pageNav(_t('前一页'), _t('后一页'), 2, '...', array(
                        'wrapTag' => 'ul',
                        'itemTag' => 'li',
                        'currentClass' => 'active'
                    )); 
                } ?>
            </nav>
        </div>
        
        <div class="side-container col-md-4 col-sm-4 col-xs-12">
            
            <div class="widget widget2 mobile-hidden" style="margin-bottom:20px;">
                <div class="cat-title col-md-12 col-sm-12 col-xs-12">
                    <span>最新文章</span>
                </div>
                <div class="clearfix"></div>
                <div class="widget-content">
                    <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=5')->to($recent); ?>
                    <?php while ($recent->next()): ?>
                    <p class="pointer1">
                        <a href="<?php echo $recent->permalink(); ?>">
                            <?php $title = $recent->title; echo function_exists('processContentWithImportantText') ? processContentWithImportantText($title) : $title; ?>
                        </a>
                    </p>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <div class="widget widget2 mobile-hidden" style="margin-bottom:20px;">
                <div class="cat-title col-md-12 col-sm-12 col-xs-12">
                    <span>文章分类</span>
                </div>
                <div class="clearfix"></div>
                <div class="widget-content">
                    <?php $this->widget('Widget_Metas_Category_List')->to($categories); ?>
                    <?php while ($categories->next()): ?>
                    <p class="pointer1">
                        <a href="<?php echo $categories->permalink(); ?>"><?php echo $categories->name(); ?></a> (<?php echo $categories->count(); ?>)
                    </p>
                    <?php endwhile; ?>
                </div>
            </div>
         
            
        </div>
    </div>
</div>

<?php if (!empty($carouselImages) && count($carouselImages) > 1): ?>
<script>
(function() {
    var currentSlide = 0;
    var slides = document.querySelectorAll('#mainCarousel .item');
    var indicators = document.querySelectorAll('#mainCarousel .indicator');
    var totalSlides = slides.length;
    
    window.changeSlide = function(direction) {
        slides[currentSlide].classList.remove('active');
        slides[currentSlide].classList.add('hidden');
        indicators[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
        slides[currentSlide].classList.add('active');
        slides[currentSlide].classList.remove('hidden');
        indicators[currentSlide].classList.add('active');
    };
    
    window.goToSlide = function(index) {
        slides[currentSlide].classList.remove('active');
        slides[currentSlide].classList.add('hidden');
        indicators[currentSlide].classList.remove('active');
        currentSlide = index;
        slides[currentSlide].classList.add('active');
        slides[currentSlide].classList.remove('hidden');
        indicators[currentSlide].classList.add('active');
    };
    
    var autoPlayInterval = setInterval(function() { changeSlide(1); }, 5000);
    
    var carousel = document.getElementById('mainCarousel');
    if (carousel) {
        carousel.addEventListener('mouseenter', function() { clearInterval(autoPlayInterval); });
        carousel.addEventListener('mouseleave', function() { autoPlayInterval = setInterval(function() { changeSlide(1); }, 5000); });
    }
})();
</script>
<?php endif; ?>

<?php $this->need('footer.php'); ?>