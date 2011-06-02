<?php

class SniftrReader
{
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
}

?>
