<?php
class Helper {
    private static $configStack = array();

	public static function formatLanguage($lang_id, $encode = true) {
		$languages = Yii::app()->params["app.languages"];
		$lang = isset($languages[$lang_id]) ? $languages[$lang_id] . " (". $lang_id .")" : $lang_id;
		return $encode ? CHtml::encode($lang) : $lang;
	}

	public static function getLastElement(array $array, $diff = 1) {
		if (count($array) < $diff)
			return null;
		$keys = array_keys($array);
		return $array[$keys[count($keys) - $diff]];
	}

	public static function slug($text, $default = "n-a") {
		$text = preg_replace('~[^\\pL\d]+~ui', '-', $text);
		$text = trim($text, '-');
		$text = mb_strtolower($text);
		if (empty($text)) {
			return $default;
		}
		return $text;
	}

	public static function getInstalledUrl() {
		return ucfirst(preg_replace("(https?://)", "", Yii::app() -> getBaseUrl(true)));
	}

    public static function mb_ucfirst($string) {
        $first = mb_strtoupper(mb_substr($string, 0, 1));
        $second = mb_substr($string, 1);
        return $first . $second;
    }

    public static function cropText($text, $length, $separator = '...') {
        return mb_strlen($text) > $length ? mb_substr($text, 0, $length). $separator : $text;
    }

    public static function _v($a, $k, $d = null) {
        return isset($a[$k]) ? $a[$k] : $d;
    }

    public static function md5Url($url) {
        return md5(trim($url, "/"));
    }

    public static function getBannerList() {
        $dir = Yii::app()->getBasePath(). '/../static/logos';
        $dh  = opendir($dir);
        while (false !== ($filename = readdir($dh))) {
            $files[] = $filename;
        }
        return preg_grep('/(\.jpg|\.jpeg|\.gif|\.png|\.bmp)$/i', $files);
    }

    public static function getBackUrl() {
        if($conf_url = Yii::app()->params["params.back_url"]) {
            return $conf_url;
        }
        return preg_replace('/^https/', 'http',  Yii::app()->getBaseUrl(true), 1);
    }

    public static function curl($url, array $headers = array(), $cookie = false) {
        $ch = curl_init($url);
        if($cookie) {
            $path = Yii::getPathOfAlias(Yii::app()->params['curl.cookie_cache_path']);
            $cookie = $path."/cookie_{$cookie}.txt";
        }
        $html = self::curl_exec($ch, $headers, $cookie);
        curl_close($ch);
        return $html;
    }

    public static function curl_exec($ch, $headers=array(), $cookie = false, & $maxredirect = null)
    {
        return curl_exec(self::ch($ch, $headers, $cookie, $maxredirect));
    }

    public static function ch($ch, $headers=array(), $cookie = false, &$maxredirect = null) {
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);

        if($cookie) {
            curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie);
            curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookie);
        }

        if(!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if(isset($headers['user_agent'])) {
            $user_agent = $headers['user_agent'];
            unset($headers['user_agent']);
        } else {
            $user_agent = Yii::app()->params['curl.user_agent'];
        }


        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent );

        $mr = $maxredirect === null ? 5 : intval($maxredirect);
        if (ini_get('open_basedir') == '' && (ini_get('safe_mode') == 'Off' || ini_get('safe_mode')=='')) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);
            curl_setopt($ch, CURLOPT_MAXREDIRS, $mr);
        } else {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            $original_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            $parsed = parse_url($original_url);
            if(!$parsed) {
                return false;
            }
            $scheme = isset($parsed['scheme']) ? $parsed['scheme'] : '';
            $host = isset($parsed['host']) ? $parsed['host'] : '';

            if ($mr > 0)
            {
                $newurl = $original_url;
                $rch = curl_copy_handle($ch);

                curl_setopt($rch, CURLOPT_HEADER, true);
                curl_setopt($rch, CURLOPT_NOBODY, true);
                curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
                curl_setopt($rch, CURLOPT_RETURNTRANSFER, true);
                do
                {
                    curl_setopt($rch, CURLOPT_URL, $newurl);
                    $header = curl_exec($rch);
                    if (curl_errno($rch)) {
                        $code = 0;
                    } else {
                        $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                        if (in_array($code, array(301, 302, 307, 308))) {
                            preg_match('/Location:(.*?)\n/i', $header, $matches);
                            $newurl = trim(array_pop($matches));

                            if(!$parsed = parse_url($newurl)) {
                                return false;
                            }

                            if(!isset($parsed['scheme'])) {
                                $parsed['scheme'] = $scheme;
                            } else {
                                $scheme = $parsed['scheme'];
                            }

                            if(!isset($parsed['host'])) {
                                $parsed['host'] = $host;
                            } else {
                                $host = $parsed['host'];
                            }
                            $newurl = self::unparse_http_url($parsed);
                        } else {
                            $code = 0;
                        }
                    }
                } while ($code && --$mr);
                curl_close($rch);

                if (!$mr)
                {
                    if ($maxredirect === null)
                        return false;
                    else
                        $maxredirect = 0;

                    return false;
                }
                curl_setopt($ch, CURLOPT_URL, $newurl);
            }
        }
        return $ch;
    }

    public static function unparse_http_url(array $parsed) {
        if(!isset($parsed['host'])) {
            return false;
        }
        $url = isset($parsed['scheme']) ? $parsed['scheme']."://" : "http://";
        if(isset($parsed['user'])) {
            $url .= $parsed['user'];
            if(isset($parsed['pass'])) {
                $url .= ":".$parsed['pass'];
            }
            $url .= "@".$parsed['host'];
        } else {
            $url .= $parsed['host'];
        }

        if(isset($parsed['port'])) {
            $url .= ":".$parsed['port'];
        }

        if(isset($parsed['path'])) {
            $url .= $parsed['path'];
        }
        if(isset($parsed['query'])) {
            $url .= "?".$parsed['query'];
        }
        if(isset($parsed['fragment'])) {
            $url .= "#".$parsed['fragment'];
        }
        return $url;
    }

    public static function isRecaptchaEnabled() {
        $params = Yii::app()->params;
        return (!empty($params['recaptcha.public']) AND !empty($params['recaptcha.private']));
    }

    public static function getNavName()
    {
        $brand_name = Yii::app()->params["app.nav_name"];
        return empty($brand_name) ? Yii::app()->name : $brand_name;
    }

    public static function getNavbarBrand()
    {
        $conf_nav_name = Yii::app()->params["app.nav_name"];
        $nav_name = empty($conf_nav_name) ? Yii::app()->name : $conf_nav_name;
        if(!empty(Yii::app()->params['app.nav_icon'])) {
            return CHtml::image(Yii::app()->params['app.nav_icon'], $nav_name, array(
                'width'=>24,
                'height'=>24,
            ));
        } else {
            return $nav_name;
        }
    }
}