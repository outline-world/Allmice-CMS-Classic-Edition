<?php

class Core
{
	public function getBaseMetaTags()
	{

		$metaTags="";

		$charset = "<meta charset=\"utf-8\">\n";

		$genTag="<meta name=\"Generator\" content=\"Allmice CMS (https://www.allmice.com/cms)\">\n";

		$metaTags.=($charset.$genTag);
		return $metaTags;
	}
	public function getBotTag($botAccess)
	{

		$botTag="";

		if(isset($botAccess)){
			switch($botAccess){
				case 2:
					$botTag="<meta name=\"robots\" content=\"noindex, nofollow\">\n";
					break;
				case 3:
					$botTag="<meta name=\"robots\" content=\"noindex, follow\">\n";
					break;
				case 4:
					$botTag="<meta name=\"robots\" content=\"index, nofollow\">\n";
					break;
				case 5:
					$botTag="<meta name=\"robots\" content=\"index, follow\">\n";
					break;
			}
		}

		return $botTag;
	}

}
