<?php
/**
 * TypeCho代码高亮插件，核心来自：highlightjs.org
 * <br/>修改为MAC主题，支持一键切换引用CDN资源/本地资源
 * <br/>支持一键复制，支持行号显示。
 * <br/>CDN来自：bootcdn.net
 * 
 * @package TypeChoHighLight
 * @author 小码农
 * @version 1.0.0
 * @update: 2020/11/30
 * @link https://www.djc8.cn
 */
class TypeChoHighLight_Plugin implements Typecho_Plugin_Interface
{
    
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array('TypeChoHighLight_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('TypeChoHighLight_Plugin', 'footer');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 输出头部css
     * 
     * @access public
     * @param unknown $header
     * @return unknown
     */
    public static function header() {
        
        if (!Helper::options()->plugin('TypeChoHighLight')->highlighUrl) {
            $cssUrl = Helper::options()->pluginUrl . '/TypeChoHighLight/styles/' . Helper::options()->plugin('TypeChoHighLight')->style;
        }else{
            $cssUrl = 'https://cdn.bootcdn.net/ajax/libs/highlight.js/10.3.2/styles/' . Helper::options()->plugin('TypeChoHighLight')->style;
        }
        //必要的自有css
        $cssUrl2 = Helper::options()->pluginUrl . '/TypeChoHighLight/self.css';
        echo '<link rel="stylesheet" type="text/css" href="' . $cssUrl . '" />';
        echo '<link rel="stylesheet" type="text/css" href="' . $cssUrl2 . '" />';

       
    }
    
    
    /**
     * 输出尾部js
     * 
     * @access public
     * @param unknown $header
     * @return unknown
     */
    public static function footer() {
        $jsUrl = Helper::options()->pluginUrl . '/TypeChoHighLight/';
        
       
        
        //$highlighUrl
        if (!Helper::options()->plugin('TypeChoHighLight')->highlighUrl) {
            echo '<script type="text/javascript" src="'. $jsUrl .'highlight.min.js?version=9.12.0"></script>';
            echo '<script type="text/javascript" src="'. $jsUrl .'highlightjs-line-numbers.min.js"></script>';
            echo '<script type="text/javascript" src="'. $jsUrl .'clipboard.min.js"></script>';
            
        }else{
            echo '<script src="https://cdn.bootcdn.net/ajax/libs/highlight.js/10.3.2/highlight.min.js"></script>';
            echo '<script src="https://cdn.bootcdn.net/ajax/libs/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.js"></script>';
            echo '<script src="https://cdn.bootcdn.net/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>';
        }
        
        echo '<script type="text/javascript" src="'. $jsUrl .'typechohight.js"></script>';
        
    }
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
      
        $highlighUrl=new Typecho_Widget_Helper_Form_Element_Radio('highlighUrl',array(
            0 => _t('本地'),
            1 => _t('CDN')
        ),0,_t('资源引用方式'),_t('用于切换依赖库使用本地文件或者CDN文件'));
        $form->addInput($highlighUrl->addRule('enum', _t('必须选择一种资源引用方式'), array(0, 1)));
        
        $styles = array_map('basename', glob(dirname(__FILE__) . '/styles/*.css'));
        $styles = array_combine($styles, $styles);
        $style = new Typecho_Widget_Helper_Form_Element_Select('style', $styles, 'a11y-dark.min.css',
            _t('代码样式'));
        $form->addInput($style->addRule('enum', _t('必须选择样式'), $styles));
    }
   
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
 
}
