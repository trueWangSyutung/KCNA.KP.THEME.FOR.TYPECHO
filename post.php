<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="page-container">
    <div class="container">
        <div class="col-md-12 col-sm-12 col-xs-12">
            
            <!-- 文章详情 - 完全仿照朝中社官网结构 -->
            <div class="article-content-title">
                <div class="article-main-title" style="text-align:center;font-size:22px;line-height:1.6;color:#333;margin-bottom:20px;">
                    <strong>
                        <?php 
                        $title = $this->title;
                        echo function_exists('processContentWithImportantText') ? processContentWithImportantText($title) : $title;
                        ?>
                    </strong>
                </div>
            </div>
            
            <!-- 媒体图标（如果有图片） -->
            <?php 
            $postContent = $this->content;
            $allImages = array();
            
            // 尝试匹配多种图片格式
            preg_match_all('/<img[^>]+src=[\'"]?([^\'"\s>]+)[\'"]?[^>]*>/i', $postContent, $imgMatches);
            if (isset($imgMatches[1]) && !empty($imgMatches[1])) {
                $allImages = $imgMatches[1];
            } else {
                preg_match_all('/!\[[^\]]*\]\(([^)]+)\)/i', $postContent, $mdMatches);
                if (isset($mdMatches[1]) && !empty($mdMatches[1])) {
                    $allImages = $mdMatches[1];
                } else {
                    preg_match_all('/^\s*\[\d+\]\s*:\s*(\S+)/im', $postContent, $refMatches);
                    if (isset($refMatches[1]) && !empty($refMatches[1])) {
                        $allImages = $refMatches[1];
                    }
                }
            }
            
            // 处理相对路径
            foreach ($allImages as &$img) {
                if (strpos($img, 'http') !== 0) {
                    $img = Helper::options()->siteUrl . ltrim($img, '/');
                }
            }
            unset($img);
            
            $hasImage = !empty($allImages);
            $galleryUrl = Helper::options()->siteUrl . 'index.php?gallery=1&cid=' . $this->cid;
            ?>
            
            <?php if ($hasImage): ?>
            <div class="media-icon" style="text-align:end;margin-bottom:20px;">
                <div class="button button-newsview" style="display:inline-block;">
                    <a href="<?php echo $galleryUrl; ?>" class="link" title="查看图片">
                        <i class="fa fa-camera" style="font-size:16px;color:#AE0101;"></i>
                    </a>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- 文章内容主体 -->
            <div class="article-content-body">
                <div class="content-wrapper">
                    <?php 
                    ob_start();
                    $this->content();
                    $content = ob_get_clean();
                    
                    if (function_exists('processContentWithImportantText')) {
                        echo processContentWithImportantText($content);
                    } else {
                        echo $content;
                    }
                    ?>
                    <?php 
                        $domain = parse_url($this->options->siteUrl,PHP_URL_HOST);
                    
                    ?>
                    <span class="publish-time"> <?php  echo $domain ?> (<?php echo date('Y.m.d.', $this->created); ?>)</span>
                </div>
            </div>
            
            <!-- 文章标签 -->
            <?php if ($this->tags): ?>
            <div style="margin-top:30px;padding-top:20px;border-top:1px solid #ddd;">
                <strong style="color:#AE0101;">标签：</strong>
                <?php $this->tags(', ', true, '无'); ?>
            </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>

<?php $this->need('footer.php'); ?>