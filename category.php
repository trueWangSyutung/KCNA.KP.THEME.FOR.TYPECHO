<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="page-container">
    <div class="container">
        <div class="col-md-12 col-sm-12 col-xs-12">
            
            <!-- 搜索结果页面 - 朝中社风格 -->
            <div class="category-content content">
            <!-- 分类标题 -->
            <div class="category-title category-title-" style="text-align:center;padding:20px 0;border-bottom:2px solid #AE0101;">
                    <h1 style="font-size:22px;color:#333;margin:0;">
                    <?php $this->archiveTitle(array(
                        'category' => _t('分类：%s'),
                        'search' => _t('搜索：%s'),
                        'tag' => _t('标签：%s'),
                        'author' => _t('作者：%s')
                    ), '', ''); ?>
                </h1>
            </div>
        

            <!-- 文章列表 -->
                <div class="article-wrapper" style="padding:20px;">
                <?php if ($this->have()): ?>
                    <ul class="list-unstyled">
                        <?php while ($this->next()): ?>
                            <li style="border-bottom:1px dashed #ddd;padding:15px 0;overflow:hidden;">
                                <div style="float:left;width:calc(100% - 120px);">
                                    <a href="<?php echo $this->permalink; ?>" style="color:#333;text-decoration:none;">
                                        <?php echo function_exists('processContentWithImportantText') ? processContentWithImportantText($this->title) : $this->title; ?>
                                    </a>
                                    <?php 
                                    // 提取图片
                                    $hasImage = false;
                                    $galleryUrl = '';
                                    ob_start();
                                    $this->content();
                                    $content = ob_get_clean();
                                    
                                    if (preg_match('/<img[^>]+src=[\'"]?([^\'"\s>]+)[\'"]?[^>]*>/i', $content, $matches)) {
                                        $hasImage = true;
                                        $galleryUrl = Helper::options()->siteUrl . 'index.php?gallery=1&cid=' . $this->cid;
                                    } elseif (preg_match('/!\[[^\]]*\]\(([^)]+)\)/i', $content, $matches)) {
                                        $hasImage = true;
                                        $galleryUrl = Helper::options()->siteUrl . 'index.php?gallery=1&cid=' . $this->cid;
                                    } elseif (preg_match('/^\s*\[\d+\]\s*:\s*(\S+)/im', $content, $matches)) {
                                        $hasImage = true;
                                        $galleryUrl = Helper::options()->siteUrl . 'index.php?gallery=1&cid=' . $this->cid;
                                    }
                                    ?>
                                    <?php if ($hasImage): ?>
                                        <a href="<?php echo $galleryUrl; ?>" title="查看图片" style="margin-left:8px;color:#AE0101;">
                                            <i class="fa fa-camera"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div style="float:right;width:100px;text-align:right;color:#666;font-size:14px;">
                                    [<?php echo date('Y.m.d.', $this->created); ?>]
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <div class="empty" style="text-align:center;padding:50px 0;color:#666;">
                        <p><?php _e('暂无相关文章'); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- 分页 -->
            <div class="pagination" style="text-align:center;margin-top:30px;">
                <?php $this->pageNav('&laquo;', '&raquo;', 2, '...', array('wrapTag' => 'ul', 'wrapClass' => 'pagination', 'itemTag' => 'li', 'textTag' => 'span', 'currentClass' => 'active', 'prevClass' => '', 'nextClass' => '')); ?>
            </div>
            </div>
        </div>
    </div>
</div>

<?php $this->need('footer.php'); ?>
