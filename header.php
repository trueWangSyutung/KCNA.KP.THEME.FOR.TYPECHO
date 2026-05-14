<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-Hans">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $this->archiveTitle(' | ', '', ''); ?> <?php $this->options->title(); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- 朝中社样式 - 全部整合到theme.css -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('theme.css'); ?>">
    
    <?php if (function_exists('themeHeaderHook')): themeHeaderHook(); endif; ?>
    <?php $this->header(); ?>
</head>

<body id="homebody" class="cn <?php echo function_exists('getZoomLevelClass') ? getZoomLevelClass() : ''; ?>" lang="zh-cn">

<!-- 移动端顶部栏 -->
<div class="mobile-bar col-md-12 col-sm-12">
    <div class="home">
        <a href="<?php $this->options->siteUrl(); ?>" class="kcna-link"><i class="fa fa-home"></i></a>
    </div>
    <div class="drop-list-lang">
        <i class="fa fa-language"></i>
        <div class="content">
            <a href="#" class="lang-link active" lang="cn">中国语</a>
        </div>
    </div>
    <div class="drop-list-category">
        <i class="fa fa-bars"></i>
        <div class="content">
            <ul style="text-align:center">
                <li class="first"><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
                <?php while ($pages->next()): ?>
                <li><a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>

<!-- 头部区域 -->
<div class="header page-header row">
    <div class="col-md-5 col-sm-12 col-xs-12">
        <a href="<?php $this->options->siteUrl(); ?>" class="kcna-link">
            <?php 
            $logoUrl = $this->options->logoUrl;
            $logoText = $this->options->logoText;
            
            // 处理相对路径
            if (!empty($logoUrl) && strpos($logoUrl, 'http') !== 0) {
                $logoUrl = $this->options->siteUrl . ltrim($logoUrl, '/');
            }
            ?>
            <?php if (!empty($logoUrl)): ?>
                <img class="kcna-logo" src="<?php echo htmlspecialchars($logoUrl); ?>" border="0" alt="<?php $this->options->title() ?>">
            <?php elseif (!empty($logoText)): ?>
                <h1 style="color:#fff;margin-top:20px;font-size:28px;font-weight:bold;"><?php echo htmlspecialchars($logoText); ?></h1>
                <?php if ($this->options->subtitle): ?>
                <p style="color:#fff;margin-top:5px;font-size:14px;text-align:center;"><?php $this->options->subtitle(); ?></p>
                <?php endif; ?>
            <?php else: ?>
                <h1 style="color:#fff;margin-top:20px;font-size:28px;font-weight:bold;"><?php $this->options->title() ?></h1>
                <?php if ($this->options->subtitle): ?>
                <p style="color:#fff;margin-top:5px;font-size:14px;text-align:center;"><?php $this->options->subtitle(); ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </a>
    </div>
    <div class="col-md-7 col-sm-12 col-xs-12">
        <div class="row">
            <!-- 语言栏 -->
            <div class="text-right language-bar">
                <a href="#" class="lang-link active" lang="cn">中国语</a>
            </div>
            <div class="clearfix"></div>
            
            <!-- 搜索框 -->
            <form class="search-form form-inline" method="post" action="<?php $this->options->siteUrl(); ?>">
                <div class="search-div">
                    <input type="text" class="search-text col-md-6" name="s" value="" placeholder="搜索">
                    <span class="warningtxt hide">不能使用的字符: &lt; &gt; /</span>
                </div>
            </form>
            <div class="clearfix"></div>
            
            <!-- 导航菜单 -->
            <div class="menu-container">
                <div class="menu-block">
                    <ul class="nav-menu">
                        <li><nobr><a href="<?php $this->options->siteUrl(); ?>">首页</a></nobr></li>
                        <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
                        <?php while ($pages->next()): ?>
                        <li><nobr><a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a></nobr></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
