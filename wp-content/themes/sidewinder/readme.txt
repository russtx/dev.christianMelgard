### About ###

Sidewinder is a horizontal side-scrolling photo theme perfect for creating beautiful photo portfolio websites. 

**NOTE: Sidewinder is a child theme for Base, a theme framework for WordPress. You must have Base installed for Sidewinder to work.**


### Installation ###

1. Download the zip file from your [members dashboard](https://graphpaperpress.com/dashboard/). This will always be the most current version of the theme.
2. Log in to your WordPress dashboard. This can be found at yourdomain.com/wp-admin
3. Go to Appearance &gt; Themes and click on the *Install Themes* tab
4. Click on the *Upload* link
5. Upload the zip file that you downloaded from your members dashboard and click *Install Now*
6. Click *Activate* to use the theme you just installed.

![installing your Graph Paper Press theme](http://graphpaperpress.s3.amazonaws.com/images/instructions/install_themes.png)

For more details about installing your themes, please view [Installing Your Theme](http://graphpaperpress.com/support/installing-your-theme/)

#### Recommended Plugin Configuration ####

* Disable all lightbox/slideshow/gallery plugins, including the GPP Slideshow Plugin. This theme already includes a slideshow script, so using another slideshow plugin will cause a conflict.
* GPP Image Download Buy Links Plugin. This plugin allows you to offer a Download option for your slideshow images. Download from here: [http://graphpaperpress.com/plugins/gpp-image-download-buy-links-plugin](http://graphpaperpress.com/plugins/gpp-image-download-buy-links-plugin).
* GPP Base Hook Widgets. This plugin adds 12 new widget areas to the Base WordPress theme framework using its action hooks. Download from [http://graphpaperpress.com/plugins/base-hook-widgets/](http://graphpaperpress.com/plugins/base-hook-widgets/)
* GPP Shortcodes Plugin. This plugin allows you to use a selection of shortcodes to add new styles to your site, such as columns, buttons and boxes. Click here for [shortcode instructions](http://demo.graphpaperpress.com/emporia/shortcodes/).


### Media Settings ###

This theme sets the media sizes automatically. You can review these sizes in Settings &gt; Media. The default sizes for this theme are:

* Thumbnail size
	* Width: 150
	* Height: 150
	*[checked] Crop thumbnails to exact dimensions (normally thumbnails are proportional)
* Medium size
	* Max Width: 620
	* Max Height: 0
* Large size
	* Max Width: 0
	* Max Height: 500
* Embeds
	* [checked] When possible, embed the media content from a URL directly onto the page. For example: links to Flickr and YouTube.
	* Maximum embed size
		* Width: 940
		* Height: 0

*Please Note: If you are switching from another theme, you will want to install and run the [Regenerate Thumbnails](http://wordpress.org/extend/plugins/regenerate-thumbnails/) WordPress plugin to resize your existing images.*


### Theme Customizer ###

With the Theme Customizer, you can set your title and tagline, set a background image, assign your menus, and choose a static home page. You can preview your changes by clicking the Customize link below your active theme on your Appearance &gt; Themes page.

*Please note: Setting a static home page will remove the default home page elements built into the theme. You must keep this set to* Display Latest Posts *to display the homepage slideshow.*


### Theme Options ###

Go to Appearance &gt; Theme Options to set up your theme, upload a logo and favicon, choose your fonts, set a color scheme, set a blog category, set up your homepage design, and add custom CSS. Styles added here will not be deleted when you update your theme.

CSS creates the style of your site. For example, to hide the description of your site, simply paste this code into the custom CSS box:

`#site-description { display: none; }`.


### Homepage Options ###

You can choose to display a gallery of featured images from your latest posts or your latest galleries or all of the images in a single gallery. You *must* have at least one gallery created and have a featured image assigned to it before the Single Gallery option will appear. You can set this in your Theme Options.

#### Choose a Single Gallery for your Homepage ####

* Go to Gallery &gt; Add New to add a gallery. Upload your photos and save the Gallery page.
* Assign a featured image to the gallery.
* Go to Appearance &gt; Theme Options &gt; Homepage Design and select *Single Gallery* from the Dropdown list.
* Choose the gallery you want to display from the Dropdown list.
* Save your changes.

#### Enable Sidebar on inside Pages ####

Only posts in the category you have set as the blog category in your Theme Options are able to display the sidebar. To add a sidebar to these posts, add content to the Sidebar widget area in Appearance > Widgets.

#### Add a Blog Page ####

You may also want to create a Blog page to display all of your blog posts on your site. To do this, you can create a page called Blog and assign it to the Blog page template. All of your posts will appear on this page.

*Please Note: Do* not *set this page as the page to display your blog posts in Settings > Reading or in the Theme Customizer as this will break the page template's code and your posts will not appear.*


### Widgets ###

This theme supports widgetized areas. For more detail about adding widgets to your site, please read [Adding Widgets](http://graphpaperpress.com/support/using-widgets/).


### Menus ###

Our themes use WordPress’s custom menus option. These can be created in Appearance > Menus. To add a new menu to your site:

1. Go to Appearance > Menus.
2. Create a new menu item by clicking the + tab.
3. Select the pages you want to display in your menu and click the Add to Menu button. If you do not see the type of page (category, tag, portfolio, gallery, etc) you want to display, click the Screen Options link at the top of the page and make sure the page type is checked.
4. Once you have set your menu as you want it, click the Save Menu button.
5. Then, assign that menu to your desired theme location to ensure your menu appears where you want it and click Save.

![Add a Custom Menu](http://graphpaperpress.s3.amazonaws.com/images/instructions/custom_menu.jpg)


### Always Set Featured Images ###

This theme relies heavily on Featured Images. If your post is missing a Featured Image, the post may not appear on the homepage or on archive pages. 

To choose the image you want to set as a featured image for this post and click the *Set as Featured Image* button. For best results use images that are at least 665 px wide.

![Add a Featured Image](http://graphpaperpress.s3.amazonaws.com/images/instructions/featured_image.png)


### Galleries ###

Sidewinder supports an additional post type for your Galleries. To add new galleries items, go to the Galleries section in your Dashboard. For best results, upload images that are at least 500 px high. Be sure to add a featured image to your galleries so they display correctly on the homepage and Collections pages.

Once you have created more than one gallery, you can assign them to one or more Collections. Collections work like categories, and let you display related galleries on a Collections page.

To insert a gallery:

1. Select the Gallery post format.
2. Click the Add Media button to launch the Media Uploader tool.
3. Click the Create Gallery option.
4. You can choose to upload images from your computer or you can use images that already exist in your Media Library. You cannot use an image from a URL on the web in your gallery.
5. If you are uploading images, click the Select Files button and navigate to each of your images on your computer. Click the Open button to open each image.
6. Once each of your images has been uploaded, you will have the option to add a title, caption, alternative text and description.
7. After you have added all of the images you wish to display in the gallery, switch to your media library tab and select those images.
8. Then, click the Create a New Gallery button.
9. Set a featured image for your Gallery.

![Insert a Gallery](http://graphpaperpress.s3.amazonaws.com/images/instructions/insert_gallery.png)

Galleries inserted into the Galleries option and posts will display as a fullscreen slider. Galleries inserted into pages will display as a grid of thumbnails, depending on the settings you choose when you create your gallery.


### Page Templates ###

This theme provides four page templates: Default, Blog, Archive, and Wide Page.

1. The Default page template is the standard page layout, and will display the Sidebar if you have it activated in your widgets area.
2. The Blog page template will display all of your blog posts on this page. You can determine how many posts will appear on each page before the 'Older Entries' link in Settings &gt; Reading, by setting a value for 'Blog Pages Display at Most'.
3. The Archve page template displays a sortable list of all of the posts on your site.
4. The Wide page template removes the Sidebar, even if it is set in the widgets area, and stretches your content to the full-width of the page.


### Embed Multimedia into Posts or Pages ###

#### Externally hosted Video ####

For externally hosted videos (for example a YouTube or Vimeo video), you can directly paste the link of your video page into the content editor. You do not have to paste the embed code. WordPress will automatically embed the video from the link.

You can easily embed videos from a Video hosting service such as Vimeo or YouTube into your posts or pages.

To add a video:

1. From your WordPress dashboard, add a new post or page (or edit an existing post or page).
2. Paste in your video’s URL, for example https://vimeo.com/31985752.
3. Publish or Update your post or page.

*Please note: If your video is not appearing correctly, remove the 's' from the URL, so https becomes http.*

#### Self-hosted Video ####

If you want to self-host your own videos, you can use the built-in FLV video player. Self-hosting your own videos is more complex, and requires some knowledge of file compression, codecs, using custom fields, CDNs, and video file streaming.

To add a video to a Post or Page, create a custom field called `video` and add the complete path your video's file in the field's value box. The combination wil appear like this:

`video | http://your-domain.com/path/to/your/video/file.flv`

To add a thumbnail to your video player, create a custom field called `video-thumb` and add the complete path to your thumbnail image in the field's value box. The combination will appear like this:

`video-thumb | http://your-domain.com/path/to/your/video/thumbnail.jpg`

If you wish to add multiple videos, enter one custom field for each video and thumbnail. For example:

* `video | http://your-domain.com/path/to/your/video/file.flv`
* `video-thumb | http://your-domain.com/path/to/your/video/thumbnail.jpg`
* `video | http://your-domain.com/path/to/your/video/file-2.flv`
* `video-thumb | http://your-domain.com/path/to/your/video/thumbnail-2.jpg`

We do not recommend streaming large files (videos, photos, audio, etc.) from the same server that hosts your website. We recommend using a file-streaming server or integrating with a third-party provider, such as Amazon Web Services.

To display mobile-friendly video files to users with Flash either disabled or not available, first enable the Mobile Video option on the Theme Options page. Then, follow these instructions:

1. Compress your video file into one of the recommended mobile-friendly video formats.
2. Upload the file to your server using your favorite method. Use FTP for large files. Use WordPress's built-in media uploader tool for small files.
3. Copy and paste the file's URL into a custom field called iphone.
4. If you haven't done so already, add a video thumbnail. You can do this the same way that you added regular thumbnails, except you will want to add an image large enough to fit the maximum size of the video player. If you have the sidebar enabled, use the 620px wide image. For sites with sidebars disabled, use the 940px wide image. Add the video thumbnail to a custom field called video-thumb.


### Installation Troubleshooting ###
 
If you've performed a clean install of the theme and are still having issues, check the following recommendations:
* Ensure you are using the latest versions of both Sidewinder and Base.
* Ensure your file permissions are set correctly. On most servers, the theme files permissions should be set to 644 and folders should be set to 755.
* Ensure your theme folder is named `sidewinder`, with no extra spaces, characters, or uppercase letters. Also ensure that there is not a second folder called `sidewinder` inside the first.
* Ensure that you have also installed the Base theme, and that the theme folder is named `base` with  no extra spaces, characters, or uppercase letters. Also ensure that there is  not a second folder called `base` inside the first.
* Deactivate any other lightbox/slideshow/gallery plugins as these will conflict with the recommended GPP Slideshow plugin.
* Sidewinder uses jQuery for much of its functionality. If your theme appears broken or unresponsive, you likely have a JavaScript conflict with one of your plugins. Deactivate **all** of your plugins. If that resolves the issue, reactivate them one at a time until you find the one causing the conflict.

### Theme Internationalization ###

Sidewinder is currently only available in English (US). It contains a default.pot file which you can use to translate to any other language you want.  See [WordPress in Your Language](http://codex.wordpress.org/WordPress_in_Your_Language) for more information about translating your version of Sidewinder into another language.