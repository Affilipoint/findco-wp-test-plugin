# Find.co Article Voting Plugin

This plugin is part of the Senior WordPress Developer task for Find.co. The purpose of the plugin is to add an article rating system for single blog posts. The voting functionality should be at the bottom of the articles and users can either vote up or down for each article. Once the user submits their vote, the results are displayed to the user as a percentage average.


# Installation

To install this plugin:

1. Always make a backup for your content!
2. Download the plugin from [the repository](https://)
3. Upload the plugin to the **/wp-content/plugins/** directory via FTP or WP Admin
4. Go to "Plugins" in your WordPress admin, then click "Activate" next to the plugin name
5. The plugin will now be active and the vote buttons will appear at the bottom of all post articles

![Plugin Installation](https://i.imgur.com/Pe92cIZ.png)

# Configure
Upon activation, the plugin is configured with some default options. To change the settings, follow these steps:

1. Go to "Settings -> Find.co Voting" in your WordPress admin
2. Update the configration as required
3. Click on "Save Changes" to save your configuration

>Note: If you wish to delete all data related to this plugin when uninstalling the plugin, check the "Delete voting data on uninstall" checkbox.

![Settings Menu](https://i.imgur.com/yWcg0BZ.png)
![Configuration Options](https://i.imgur.com/4ZjyLZ1.png)

# How to use

To vote on articles, visit any blog articles page, scroll to the bottom of the articles. You should see the feedback buttons.

![Voting Buttons](https://i.imgur.com/FSsLhVp.png)

After voting you will see the average score for the article.

![Voting Results](https://i.imgur.com/RCl58l8.png)

## WordPress Admin Post Metabox

You can also view the results of the feedback as rated by users in the WordPress admin. Go to edit an article, and you will see the ratings for the article in the meta box

![Voting Results Metabox](https://i.imgur.com/ubCm5xm.png)

# Developer Notes

Below is an outline of the plugin files, thought process and decisions regarding the implementation of this plugin.

### CSS and Js are enqueued inline

The reason why the CSS and Js are enqueued inline:
- Limit the number of network request
- Limit render blocking resources (FID,CLS)
- Works well with small scripts/styles
- It's enqueued in the footer as the voting feature is below the fold and it's not criticall css/js
- CSS/Js are minified to reduce the bytes to load

### Class names and PSR-4 autoloading

The class names do not confirm to WP coding standards because it would not work with PSR-4 autoloading. I would have to include the files manually. Bit of a trade-off here when it comes to coding standards

### Uninstall plugin

Added an uninstall plugin hook that deletes the data created by the plugin on uninstall. The admin user has the option to keep the data or delete it automatically on plugin uninstallation

