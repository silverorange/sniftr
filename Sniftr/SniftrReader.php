<?php

class SniftrReader
{
	// {{{ public static properties

	public static $photo_dimension = 500;

	// }}}
	// {{{ public function getPosts()

	public function getPosts($xml_file)
	{
		$posts = array();

		$xml_contents = file_get_contents($xml_file);

		$xml = new SimpleXMLElement($xml_contents);
		foreach ($xml->posts->post as $post) {
			$posts[] = $this->getFormattedPost($post);
		}

		return $posts;
	}

	// }}}
	// {{{ private function getFormattedPost()

	private function getFormattedPost($post)
	{
		$p = new StdClass();
		$p->type = (string) $post['type'];
		$p->link = (string) $post['url-with-slug'];

		// TODO: is date UTC?
		$p->date = date('F j Y, g:i a', (int) $post['unix-timestamp']);

		$p->title = $this->getPostTitle($post);
		$p->bodytext = $this->getPostBody($post);

		return $p;
	}

	// }}}
	// {{{ private function getPostTitle()

	private function getPostTitle($post)
	{
		switch ($post['type']) {
		case 'video' :
			return $this->getVideoTitle($post);
		case 'conversation' :
			return $this->getConversationTitle($post);
		case 'link' :
			return $this->getLinkTitle($post);
		case 'quote' :
			return $this->getQuoteTitle($post);
		case 'photo' :
			return $this->getPhotoTitle($post);
		case 'regular' :
			return $this->getRegularTitle($post);
		}
	}

	// }}}
	// {{{ private function getPostBody()

	private function getPostBody($post)
	{
		switch ($post['type']) {
		case 'video' :
			return $this->getVideoBody($post);
		case 'conversation' :
			return $this->getConversationBody($post);
		case 'link' :
			return $this->getLinkBody($post);
		case 'quote' :
			return $this->getQuoteBody($post);
		case 'photo' :
			return $this->getPhotoBody($post);
		case 'regular' :
			return $this->getRegularBody($post);
		}
	}

	// }}}
	// {{{ private function getRegularBody()

	private function getRegularBody($post)
	{
		$body = 'regular-body';
		return $post->$body;
	}

	// }}}
	// {{{ private function getVideoBody()

	private function getVideoBody($post)
	{
		$player = 'video-player';
		return $post->$player;
	}

	// }}}
	// {{{ private function getConversationBody()

	private function getConversationBody($post)
	{
		ob_start();

		foreach ($post->conversation->line as $line) {
			echo '<p>';
			echo '<strong>',$line['label'],'</strong> ',((string) $line);
			echo '</p>';
		}

		return ob_get_clean();
	}

	// }}}
	// {{{ private function getLinkBody()

	private function getLinkBody($post)
	{
		$text = 'link-text';
		$description = 'link-description';
		$url = 'link-url';

		ob_start();
		echo '<strong><a href="'.$post->$url.'">'.$post->$text.'</a></strong>';

		if (isset($post->$description) && $post->$description != '') {
			echo '<p>'.$post->$description.'</p>';
		}

		return ob_get_clean();
	}

	// }}}
	// {{{ private function getQuoteBody()

	private function getQuoteBody($post)
	{
		$text = 'quote-text';
		$source = 'quote-source';

		ob_start();
		echo '<em>“'.$post->$text.'”</em>';

		if (isset($post->$source) && $post->$source != '') {
			echo '<br />'.$post->$source;
		}

		return ob_get_clean();
	}

	// }}}
	// {{{ private function getPhotoBody()

	private function getPhotoBody($post)
	{
		$url = 'photo-url';

		ob_start();

		foreach ($post->$url as $url) {
			if ($url['max-width'] == self::$photo_dimension) {
				echo '<img src="'.((string) $url).'" alt="" />';
				break;
			}
		}

		return ob_get_clean();
	}

	// }}}
	// {{{ private function getRegularTitle()

	private function getRegularTitle($post)
	{
		$title = 'regular-title';
		if (isset($post->$title) && $post->$title != '') {
			return $post->$title;
		} else {
			return 'Untitled';
		}
	}

	// }}}
	// {{{ private function getVideoTitle()

	private function getVideoTitle($post)
	{
		$caption = 'video-caption';
		if (isset($post->$caption) && $post->$caption != '') {
			return strip_tags($post->$caption);
		} else {
			return 'Untitled Video';
		}
	}

	// }}}
	// {{{ private function getConversationTitle()

	private function getConversationTitle($post)
	{
		$title = 'conversation-title';
		if (isset($post->$title) && $post->$title != '') {
			return $post->$title;
		} else {
			return 'Conversation';
		}
	}

	// }}}
	// {{{ private function getLinkTitle()

	private function getLinkTitle($post)
	{
		$link = 'link-text';
		if (isset($post->$link) && $post->$link != '') {
			return $post->$link;
		} else {
			return 'Link';
		}
	}

	// }}}
	// {{{ private function getQuoteTitle()

	private function getQuoteTitle($post)
	{
		return 'Quote';
	}

	// }}}
	// {{{ private function getPhotoTitle()

	private function getPhotoTitle($post)
	{
		$caption = 'photo-caption';
		if (isset($post->$caption) && $post->$caption != '') {
			return $post->$caption;
		} else {
			return 'Photo';
		}
	}

	// }}}
}

?>
