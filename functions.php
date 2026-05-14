<?php
/**
 * Typecho Theme Functions
 * 朝中社风格主题功能函数
 */

function themeConfig($form)
{
    // 需要放大的文本内容
    $importantTexts = new Typecho_Widget_Helper_Form_Element_Textarea(
        'importantTexts', 
        null, 
        '', 
        _t('需要放大的文本内容'), 
        _t('每行输入一个需要放大并加粗显示的文本内容，如：习近平、朝鲜劳动党')
    );
    $form->addInput($importantTexts);
    
    // 放大级别
    $zoomLevel = new Typecho_Widget_Helper_Form_Element_Select(
        'zoomLevel', 
        array(
            'small' => _t('小 (1.2倍)'),
            'medium' => _t('中 (1.35倍)'),
            'large' => _t('大 (1.5倍)')
        ), 
        'small', 
        _t('重要文本放大级别'), 
        _t('设置重要文本的放大程度')
    );
    $form->addInput($zoomLevel);
    
    // 强调色
    $highlightColor = new Typecho_Widget_Helper_Form_Element_Text(
        'highlightColor', 
        null, 
        '#AE0101', 
        _t('重要文本强调色'), 
        _t('设置重要文本的颜色，默认为朝中社红色 #AE0101')
    );
    $form->addInput($highlightColor);
    
    // 网站副标题
    $subtitle = new Typecho_Widget_Helper_Form_Element_Text(
        'subtitle', 
        null, 
        '', 
        _t('网站副标题'), 
        _t('显示在网站标题下方的副标题')
    );
    $form->addInput($subtitle);
    
    // 网站备案号
    $beian = new Typecho_Widget_Helper_Form_Element_Text(
        'beian', 
        null, 
        '', 
        _t('网站备案号'), 
        _t('如：京ICP备12345678号')
    );
    $form->addInput($beian);
    
    // 友情链接
    $friendLinks = new Typecho_Widget_Helper_Form_Element_Textarea(
        'friendLinks', 
        null, 
        '', 
        _t('友情链接'), 
        _t('每行一个链接，格式：链接名称|链接地址|图片地址|网站描述（可选）')
    );
    $form->addInput($friendLinks);
    
    // Logo图片
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'logoUrl', 
        null, 
        '', 
        _t('Logo图片地址'), 
        _t('网站Logo图片的URL地址，支持绝对路径或相对路径')
    );
    $form->addInput($logoUrl);
    
    // Logo文字（备用）
    $logoText = new Typecho_Widget_Helper_Form_Element_Text(
        'logoText', 
        null, 
        '', 
        _t('Logo文字（备用）'), 
        _t('当没有设置Logo图片时显示的文字')
    );
    $form->addInput($logoText);
}

function themeInit($archive)
{
}

// 移除内容中的图片，只保留文本
function processContentWithoutImages($content)
{
    if (empty($content)) {
        return '';
    }
    
    // 移除 HTML img 标签
    $content = preg_replace('/<img[^>]*>/i', '', $content);
    
    // 移除 Markdown 内联图片格式：![alt](url)
    $content = preg_replace('/!\[[^\]]*\]\([^)]+\)/iu', '', $content);
    
    // 移除 Markdown 引用式图片定义：[1]: url
    $content = preg_replace('/^\s*\[\d+\]\s*:\s*\S+/im', '', $content);
    
    // 移除 Markdown 图片引用：![alt][1]
    $content = preg_replace('/!\[[^\]]*\]\[\d+\]/iu', '', $content);
    
    return $content;
}
function processContentWithImportantText($content)
{
    if (empty($content)) {
        return '';
    }
    
    $options = Helper::options();
    $importantTextsStr = $options->importantTexts;
    
    if (empty($importantTextsStr)) {
        return $content;
    }
    
    $importantTexts = explode("\n", trim($importantTextsStr));
    $importantTexts = array_map('trim', $importantTexts);
    $importantTexts = array_filter($importantTexts);
    
    if (empty($importantTexts)) {
        return $content;
    }
    
    foreach ($importantTexts as $importantText) {
        if (empty($importantText)) continue;
        
        $escapedText = preg_quote($importantText, '/');
        
        $pattern = '/(' . $escapedText . ')/iu';
        $replacement = '<span style="font-weight:bold;font-size:1.1em;color:#AE0101;display:inline;">$1</span>';
        $content = preg_replace($pattern, $replacement, $content);
    }
    
    return $content;
}

function getZoomLevelClass()
{
    $options = Helper::options();
    $zoomLevel = $options->zoomLevel;
    
    switch ($zoomLevel) {
        case 'small':
            return 'zoom-small';
        case 'medium':
            return 'zoom-medium';
        case 'large':
            return 'zoom-large';
        default:
            return 'zoom-small';
    }
}

function getHighlightColor()
{
    $options = Helper::options();
    $color = $options->highlightColor;
    
    if (empty($color) || !preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
        return '#AE0101';
    }
    
    return $color;
}

function getSubtitle()
{
    $options = Helper::options();
    return $options->subtitle;
}

function getBeian()
{
    $options = Helper::options();
    return $options->beian;
}
?>
