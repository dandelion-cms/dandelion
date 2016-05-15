<?php

class Dandelion {

  private $settings_file = "data/settings.php";
  private $menus_file    = "data/menus.php";
  private $pages_path    = "pages/";

  public $current_page;
  public $settings     = array();

  // ---------------------------------------------------------------------------

  function __construct() {
    $this->settings = $this->read_settings_data();
    date_default_timezone_set($this->settings['site_tz']);
    $this->current_page = $this->settings['homepage'];
    if (isset($_GET['p'])) {
      $this->current_page = $_GET['p'];
    }
  }

  // ---------------------------------------------------------------------------

  function read_settings_data() {
    $db   = file($this->settings_file);
    $keys = explode(";", trim($db[1]));
    unset($db[0], $db[1]);
    $s = array_combine($keys, $db);
    foreach ($s as $k => $i) {
      $s[$k] = trim($i);
    }
    return $s;
  }

  // ---------------------------------------------------------------------------

  function read_menu_data($menu_name) {
    $db   = file_get_contents($this->menus_file);
    $p    = '/\['.$menu_name.'\](.*)\[\/'.$menu_name.'\]/s';
    $s    = preg_match($p, $db, $m);
    $md   = explode("\n", trim($m[1]));
    $menu = array();
    foreach ($md as $i) {
      $ma = explode(";", trim($i));
      $menu[$ma[0]] = ['label' => $ma[1]];
    }
    return $menu;
  }

  // ---------------------------------------------------------------------------

  function show_menu($menu_name) {
    $md = $this->read_menu_data($menu_name);
    $hk = $this->settings['homepage'];
    $hv = $md[$hk];
    unset($md[$hk]);
    $menu = array_merge([$hk => $hv], $md);
    $li   = "<li%CLASS%>%LINK%</li>\n";
    $mo   = "";
    foreach ($menu as $k => $i) {
      if ($this->settings['fancy_urls']) {
        $lnk = ($k == $this->settings['homepage']) ? "" : "$k/";
      } else {
        $lnk = ($k == $this->settings['homepage']) ? "" : "index.php?p=$k";
      }
      $label = ($k == $this->settings['homepage']) ? $this->settings['home_label'] : $i['label'];
      if ($k == $this->current_page) {
        $class = " class=\"current\"";
        $a     = $label;
      } else {
        $class = "";
        $a     = "<a href=\"".$this->settings['site_url'].$lnk."\">$label</a>";
      }
      $mo .= str_replace(['%CLASS%', '%LINK%'], [$class, $a], $li);
    }
    echo $mo;
  }

  // ---------------------------------------------------------------------------

  function show_site_title() {
    if ($this->current_page == $this->settings['homepage']) {
      if ($this->settings['site_tagline'] != "") {
        $title = $this->settings['site_title']." | ".$this->settings['site_tagline'];
      } else {
        $title = $this->settings['site_title'];
      }
    } else {
      $title = "#TODO:nome da página/post | ".$this->settings['site_title'];
    }
    echo $title;
  }

  // ---------------------------------------------------------------------------

  function load_page($page) {
    $pg = "\n".file_get_contents($this->pages_path."$page.php");
    $pg = $this->normalize_newlines($pg);
    $pg = $this->markup_to_html($pg);
    if ($fs = preg_match('/\[php\](.*?)\[\/php\]/', $pg, $m)) {
      $fr = $this->eval_function($m[1]);
      $pg = str_replace("[php]".$m[1]."[/php]", $fr, $pg);
    }
    echo $pg;
  }

  // ---------------------------------------------------------------------------

  function normalize_newlines($text) {
    $n = str_replace(["\r", "\r\n"], ["\n", "\n"], $text);
    $n = preg_replace("/\n{2,}/", "\n\n", $text);
    return $n;
  }

  // ---------------------------------------------------------------------------

