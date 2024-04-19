<?php
/**
* @brief     Вывод видео YouTube по ID
* @author    Максим Ёдгоров
* @version   1.2.0
* @copyright Copyright (C) 2024 Максим Ёдгоров
* @license   Licensed under GNU/GPLv3, see https://www.gnu.org/licenses/gpl-3.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Access\Access;

HTMLHelper::_('stylesheet', Uri::root() . 'plugins/content/jyoutube/jyoutube.css');

class PlgContentJYouTube extends CMSPlugin
{

    public function onBeforeCompileHead()
    {
        $app = Factory::getApplication();
        if ($app->isClient('site')) {
            $doc = Factory::getDocument();
            $doc->addScript(Uri::root() . 'plugins/content/jyoutube/jyoutube.js');
        }
    }
    
    public function onContentPrepare($context, &$article, &$params, $page = 0)
    {
        if ($context === 'com_finder.indexer') {
            return true;
        }

        $search = '/{yt_id}(.*?){\/yt_id}/s';
        preg_match_all($search, $article->text, $matches, PREG_SET_ORDER);

        if ($matches) {
            foreach ($matches as $key => $match) {
                $youtubeId = trim(strval($match[1]), "/:<>");
                $replacement = '<div class="jyoutube-start">
<div class="jyoutube" data-video="https://youtu.be/' . $youtubeId . '">
  <img src="" alt="video">
  <button class="jyoutube-video-play jyoutube-btn-reset">
    <svg width="68" height="48" viewBox="0 0 68 48">
      <path class="jyoutube-video-play-shape"
            d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z">
      </path>
      <path class="jyoutube-video-play-icon" d="M 45,24 27,14 27,34"></path>
    </svg>
  </button>
</div>
</div>';
                $article->text = str_replace($match[0], $replacement, $article->text);
            }
        }
    }
}
?>
