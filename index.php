<?php 
	session_start();
	require "facebook-php-sdk-v4-4.0-dev/autoload.php";
	
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\GraphUser;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookRequest;
	
	const APPID = "874994439225530";
	const APPSECRET = "3965665bc69e63167afb73e24ea3da6a";
	FacebookSession::setDefaultApplication(APPID, APPSECRET);
	
	$helper = new FacebookRedirectLoginHelper('https://projetesgi9.herokuapp.com/');
	if (isset($_SESSION) && isset($_SESSION['fb_token'])){
		$session = new FacebookSession($_SESSION['fb_token']);
	} else {
		$session = $helper->getSessionFromRedirect();
	}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hello</title>
    <script>
	  window.fbAsyncInit = function() {
		FB.init({
		  appId      : '<?php echo APPID; ?>',
		  xfbml      : true,
		  version    : 'v2.3'
		});
	  };
	
	  (function(d, s, id){
		 var js, fjs = d.getElementsByTagName(s)[0];
		 if (d.getElementById(id)) {return;}
		 js = d.createElement(s); js.id = id;
		 js.src = "//connect.facebook.net/fr_FR/sdk.js";
		 fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>
</head>

<body>
	<div
      class="fb-like"
      data-share="true"
      data-width="850"
      data-show-faces="true">
    </div>
    <hr>
    <?php
		$loginUrl = $helper->getLoginUrl();

		if ($session) {
			try {
				$user_profile = (new FacebookRequest(
					$session, 'GET', '/me'
				))->execute()->getGraphObject(GraphUser::className());
				echo "Name : ".$user_profile->getName();
			} catch(FacebookRequestException $e) {
				echo "Exception occured, code : ".$e->getCode();
				echo " with message : ".$e->getMessage();
			}
		} else {
			echo "Not connected. Please <a href=".$loginUrl.">Se connecter</a>";
		}
	?>
</body>
</html>