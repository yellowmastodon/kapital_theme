<? add_filter('pre_set_site_transient_update_themes', 'automatic_GitHub_updates', 100, 1);
function automatic_GitHub_updates($data) {
  // Theme information
  $theme   = get_stylesheet(); // Folder name of the current theme
  $current = wp_get_theme()->get('Version'); // Get the version of the current theme
  // GitHub information
  $user = 'YOUR USERNAME'; // The GitHub username hosting the repository
  $repo = 'YOUR-REPO-NAME'; // Repository name as it appears in the URL
  // Get the latest release tag from the repository. The User-Agent header must be sent, as per
  // GitHub's API documentation: https://developer.github.com/v3/#user-agent-required
  $file = @json_decode(@file_get_contents('https://api.github.com/repos/'.$user.'/'.$repo.'/releases/latest', false,
      stream_context_create(['http' => ['header' => "User-Agent: ".$user."\r\n"]])
  ));
  if($file) {
	$update = filter_var($file->tag_name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    // Only return a response if the new version number is higher than the current version
    if($update > $current) {
  	  $data->response[$theme] = array(
	      'theme'       => $theme,
	      // Strip the version number of any non-alpha characters (excluding the period)
	      // This way you can still use tags like v1.1 or ver1.1 if desired
	      'new_version' => $update,
	      'url'         => 'https://github.com/'.$user.'/'.$repo,
	      'package'     => $file->assets[0]->browser_download_url,
      );
    }
  }
  return $data;
}