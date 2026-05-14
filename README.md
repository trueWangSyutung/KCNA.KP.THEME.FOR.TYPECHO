# 朝中社风格 Typecho 主题

一款仿照朝中社（KCNA）官网风格设计的 Typecho 主题。
demo: [https://oac.ac.cn/](https://oac.ac.cn/)

## 功能特性

### 1. 重要文本高亮

支持用户配置需要放大并加粗显示的文本内容，如国家领导人姓名等。

### 2. Logo 配置

支持自定义网站 Logo 图片或文字。

### 3. 友情链接

支持配置友情链接，显示为图片链接形式。

### 4. 图片画廊

点击文章中的相机图标可进入图片画廊页面，支持：
- 图片左右切换
- 键盘左右箭头导航
- 图片计数器显示

### 5. Markdown 图片支持

支持三种图片格式：
- HTML img 标签
- Markdown 内联格式 `![alt](url)`
- Markdown 引用式格式 `![alt][1]` + `[1]: url`

### 6. 响应式设计

适配桌面端和移动端浏览。

## 安装方法

1. 下载主题压缩包
2. 解压到 Typecho 主题目录 `usr/themes/`
3. 登录 Typecho 后台，进入「外观」→「外观设置」
4. 选择启用本主题

## 配置说明

在 Typecho 后台「外观」→「设置外观」中配置以下选项：

### 需要放大的文本内容

每行输入一个需要放大并加粗显示的文本内容：

```
xxx
yyy
```

### 重要文本放大级别

- 小 (1.2倍)
- 中 (1.35倍)
- 大 (1.5倍)

### 重要文本强调色

默认朝中社红色：`#AE0101`

### Logo图片地址

网站Logo图片的URL地址，支持绝对路径或相对路径：

```
https://example.com/logo.png
usr/uploads/logo.png
```

### Logo文字（备用）

当没有设置Logo图片时显示的文字。

### 网站副标题

显示在网站标题下方的副标题。

### 网站备案号

如：`京ICP备12345678号`

### 友情链接

每行一个链接，格式：`链接名称|链接地址|图片地址|网站描述（可选）`

```
劳动新闻|http://www.rodong.rep.kp|https://example.com/logo1.png|朝鲜劳动党机关报
朝鲜之声|http://www.vok.rep.kp/||朝鲜之声广播电台
```

## 主题文件结构

```
classic-22/
├── header.php          # 头部区域
├── footer.php          # 页脚区域
├── index.php           # 首页
├── post.php            # 文章详情页
├── page.php            # 独立页面
├── search.php          # 搜索页面
├── category.php        # 分类页面
├── functions.php       # 功能函数
├── theme.css           # 样式文件
├── screenshot.png      # 主题截图
└── README.md           # 说明文档
```

## 技术特点

- 基于 Bootstrap 3.3.7 框架
- 使用 Font Awesome 图标库
- 朝中社风格红色主题（#AE0101）
- 纯前端图片画廊，无需额外依赖

## 浏览器支持

- Chrome（推荐）
- Firefox
- Safari
- IE 10+

## 许可证

MIT License

## 更新记录

### v1.0.0
- 初始版本发布
- 朝中社风格设计
- 重要文本高亮功能
- Logo 和友情链接配置
- 图片画廊功能
