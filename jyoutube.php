<?php
/**
* @brief     Вывод видео YouTube по ID
* @author    Максим Ёдгоров
* @version   1.1.0
* @copyright Copyright (C) 2020 Максим Ёдгоров
* @license   Licensed under GNU/GPLv3, see https://www.gnu.org/licenses/gpl-3.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.plugin.plugin');
jimport('joomla.access.access');

JHTML::stylesheet(JURI::root() . 'plugins/content/jyoutube/jyoutube.css');

class PlgContentJYouTube extends JPlugin
{

	public function onContentPrepare($context, & $article, & $params, $page = 0)
	{

		if($context === 'com_finder.indexer')
		{
			return true;
		}

		$poisk = '/{yt_id}(.*?){\/yt_id}/s';
		preg_match_all($poisk, $article->text, $matches, PREG_SET_ORDER);

		if($matches)
		{
			foreach($matches as $key => $match)
			{
				$idyoutube = trim(strval($match[1]),"/:<>");
				$zamena    = '<div class="jyoutube"><iframe src="https://www.youtube.com/embed/'.$idyoutube.'?rel=0" loading="lazy" allowfullscreen="" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe></div>';
				$article->text = str_replace($match[0], $zamena, $article->text);
			}
		}
	}
}
?>