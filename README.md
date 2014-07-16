#Carob Framework
A WordPress framework for premium themes.

![Carob WordPress Framework](https://raw.githubusercontent.com/ydimitrov/Carob-Starter-Theme/master/images/carob-framework.png)

###Starter Theme
Go ahead and download the starter theme from here: [Carob Framework Starter Theme](https://github.com/ydimitrov/Carob-Framework-Starter-Theme). In the starter theme pacakge you will find an example usage of the framework. Inluding registering a custom post type, taxonomy, meta boxes, theme options page and more.

## Table Of Contents
* [1. Options](#1-options)
	* [1.1 Options Format](#11-options-format)
	* [1.2 Included Options](#12-included-options)
		* [1.2.1 Heading](#121-heading)
		* [1.2.2 Text](#122-text)
		* [1.2.3 Textarea](#123-textarea)
		* [1.2.4 Checkbox](#124-checkbox)
		* [1.2.5 Radio](#125-radio)
		* [1.2.6 Select](#126-select)
		* [1.2.7 Checkboxes](#127-checkboxes)
		* [1.2.8 Editor](#128-editor)
		* [1.2.9 Slider Input](#129-slider-input)
		* [1.2.10 Color Picker](#1210-color-picker)
		* [1.2.11 Switch Toggle](#1211-switch-toggle)
		* [1.2.12 File](#1212-file)
		* [1.2.13 Gallery](#1213-gallery)
		* [1.2.14 Select Image Option](#1214-select-image-option)
		* [1.2.15 Icon Picker](#1215-icon-picker)
		* [1.2.16 Select Sidebar](#1216-select-sidebar)
	* [1.3 Custom Options](#13-custom-options)
		* [1.3.1 Custom Options JS](#131-custom-options-js)
* [2. Custom Post Types](#2-custom-post-types)
* [3. Meta Boxes](#3-meta-boxes)
* [4. Custom Sidebars](#4-custom-sidebars)
* [5. Shortcodes Picker](#5-shortcodes-picker)
	* [5.1 Shortcodes JS And CSS](#51-shortcodes-js-and-css)
* [6. Hooks](#6-hooks)
* [7. License](#7-license)

##1. Options
The Carob Framework comes with 16 options that you can use for your option pages or meta boxes. Those options include a standard set of option fields like text inputs, checkboxes, option selects and some more advanced options like image, file and gallery picker (using the WordPress media library), icon picker from icons font, switch toggle and more.

The best part is that you can register and use your own custom options. This way you are not limited with the usage only of the included ones.

Let's take a look at the Carob options class diagram (*Figure 1*)

![Options class diagram](https://raw.githubusercontent.com/ydimitrov/Carob-Framework-Starter-Theme/master/images/uml-options-and-validators.png "Figure 1. Options class diagram")

*Figure 1: Options class diagram*

On given single page you can have multiple instances of some option type, but the options are stateless, their resposibility is just to output the option content. This makes them a good candidate for using the [Flyweight](http://en.wikipedia.org/wiki/Flyweight_pattern) design pattern. Same goes for the option validators objects.

As you can see on the class diagram we have an options cache and a validators cache. The **Carob_Options_Factory** asks the **Carob_Options_Cache** object for a given option type. If the option is not stored in the cache the **Carob_Options_Cache** will create one, will store it and will return it. The same mechanism is used for the options validators.

###1.1 Options Format
To use an option you must to create an array with the following fields:

Field  | Required  | Description
-------|------ | -------------
title | Yes | The displayed option title text
id | Yes | An unique option id
desc | Yes | A description text displayed under the title
default | Yes with exceptions | A default option value (can be empty)
options | No | An optional field for additional option settings
class | Yes | A CSS class for option styling
type | Yes | An unique option type string

Here is an example:

```php
...
public function get_options() {

	$options = array();

	// Text
	$options[] = array(
		'title' => __( 'Text', 'carob-theme' ),
		'id' => 'carob_text_id',
		'desc' => __( 'Description text:', 'carob-theme' ),
		'default' => '',
		'class' => 'carob-input',
		'type' => 'text'
	);

	// Radio
	$options[] = array(
		'title' => __( 'Radio', 'carob-theme' ),
		'id' => 'carob_radio_id',
		'desc' => __( 'Description text:', 'carob-theme' ),
		'default' => 'one',
		'options' => array(
			array( 'value' => 'one', 'label' => __( 'One', 'carob-theme' ) ),
			array( 'value' => 'two', 'label' => __( 'Two', 'carob-theme' ) )
		),
		'class' => 'carob-radio',
		'type' => 'radio'
	);

	return $options;
}
...
```
Note: Some options may have additional fields. 

###1.2 Included Options
Now let's explore the included options and how to use them.

####1.2.1 Heading
Displays a heading text. This is the only option that does not require a <code>default</code> option value as it is used only to output text. In a case of page/theme options **heading** option is used to separate the theme options into sections of groups. You can find an example in the starter theme.

Example:

```php
$options[] = array(
	'title' => __( 'Post Formats Options', 'carob-theme' ),
	'id' => 'heading',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'type' => 'heading'
);
```

####1.2.2 Text
Displays a single line text input.

Example:

```php
$options[] = array(
	'title' => __( 'Text', 'carob-theme' ),
	'id' => 'carob_text_id',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => '',
	'class' => 'carob-input',
	'type' => 'text'
);
```

####1.2.3 Textarea
Displays a textarea input.

Example:

```php
$options[] = array(
	'title' => __( 'Textarea', 'carob-theme' ),
	'id' => 'carob_textarea',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => '',
	'rows' => 7,
	'class' => 'carob-input',
	'type' => 'textarea'
);
```

####1.2.4 Checkbox
Displays a checkbox input.

Example:

```php
$options[] = array(
	'title' => __( 'Checkbox', 'carob-theme' ),
	'id' => 'carob_checkbox',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => 'off',
	'label' => __( 'Label text', 'carob-theme' ),
	'class' => 'carob-checkbox',
	'type' => 'checkbox'
);
```
If you want the default value to be checked set the <code>default</code> value to <code>on</code>

####1.2.5 Radio
Displays a radio input options.

Example:

```php
$options[] = array(
	'title' => __( 'Radio', 'carob-theme' ),
	'id' => 'carob_radio',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => 'one',
	'options' => array(
		array( 'value' => 'one', 'label' => __( 'One', 'carob-theme' ) ),
		array( 'value' => 'two', 'label' => __( 'Two', 'carob-theme' ) )
	),
	'class' => 'carob-radio',
	'type' => 'radio'
);
```

####1.2.6 Select
Displays a select option input.

Example:

```php
$options[] = array(
	'title' => __( 'Select', 'carob-theme' ),
	'id' => 'carob_select',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => 'one',
	'options' => array(
		array( 'value' => 'one', 'label' => __( 'Option One', 'carob-theme' ) ),
		array( 'value' => 'two', 'label' => __( 'Option Two', 'carob-theme' ) )
	),
	'class' => 'carob-select',
	'type' => 'select'
);
```

####1.2.7 Checkboxes
Displays a set of checkbox inputs.

Example:

```php
$options[] = array(
	'title' => __( 'Checkboxes', 'carob-theme' ),
	'id' => 'carob_checkboxes',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => array('one', 'four'),
	'options' => array(
		array( 'value' => 'one', 'label' => __( 'One', 'carob-theme' ) ),
		array( 'value' => 'two', 'label' => __( 'Two', 'carob-theme' ) ),
		array( 'value' => 'three', 'label' => __( 'Three', 'carob-theme' ) ),
		array( 'value' => 'four', 'label' => __( 'Four', 'carob-theme' ) )
	),
	'class' => 'carob-checkbox',
	'type' => 'checkboxes'
);
```

####1.2.8 Editor
Displays the WordPress editor.

Example:

```php
$options[] = array(
	'title' => __( 'Editor', 'carob-theme' ),
	'id' => 'carob_editor',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => 'Some default content',
	'options' => array(),
	'class' => 'carob-editor',
	'type' => 'editor'
);
```

####1.2.9 Slider Input
Displays a slider input with min and max range.

Example:

```php
$options[] = array(
	'title' => __( 'Slider Input', 'carob-theme' ),
	'id' => 'carob_slider_input',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => 10,
	'options' => array(
		'min' => 1,
		'max' => 100,
		'step' => 1
	),
	'class' => 'carob-ui-slider-field',
	'type' => 'slider_input'
);
```

####1.2.10 Color Picker
Displays a color picker input.

Example:

```php
$options[] = array(
	'title' => __( 'Color Picker', 'carob-theme' ),
	'id' => 'carob_color_picker',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => '7cd3c6',
	'class' => 'carob-color-picker',
	'type' => 'color_picker'
);
```

####1.2.11 Switch Toggle
Displays a switch toggle.

Example:

```php
$options[] = array(
	'title' => __( 'Switch Toggle', 'carob-theme' ),
	'id' => 'carob_switch_toggle_option',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => 'on',
	'class' => 'carob-switch-toggle',
	'type' => 'switch_toggle'
);
```

####1.2.12 File
Displays an option to select/upload a file using the WordPress media library or to paste an direct URL to a file.

Example:

```php
$options[] = array(
	'title' => __( 'File (in this case an image file)', 'carob-theme' ),
	'id' => 'carob_image_file',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => array( 'id' => 0, 'url' => '' ),
	'options' => array(
		'type' => 'image',
		'button_title' => __( 'Select Image', 'carob-theme' ) 
	),
	'class' => 'carob-input--medium',
	'type' => 'file'
);
```
As you can see the option validator will save an array with the selected attachment ID and URL. If the attachment id is 0 the user have pasted an URL to a file otherwise use the attachment ID to work with the selected file.

You can use any of the supported by the WordPress media library file types:
*image,
*audio
*video

If you want to let your users to pick a document type file set the file type to empty string, like this:

```php
...
'options' => array(
	'type' => '',
	'button_title' => __( 'Select Document', 'carob-theme' ) 
),
...
```

####1.2.13 Gallery
Displays an option to select a set of images using the WordPress media library.

Example:

```php
$options[] = array(
	'title' => __( 'Gallery', 'carob-theme' ),
	'id' => 'carob_page_gallery',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => array(),
	'button_title' => __( 'Select Images', 'carob-theme' ), 
	'class' => 'carob-gallery',
	'type' => 'gallery'
);
```

The saved value contains an array with the selected attachments IDs like this: <code>array(10,22,34)</code>

####1.2.14 Select Image Option
Displays a set of images where user can click on an image to select it.

Example:

```php
$path = 'PATH_TO_IMAGES';
$blog_layouts = array(
	array( 'value' => 'standard', 'image' => $path . 'blog-standard.png' ),
	array( 'value' => 'masonry', 'image' => $path . 'blog-masonry.png' )
);

$options[] = array(
	'title' => __( 'Select Image Option', 'carob-theme' ),
	'id' => 'carob_blog_layout',
	'desc' => __( 'Select the blog layout:', 'carob-theme' ),
	'default' => 'standard',
	'options' => $blog_layouts,
	'class' => 'carob-select-image-option',
	'type' => 'select_image_option'
);

```

The images must be with the following dimensions: 120px by 80px 

####1.2.15 Icon Picker
Displays a list with icons from a given font icon. Users then can click on an icon to select it.

Example:

```php
$options[] = array(
	'title' => __( 'Icon Picker', 'carob-theme' ),
	'id' => 'carob_page_icon',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => 'fa-music',
	'class' => 'carob-font-icon-picker',
	'type' => 'icon_picker'
);

```
Note: Your theme must use the <code>carob_icon_font</code> filter hook to set the icon font. You can find an example in the starter theme.

####1.2.16 Select Sidebar
The custom sidebars extension registers this handy option which displays a select option input with the all custom and theme sidebars.

Example:
```php
$options[] = array(
	'title' => __( 'Select Sidebar', 'carob-theme' ),
	'id' => 'carob_page_sidebar',
	'desc' => __( 'Description text:', 'carob-theme' ),
	'default' => 'Blog Sidebar',
	'class' => 'carob-select',
	'type' => 'select_sidebar'
);
```
Note: Use the <code>carob_theme_sidebars</code> filter hook to register your theme sidebars if you wish to display them in the list of sidebars. An example you can find in the starter theme.

###1.3 Custom Options
You can register and use you own custom options. Here are the steps to accomplish that:

1. Make sure that your option class inherits from **Carob_Option**

2. Override the <code>display</code> method and inside it write the logic that will display the option content from a given option array and a saved value. Optionally you can call the <code>display_title</code> on the parent class to display the option title and description.

3. Obtain the singleton instance of **Carob_Options_Factory** using <code>Carob_Options_Factory::get_instance()</code> and call the <code>register_option</code> method like this:
```php
...
$my_option_type = 'my_option_type';
$my_option = array(
	'class' => 'My_Custom_Option_Class',
	'validator' => 'My_Custom_Option_Validator_Class'
);
$options_factory = Carob_Options_Factory::get_instance();
$options_facotory->register_option( $my_option_type, $my_option )
...
```
Note: Your custom option validator must implement the **Carob_Validatable** interface.

Now to use your custom option use the **my_option_type** as the type of your option array like this:
```php
...
$options = array();

$options[] = array(
	'title' => __( 'Title Text', 'textdomain' ),
	'id' => 'unique_option_id',
	'desc' => __( 'Description text:', 'textdomain' ),
	'default' => 'A default Value',
	'class' => 'my-css-class',
	'type' => 'my_option_type'
)

return $options;
...
```
###1.3.1 Custom Options JS
If you want to initialize your options with custom JS, listen to <code>Carob.eventDispatcher</code> for <code>carobInitOptions</code> and <code>carobDestroyOptions</code> events. As an argument you will recieve a jQuery object in which you need to find and init or destroy your options.

##2. Custom Post Types
The framework provides you with an easy way to create custom post types (CPTs) and taxonomies. Here is a basic example:

```php
function carob_register_custom_post_types( $post_types ) {

	$post_types['portfolio'] = array(
		'post_type' => 'portfolio',
		'options' => array( 'menu_icon' => 'dashicons-portfolio' ),
		'taxonomies' => array( 
			array(
				'name' => 'skills',
				'singular' => 'skill',
				'plural' => 'skills',
			)
		)
	);

	return $post_types;
}
add_filter( 'carob_post_types', 'carob_register_custom_post_types' );
```
Using the <code>carob_post_types</code> filter hook, we just registered an **Portfolio** post type with **Skills** taxonomy.

Here is the full format of a post type array:

```php
$post_types['portfolio'] = array(
	'post_type' => 'portfolio',
	'plural' => 'portfolios',
	'labels' => array(),
	'options' => array(),
	'taxonomies' => array( 
		array(
			'name' => 'skills',
			'singular' => 'skill',
			'plural' => 'skills',
			'labels' => array(),
			'options' => array()
		)
	)
);
```
##3. Meta Boxes
You can easly create custom meta boxes and assign them to custom or default post types. Also the framework will take care for saving the meta boxes options.

You have two ways to display content in a meta box:

1. Using the options included in the framework and your custom ones;
2. Custom content and a way to validate and save it;

On *Figure 2* you can see the meta boxes class diagram:

![Meta boxes class diagram](https://raw.githubusercontent.com/ydimitrov/Carob-Framework-Starter-Theme/master/images/uml-meta-box.png "Figure 2. Meta boxes class diagram")

*Figure 2: Meta boxes class diagram*

Follow these steps to create a meta box:

1. Make sure that your meta box class inherits from **Carob_Meta_Box**.

2. In your class constructor set the meta box id, title and optionally context and priority.

3. If you want to display a set ot options override the <code>get_options()</code> method and return an array with the meta box options.
Here is an example:
```php
class Carob_Title_Meta_Box extends Carob_Meta_Box {

	public function __construct() {

		$this->id = 'carob-title-meta-box';
		$this->title = __( 'Title Options', 'carob-theme' );
	}

	public function get_options() {

		$options = array();

		// Subtitle
		$options[] = array(
			'title' => __( 'Subtitle', 'carob-theme' ),
			'id' => 'carob_subtitle',
			'desc' => __( 'Enter here the page subtitle text:', 'carob-theme' ),
			'default' => '',
			'class' => 'carob-input',
			'type' => 'text'
		);

		return $options;
	}
}
```
4.If you want to display a custom content override the <code>has_custom_content()</code> method and return <code>true</code>. The <code>display_content()</code> method will be called for you to display the meta box content and the <code>custom_save()</code> on meta box save. You may also want to override those too.

Now that we created our first custom meta box, let's see how we can register and start using it.

Use the <code>carob_meta_boxes</code> filter hook to register your meta box like this:
```php
function carob_register_custom_meta_boxes( $meta_boxes ) {

	$meta_boxes['page_title'] = 'Carob_Title_Meta_Box';
	
	return $meta_boxes;
}
add_filter( 'carob_meta_boxes', 'carob_register_custom_meta_boxes' );
```

Then we need to assign the meta box to some post type. In the next example we will use the <code>carob_assign_meta_box</code> filter hook to assign the **Carob_Title_Meta_Box** to post and page post types:
```php
function carob_assign_meta_boxes( $post_types ) {

	$post_types['post'] = array( 'page_title' );
	$post_types['page'] = array( 'page_title' );

	return $post_types;
}
add_filter( 'carob_assign_meta_box', 'carob_assign_meta_boxes' );
```

##4. Custom Sidebars
The Carob Framework comes with a Custom Sidebars manager extension which let your users to create/delete custom sidebars (*Figure 3*). To view it navigate to Appearance > Sidebars. Nice!

![Custom Sidebars Manager](https://raw.githubusercontent.com/ydimitrov/Carob-Framework-Starter-Theme/master/images/custom-sidebars.png "Figure 3. Custom Sidebars Manager")

*Figure 3: The Custom Sidebars Manager*

##5. Shortcodes Picker
The framework include a visual shortcodes picker for your users to use. It is displayed as an icon in the WordPress editor and when you click on it a nice list of your shortcodes will show up. Click on a shortcode to insert it and if it has options they will be displayed, so you don't have to remember all shortcode parameters (*Figure 4*).

As you may guess you can register your own shortcodes.

![Shortcodes Picker](https://raw.githubusercontent.com/ydimitrov/Carob-Framework-Starter-Theme/master/images/shortcodes-picker.png "Figure 4. Shortcodes Picker")

*Figure 4: The Shortcodes Picker*

As you can see on the *Figure 5* the shortcodes picker also uses the options factory object to represent the shortcodes options.

###Note: Not all options will work in the shortcodes picker.

![Shortcodes Picker class diagram](https://raw.githubusercontent.com/ydimitrov/Carob-Framework-Starter-Theme/master/images/uml-shortcodes-picker.png "Figure 5. Shortcodes Picker class diagram")

*Figure 5: The Shortcodes Picker class diagram*

Yoy may wonder how to register your own shortcode? Here is how:

1. Make sure that your class inherits from the **Carob_Shortcode** class;

2. In your class constructor method set the following fields:

|Field name | Description |
------------|----------------
name | Your shortcode name like **my_shortcode**
title | Displayed in the shortcodes picker below the shortcode icon
icon | Path to the shortcode icon displayed in the list of shortcodes 50x50px
has_content | If set to **true** the picker will automatically add a textarea option for the shortcode content

3 . Call <code>parent::register()</code> to register the shortcode

4 . If you want your shortcode to have options override the <code>get_options</code> method and return an array with options.

5 . Override the <code>display</code> method and return your shortcode content like you are used to.

Use the <code>carob_shortcodes</code> filter hook to register your shortcodes into the Shortcodes Picker :

```php
function carob_register_my_shortcodes( $shortcodes ) {
	
	$shortcodes[] = 'My_Shortcode_Class_Name';

	return $shortcodes;	
}
add_filter( 'carob_shortcodes', 'carob_register_my_shortcodes' );
```

###5.1 Shortcodes JS And CSS
By default the framework will load the shortcodes JS and CSS files. If you want to disable it and instead provide the files from your theme use the <code>carob_shortcodes_load_frontend</code> filter hook and return <code>false</code>.

##6. Hooks
Here is a table with all action and filter hooks:

Name | Type | Description
-----|------|-------------
carob_icon_font | filter | Use to register your icon font
carob_post_types | filter | Use to register your custom post types
carob_meta_boxes | filter | Use to register your meta boxes
carob_assign_meta_box | filter | Use to assing a meta box to a post type
carob_theme_sidebars | filter | Use to register your theme sidebars
carob_sidebars_options | fitler | Use to set the widgets options like *before_widget* and *after_widget* (return an array with options)
carob_shortcodes_load_frontend | filter | Return *false* to disable the loading of the shortcodes JS and CSS
carob_shortcodes | filter | Use to register your custom shortcodes


##7. License
Carob Framework is released under the MIT license. See the LICENSE.txt file for more info.
