<?php
namespace AMZNPP;

/*
  Admin Class

  Icons : http://www.iconarchive.com/show/100-flat-icons-by-graphicloads.html
*/
load_template(dirname( __FILE__ ) . '/HeyPublisher/Base.class.php');
class APP_Admin extends \HeyPublisher\Base {

  var $help = false;
  var $options = array();
  var $donate_link = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y8SL68GN5J2PL';
  // default settings to prevent plugin from breaking when no value provided.
  var $defaults = array('tag' => 'ASIN', 'aff_id' => 'amznpp-20', 'aff_cc' => 'com');

  public function __construct() {
    parent::__construct();
    $this->options = get_option(AMZNPP_PLUGIN_OPTTIONS);
    $this->log(sprintf("in constructor\nopts = %s",print_r($this->options,true)));
    $this->check_plugin_version();
    $this->slug = AMZNPP_ADMIN_PAGE;
    // Sidebar configs
    $this->plugin['home'] = 'https://wordpress.org/plugins/amazon-post-purchase/';
    $this->plugin['support'] = 'https://wordpress.org/support/plugin/amazon-post-purchase';
    $this->plugin['contact'] = 'mailto:wordpress@heypublisher.com';
  }

  public function __destruct() {
    parent::__destruct();
    // nothing to see yet
  }

  public function activate_plugin() {
    $this->log("in the activate_plugin()");
    // $this->check_plugin_version();
  }
  public function deactivate_plugin() {
    $this->log("in the deactivate_plugin()");
    $this->options = false;
    delete_option(AMZNPP_PLUGIN_OPTTIONS);  // remove the default options
	  return;
  }

  private function plugin_admin_url() {
    $url = 'options-general.php?page='.AMZNPP_ADMIN_PAGE;
    return $url;
  }
  // Filter for creating the link to settings
  public function plugin_filter() {
    return sprintf('plugin_action_links_%s',AMZNPP_PLUGIN_FILE);
  }
  // Called by plugin filter to create the link to settings
  public function plugin_link($links) {
    $url = $this->plugin_admin_url();
    $settings = '<a href="'. $url . '">'.__("Settings", "sgw").'</a>';
    array_unshift($links, $settings);  // push to left side
    return $links;
  }

  public function register_admin_page() {
    $this->log("in the register_admin_page()");
    // ensure our js and style sheet only get loaded on our admin page
    $this->help = add_options_page('Amazon Post Purchase', 'Amazon Post Pur...', 'manage_options', AMZNPP_ADMIN_PAGE, array(&$this,'action_handler'));
    add_action("admin_print_scripts-". $this->help, array(&$this,'admin_js'));
    add_action("admin_print_styles-". $this->help, array(&$this,'admin_stylesheet') );
  }
  function admin_js() {
    $this->log("in the admin_js()");
    wp_enqueue_script('amznpp', plugins_url($this->slug . '/include/js/amznpp.js'), array('jquery'));
  }
  function admin_stylesheet() {
    $this->log("in the admin_stylesheet()");
    wp_register_style( 'amznpp-heypublisher', plugins_url($this->slug . '/include/css/heypublisher.css' ) );
    wp_register_style( 'amznpp-admin', plugins_url($this->slug . '/include/css/amznpp_admin.css' ), array('amznpp-heypublisher') );
    wp_enqueue_style('amznpp-heypublisher');
    wp_enqueue_style('amznpp-admin');
  }
  // Primary action handler for page
  function action_handler() {
    parent::page('Amazon Post Purchase Settings', '', array($this,'content'));
  }

  public function content() {
    $html = '';
    if (is_user_logged_in() && is_admin() ){
      $this->log("config screen settings");
      $this->log(sprintf("POST = %s",print_r($_POST,1)));
      // update then refetch
      $message = $this->update_options($_POST);
      $opts = get_option(AMZNPP_PLUGIN_OPTTIONS)[options];
      $aff_id = $opts[aff_id];
      // if ($aff_id == $this->defaults['aff_id']) { $aff_id = ''; }  // don't display default

      if ($message) {
        printf('<div id="message" class="updated fade"><p>%s</p></div>',$message);
      } elseif ($this->error) { // reload the form post in this form
        // set the defaults
        // $opts['default'] =  $_POST['AMZNPP_opt']['default'];
        // // restructure the posts hash
        // foreach ($posts as $x=>$hash) {
        //   $id = $hash['ID'];
        //   if (isset($_POST['AMZNPP_opt']['posts'][$id])) {
        //     $hash['meta_value'] = $_POST['AMZNPP_opt']['posts'][$id];
        //     $posts[$x] = $hash;
        //   }
        // }
      }

      $nonce = wp_nonce_field(AMZNPP_ADMIN_PAGE_NONCE);
      $action = $this->form_action();
      $countries = $this->supported_countries();
      $select= '';
      foreach ($countries as $key=>$val) {
        $sel = '';
        if ($opts['aff_cc']==$key) { $sel = 'selected="selected"'; }
        $select .= sprintf("<option value='%s' %s>%s</option>",$key,$sel,$val);
      }

      $html =<<<EOF
        <form method="post" action="{$action}">
          {$nonce}
				  <h2>Add the widget to your side-bar after configuring your settings below.</h2>
          <ul>
          <li>
            <label class='amznpp_label' for='amznpp_aff_cc'>Affiliate Country:</label>
            <select name="amznpp_opt[aff_cc]" id="amznpp_aff_cc" class='amznpp_input'>
            {$select}
            </select>
            <a id='amznpp_domain' class='amznpp' href='#' title='Signup for an Amazon Affiliate account' target='_blank'>
            <span class="dashicons dashicons-external"></span>
            </a>
            <br/>
            <small class="amznpp_small">* Prices will be displayed in the default currency of this store.</small>
          </li>
          <li>
            <label class='amznpp_label' for='amznpp_aff_id'>Amazon Affiliate ID:</label>
            <input type="text" name="amznpp_opt[aff_id]" id="amznpp_aff_id" class='amznpp_input' value="{$aff_id}" />
          </li>
          <li>
            <label class="amznpp_label" for='amznpp_tag'>Custom Field Name:</label>
            <input type="text" name="amznpp_opt[tag]" id="amznpp_tag" class='amznpp_input' value="{$opts['tag']}" />
            <br/>
            <SMALL class="amznpp_small">* The POST custom field name where ASINs will be stored.</SMALL>
          </li>
          </ul>
          <input type="hidden" name="save_settings" value="1" />
          <input type="submit" class="button-primary" name="save_button" value="Update Settings" />
        </form>
EOF;
    } // end conditional '
    return $html;
  }

