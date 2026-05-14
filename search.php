<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="page-container">
    <div class="container">
        <div class="col-md-12 col-sm-12 col-xs-12">
            
            <!-- 搜索结果页面 - 朝中社风格 -->
            <div class="category-content content">
                <!-- 搜索结果标题 -->
                <div class="category-title category-title-" style="text-align:center;padding:20px 0;border-bottom:2px solid #AE0101;">
                    <h2 style="font-size:20px;color:#333;margin:0;">搜索结果</h2>
                </div>
                
                <!-- 文章列表区域 -->
                <div class="article-wrapper" style="padding:20px;">
                    <?php if ($this->have()): ?>
                    <ul class="article-link" style="list-style:none;padding:0;margin:0;">
                        <?php while ($this->next()): ?>
                        <li style="border-bottom:1px dashed #ddd;padding:15px 0;overflow:hidden;">
                            <a href="<?php echo $this->permalink; ?>" style="display:block;color:#333;text-decoration:none;">
                                <?php 
                                $title = $this->title;
                                echo function_exists('processContentWithImportantText') ? processContentWithImportantText($title) : $title;
                                ?>
                            </a>
                            
                            <?php 
                            $content = $this->content;
                            $hasImage = false;
                            $galleryUrl = Helper::options()->siteUrl . 'index.php?gallery=1&cid=' . $this->cid;
                            
                            preg_match_all('/<img[^>]+src=[\'"]?([^\'"\s>]+)[\'"]?[^>]*>/i', $content, $imgMatches);
                            if (isset($imgMatches[1]) && !empty($imgMatches[1])) {
                                $hasImage = true;
                            } else {
                                preg_match_all('/!\[[^\]]*\]\(([^)]+)\)/i', $content, $mdMatches);
                                if (isset($mdMatches[1]) && !empty($mdMatches[1])) {
                                    $hasImage = true;
                                } else {
                                    preg_match_all('/^\s*\[\d+\]\s*:\s*(\S+)/im', $content, $refMatches);
                                    if (isset($refMatches[1]) && !empty($refMatches[1])) {
                                        $hasImage = true;
                                    }
                                }
                            }
                            
                            if ($hasImage): 
                            ?>
                            <a href="<?php echo $galleryUrl; ?>" target="_blank" title="查看图片">
                                <i class="fa fa-camera" style="margin-left:10px;color:#666;"></i>
                            </a>
                            <?php endif; ?>
                            
                            <span class="publish-time" style="float:right;color:#999;font-size:14px;">
                                <nobr>[<?php echo date('Y.m.d.', $this->created); ?>]</nobr>
                            </span>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                    <?php else: ?>
                    <div style="text-align:center;padding:60px 0;">
                        <p style="font-size:18px;color:#666;">没有找到相关内容</p>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- 分页 -->
                <?php if ($this->have()): ?>
                <div class="clearfix"></div>
                <div class="text-center pagination-div" style="padding:20px;">
                    <?php $this->pageNav('&laquo;', '&raquo;', 2, '...', array(
                        'wrapTag' => 'ul',
                        'itemTag' => 'li',
                        'currentClass' => 'active',
                        'prevClass' => 'prev-ctrl',
                        'nextClass' => 'next-ctrl'
                    )); ?>
                </div>
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</div>

<?php $this->need('footer.php'); ?>