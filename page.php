<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="page-container">
    <div class="container">
        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
            
            <!-- 独立页面 - 朝中社风格 -->
            <div class="article-content">
                <!-- 页面标题 -->
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
                
                <!-- 页面内容主体 -->
                <div class="article-content-body">
                    <div class="content-wrapper" style="line-height:1.8;font-size:16px;color:#333;">
                        <?php 
                        // 使用 ob_start 捕获内容输出
                        ob_start();
                        $this->content();
                        $content = ob_get_clean();
                        
                        // 处理重要文本
                        if (function_exists('processContentWithImportantText')) {
                            echo processContentWithImportantText($content);
                        } else {
                            echo $content;
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>

<?php $this->need('footer.php'); ?>