  public function update_options($form) {
    $message = null;
    if(isset($_POST['save_settings'])) {
      check_admin_referer(AMZNPP_ADMIN_PAGE_NONCE);
      if (isset($_POST['amznpp_opt'])) {
        $message = 'Your updates have been saved.';
        $opts = $_POST['amznpp_opt'];
        // biz rule, if aff_id is blank, set country to 'com'
        // if tag is blank, set to default
        if ($opts[aff_id] && $opts[aff_cc]) {
          $this->options[options][aff_id] = $opts[aff_id];
          $this->options[options][aff_cc] = $opts[aff_cc];
        } else {
          $this->options[options][aff_id] = $this->defaults[aff_id];
          $this->options[options][aff_cc] = $this->defaults[aff_cc];
        }
        if ($opts[tag]) {
          $this->options[options][tag]    = $opts[tag];
        } else {
          $this->options[options][tag]    = $this->defaults[tag];
          $message = "Custom field was not set - using default of: {$this->defaults[tag]}";
        }
        update_option(AMZNPP_PLUGIN_OPTTIONS,$this->options);
      }
      return $message;
    }
  }
  /*
    Private Functions
  */
  private function check_plugin_version() {
    $opts = $this->options;
    $this->log(sprintf("in check_plugin_version()\nPLUGIN VERSION = %s\nopts = %s",AMZNPP_PLUGIN_VERSION,print_r($opts,1)));
    if (!$opts || !$opts[plugin] || $opts[plugin][version_current] == false) {
      $this->log("no old version - initializing");
      $this->init_plugin();
      return;
    }
    // check for upgrade option here
    if ($opts[plugin][version_current] != AMZNPP_PLUGIN_VERSION) {
      $this->log("need to upgrade version");
      $this->upgrade_plugin($opts);
      return;
    }
    $this->log('-Returning from check_plugin_version()');
  }
  private function get_version_as_int($str) {
    $var = intval(preg_replace("/[^0-9 ]/", '', $str));
    return $var;
  }
  private function init_install_options() {
    $this->options = array(
      'plugin' => array(
        'version_last'    => AMZNPP_PLUGIN_VERSION,
        'version_current' => AMZNPP_PLUGIN_VERSION,
        'install_date'    => Date('Y-m-d'),
        'upgrade_date'    => Date('Y-m-d')
      ),
      'options' => $this->defaults
    );
    return;
  }
  private function init_plugin() {
    $this->init_install_options();
    add_option(AMZNPP_PLUGIN_OPTTIONS,$this->options);
    return;
  }
  private function supported_countries() {
    $countries = array(
      'ca' => 'Canada (amazon.ca)',
      'fr' => 'France (amazon.fr)',
      'de' => 'Germany (amazon.de)',
      'it' => 'Italy (amazon.it)',
      'es' => 'Spain (amazon.es)',
      'co.uk' => 'United Kingdon (amazon.co.uk)',
      'com' => 'United States (amazon.com)'
    );
    return $countries;
  }
  private function upgrade_plugin($opts) {
    $ver = $this->get_version_as_int($this->options['plugin']['version_current']);
    $this->log("Version = $ver");
    if ($ver < 200) {
      $widget_obj = new AmazonPostPurchase; // we need to reference old settings from widget config and migrate to new plugin opts
      // need to migrate the settings from widget to options
      $instance = $widget_obj->get_settings();
      $this->log(sprintf("widget settings = %s",print_r($instance,1)));
      foreach($instance as $key => $val) {
        if($val && $val[affiliate] && $val[asin_tag]) {
          // we have a match
          $this->options[options][tag] = $val[asin_tag];
          $this->options[options][aff_id] = $val[affiliate];
          $this->options[options][aff_cc] = 'com';  // this wasn't set before - so assume US
          break;
        }
      }
    }
    $this->options[plugin][version_last] = $this->options[plugin][version_current];
    $this->options[plugin][version_current] = AMZNPP_PLUGIN_VERSION;
    $this->options[plugin][upgrade_date] = Date('Y-m-d');
    $this->log(sprintf("upgrading plugin with opts %s",print_r($this->options,1)));
    update_option(AMZNPP_PLUGIN_OPTTIONS,$this->options);
  }
}
?>