  function markup_to_html($text) {

    $exclude = [' ', '<', '>', '=', '[', '{', '+', '"', "'", ''];
    $ta      = explode("\n", $text);
    foreach ($ta as $k => $line) {
      if (!in_array(substr($line, 0, 1), $exclude)) {
        $ta[$k] = "<p>".trim($line)."</p>";
      }
    }
    $text = implode("\n", $ta);
    $text = str_replace("</p>\n<p>", "\n<br />\n", $text);

    $pat = [
      '/^= (.*) =/m'                              => "<h1>$1</h1>",
      '/^== (.*) ==/m'                            => "<h2>$1</h2>",
      '/^=== (.*) ===/m'                          => "<h3>$1</h3>",
      '/^==== (.*) ====/m'                        => "<h4>$1</h4>",
      '/^===== (.*) =====/m'                      => "<h5>$1</h5>",
      '/^====== (.*) ======/m'                    => "<h6>$1</h6>",
      '/^(?<!\\\)\[\[(.*?)\|(.*?)\:\:(.*?)\]\]/m' => "<p class=\"a-block\"><a href=\"$1\" title=\"$2\">$3</a></p>",
      '/^(?<!\\\)\[\[(.*?)\:\:(.*?)\]\]/m'        => "<p class=\"a-block\"><a href=\"$1\" title=\"$2\">$1</a></p>",
      '/^(?<!\\\)\[\[(.*?)\|(.*?)\]\]/m'          => "<p class=\"a-block\"><a href=\"$1\">$2</a></p>",
      '/^(?<!\\\)\[\[(.*?)\]\]/m'                 => "<p class=\"a-block\"><a href=\"$1\">$1</a></p>",
      '/(?<!\\\)\[\[(.*?)\|(.*?)::(.*?)\]\]/'     => "<a href=\"$1\" title=\"$3\">$2</a>",
      '/(?<!\\\)\[\[(.*?)\:\:(.*?)\]\]/'          => "<a href=\"$1\" title=\"$2\">$1</a>",
      '/(?<!\\\)\[\[(.*?)\|(.*?)\]\]/'            => "<a href=\"$1\">$2</a>",
      '/(?<!\\\)\[\[(.*?)\]\]/'                   => "<a href=\"$1\">$1</a>",
      '/^(?<!\\\)\{\{(.*?)\|(.*?)\:\:(.*?)\}\}/m' => "<div class=\"picture-block\"><a href=\"$1\"><img src=\"$2\" alt=\"$3\" title=\"$3\" /></a></div>",
      '/(?<!\\\)\{\{(.*?)\|(.*?)\:\:(.*?)\}\}/'   => "<a href=\"$1\"><img src=\"$2\" alt=\"$3\" title=\"$3\" /></a>",
      '/^(?<!\\\)\{\{(.*?)\|(.*?)\}\}/m'          => "<div class=\"picture-block\"><a href=\"$1\"><img src=\"$2\" /></a></div>",
      '/(?<!\\\)\{\{(.*?)\|(.*?)\}\}/'            => "<a href=\"$1\"><img src=\"$2\" /></a>",
      '/^(?<!\\\)\{\{(.*?)\:\:(.*)\}\}/m'         => "<div class=\"picture-block\"><img src=\"$1\" alt=\"$2\" title=\"$2\" /></div>",
      '/(?<!\\\)\{\{(.*?)\:\:(.*)\}\}/'           => "<img src=\"$1\" alt=\"$2\" title=\"$2\" />",
      '/^(?<!\\\)\{\{(.*?)\}\}/m'                 => "<div class=\"picture-block\"><img src=\"$1\" /></div>",
      '/(?<!\\\)\{\{(.*?)\}\}/'                   => "<img src=\"$1\" />",
      '/\n\n (?<!\\\)\* (.*?)\n/m'                => "\n\n<ul>\n\t<li>$1</li>\n",
      '/^ (?<!\\\)\* (.*?)\n\n/m'                 => "\t<li>$1</li>\n</ul>\n\n",
      '/\n\n (?<!\\\)\+ (.*?)\n/m'                => "\n\n<ol>\n\t<li>$1</li>\n",
      '/^ (?<!\\\)\+ (.*?)\n\n/m'                 => "\t<li>$1</li>\n</ol>\n\n",
      '/^ (?<!\\\)[\+|\*] (.*?)\n/m'              => "\t<li>$1</li>\n",
      '/(?<!\\\)\'\'\'(.*?)(?<!\\\)\'\'\'/s'      => "<pre>$1</pre>",
      '/(?<!\\\)>>>(.*?)(?<!\\\)>>>/s'            => "<blockquote>$1</blockquote>\n",
      '/(?<!\\\)\*(.*?)\*/s'                      => "<strong>$1</strong>",
      '/(?<!\\\)\_(.*?)\_/s'                      => "<em>$1</em>",
      '/(?<!\\\)\~(.*?)\~/s'                      => "<u>$1</u>",
      '/(?<!\\\)\^(.*?)\^/s'                      => "<small>$1</small>",
      '/(?<!\\\)\`(.*?)\`/s'                      => "<code>$1</code>",
      '/(?<!\\\)\-\-\-(.*?)(?<!\\\)\-\-\-/s'      => "<del>$1</del>",
    ];

    $text = preg_replace(array_keys($pat), $pat, "\n".$text."\n");

    $clean = [
      '\*' => '*',
      '\+' => '+',
      '\_' => '_',
      '\`' => '`',
      '\^' => '^',
      '\>' => '&gt;',
      '\-' => '-',
      '\~' => '~',
      "\'" => "'",
      '\>' => '>',
      '\=' => '=',
      '\[' => '[',
      '\{' => '{',
    ];

    $text = str_replace(array_keys($clean), $clean, $text);

    return $text;
  }

  // ---------------------------------------------------------------------------

  function eval_function($function) {
    if ($function == "last-update") {
      return $this->last_update();
    }
  }

  // ---------------------------------------------------------------------------

  function last_update() {
    return date ("F d, Y - h:iA T(\G\M\TP)", filemtime($this->pages_path.$this->current_page.".php"));
  }

}

?>
