<?php
/**
Plugin Name: Webonisers
Plugin URI: http://wordpress.opensourcedevelopers.net/downloads/
Description: A simple plugin to upload any type of image in wordpress. We can use it to manage webonisers section.
Author: Sagar Shirsath
Version: 1.1
Author URI: http://opensourcedevelopers.net/
 */

define('TXTFOLDER', get_bloginfo('wpurl') . "/wp-content/plugins/webonisers/txtfiles");

function webonisers_install()
{
    if (!file_exists(TXTFOLDER)) {
        mkdir(TXTFOLDER, 0777);
    }
}

register_activation_hook(__FILE__, 'webonisers_install');

function webonisers_create_table()
{
    // do NOT forget this global
    //mkdir("custom_upload_folder",0777);
    global $wpdb;

    // this if statement makes sure that the table doe not exist already
    if ($wpdb->get_var("show tables like webonisers") != 'webonisers') {

        $sql2 = "CREATE TABLE IF NOT EXISTS `webonisers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
   `slug` varchar(222) NOT NULL,
  `designation` varchar(222) NOT NULL,
  `facebook_name` varchar(222) NOT NULL,
  `twitter_name` varchar(222) NOT NULL,
  `linkedin_name` varchar(222) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(222) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql2);
    }

}

// this hook will cause our creation function to run when the plugin is activated
register_activation_hook(__FILE__, 'webonisers_create_table');


add_action('admin_menu', 'webonisers_menu');

function webonisers_menu()
{
    add_menu_page('Webonisers', 'Webonisers ', 'manage_options', 'add-weboniser', 'add-weboniser', '', '4');
    //add_submenu_page( 'manage-weboniserss', 'Add Image Category', 'Add Category', 'manage_options', 'add-category', 'add_image_category' );
    add_submenu_page('manage-weboniserss', 'Add Items', 'Add Items', 'manage_options', 'add-weboniser', 'add_weboniser');
    //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
    //add_options_page('My Plugin Options', 'Custom Upload', 'manage_options', 'my-unique-identifier', 'webonisers_options');
}


function webonisers_options()
{
    global $wpdb;
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    ?>
<script language="javascript">
    function deleteCategory(cat_id) {
        var v1 = confirm("Do you Want to delete");
        return v1;
    }
</script>

<!-- wrap nosubsub -->
<?php
}

function add_weboniser()
{
    global $wpdb;
    ?>
<script language="javascript">
    function deleteItem(id) {
        var v1 = confirm("Do you Want to delete Item");
        return v1;
    }
</script>
<?php
    if (($_GET['type'] == 'item') && ($_GET['action'] == 'delete')) {
        global $wpdb;
        $sqlDCategory = $wpdb->query("DELETE FROM `webonisers` WHERE id='" . $_GET['id'] . "' ");
        echo "<br><br><b style=\"color:#F00\">Item " . ' Deleted</b>';

    }
    $allowedExts = array("jpg", "jpeg", "gif", "png");
    if (isset($_POST['submit_item'])) {

        if ($_POST['name'] == "") {
            echo '<br><br><b style="color:#F00">Please fill Weboniser\'s  Name</b>';
        }
        else
        {
            global $wpdb;

            if (!empty($_FILES)) {

                $image = array();
                $flag = 1;
                $file = $_FILES['image'];

                $extension = end(explode(".", $file["name"]));
                if ((($file["type"] == "image/gif")
                    || ($file["type"] == "image/jpeg")
                    || ($file["type"] == "image/png")
                    || ($file["type"] == "image/pjpeg")
                    || ($file["type"] == "image/jpg"))
                    && in_array($extension, $allowedExts)
                ) {
                    if ($file["error"] > 0) {
                        //                            echo "Return Code: " . $file["error"] . "<br>";
                        $flag = 0;
                    }
                    else
                    {
                        $file_path = ABSPATH . "wp-content/uploads/webonisers_images/";
                        if (!is_dir($file_path)) {
                            mkdir($file_path, 777);
                        }

                        move_uploaded_file($file["tmp_name"], $file_path . $file["name"]);
                        $image['image'] = "/uploads/webonisers_images/" . $file["name"];
                        //                            echo "Stored in: " . $file_path . $file["name"];
                    }
                }
                else
                {
                    $flag = 0;

                }
            }
            if (isset($image['image'])&& $flag) {
                
                if (!isset($_POST['update_item'])) {
                    $sqlItem = "INSERT INTO `webonisers` (name,slug,designation,facebook_name,twitter_name,linkedin_name,description,image) VALUES ('" . $_POST['name'] .
                        "','" . $_POST['slug'] .
                        "','" . $_POST['designation'] .
                        "','" . $_POST['facebook_name'] . "','" .
                        $_POST['twitter_name'] . "','" .
                        $_POST['linkedin_name'] .
                        "','" .$_POST['description'] .
                        "','" . $image['image'] . "') ";
                    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                    dbDelta($sqlItem);
                    echo '<br><br><b style="color:#090">Item Added</b>';
                } else {
                    $sqlUItem = "UPDATE `webonisers` SET name = '" . $_POST['name'] . "',slug = '" . $_POST['slug'] .
                        "',designation = '" . $_POST['designation'] .
                        "',facebook_name='" . $_POST['facebook_name'] .
                        "',twitter_name='" . $_POST['twitter_name'] .
                        "',linkedin_name='" . $_POST['linkedin_name'] .
                        "',description='" . $_POST['description'] .
                        "',image='" . $_POST['image'] .
                        "' WHERE id='" . $_POST['id'] . "'";
                    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                    dbDelta($sqlUItem);
                    echo '<br><br><b style="color:#090">Item Updated</b>';
                }
            } else {
                echo '<br><br><b style="color:#F00">Something goes wrong or Image Error</b>';
            }

        }
    }
    ?>
<div class="wrap nosubsub">
    <div id="col-container">
        <div id="col-right">
            <div class="col-wrap">
                <form id="posts-filter" action="" method="POST">
                    <div class="tablenav"><br class="clear">
                    </div>
                    <div class="clear"></div>
                    <table class="widefat tag fixed" cellspacing="0">
                        <thead>
                        <tr></tr>
                        </thead>
                        <tfoot>
                        <tr></tr>
                        </tfoot>
                        <tbody id="the-list" class="list:tag">
                        <tr class="alternate" id="tag-11"></tr>
                        <tr id="tag-12"></tr>
                        <tr class="alternate" id="tag-13"></tr>
                        <tr id="tag-10"></tr>
                        </tbody>
                    </table>
                    <table cellspacing="0" class="widefat tag fixed">
                        <thead>
                        <tr>
                            <!--                            <th style="" class="manage-column column-cb check-column1" id="cb" scope="col"></th>-->
                            <th style="" class="manage-column column-name1" id="name" scope="col">Name</th>
                            <th style="" class="manage-column column-image1" id="Image" scope="col">Designation</th>
                            <th style="" class="manage-column column-thumbnail1" id="Thumbnail" scope="col">Photo
                            </th>
                            <th style="" class="manage-column column-posts num" id="posts" scope="col"></th>
                        </tr>
                        </thead>

                        <tbody class="list:tag" id="the-list">
                            <?php
                            $content_url = content_url();
                            $sel_q = $wpdb->get_results("select * from webonisers", ARRAY_A);
                            foreach ($sel_q as $sel_q_data)
                            {

                                ?>
                            <tr class="alternate" id="tag-8">
                                <!--                                <th class="check-column" scope="row"><input type="checkbox" value="8"-->
                                <!--                                                                            name="delete_tags[]"></th>-->
                                <td class="name column-name1"><strong>
                                    <?php echo $sel_q_data['name'];?>
                                </strong><br>

                                    <div class="row-actions1"><span class="edit"><a
                                        href="admin.php?page=add-weboniser&id=<?php echo $sel_q_data['id'];?>&action=edit&type=item">Edit</a> | </span><span
                                        class="delete"><a
                                        href="admin.php?page=add-weboniser&id=<?php echo $sel_q_data['id'];?>&action=delete&type=item"
                                        class="delete-tag"
                                        onclick="return deleteItem(<?php echo $sel_q_data['id'];?>);">Delete</a></span>
                                    </div>
                                    <div id="inline_8" class="hidden"></div>
                                </td>
                                <td class="description column-description1">
                <span class="manage-column column-description">
                  <?php echo $sel_q_data['designation'];?></span>
                                </td>


                                <td class="slug column-thumbnail" style="width:50px">
                                    <img src="<?php echo $content_url . $sel_q_data['image'];?>"
                                         style="height: 50px"/>

                                </td>

                            </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                    <br class="clear">
                </form>

            </div>
        </div>
        <!-- /col-right -->

        <?php
        $sel_qdtata = $wpdb->get_row("select * from  webonisers", ARRAY_A);
        ?>

        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <?php
                    if ($_GET['action'] == 'edit') {
                        echo '<h2>Edit Item</h2>';
                    }
                    else if (($_GET['type'] == 'item') && ($_GET['action'] == 'delete')) {

                    }
                    else
                        echo '<h2>Add New Item</h2>';
                    ?>
                    <form id="addtag" method="post" class="validate" action="" enctype="multipart/form-data">
                        <div class="form-field form-required">
                            <input name="id" value="<?php echo $_REQUEST['id'];?>" type="hidden"/> <input name="cat_id"
                                                                                                          value="<?php echo $_REQUEST['cat_id'];?>"
                                                                                                          type="hidden"/>
                            <label for="name">Name*</label>
                            <input type="text" aria-required="true" size="40" value="<?php echo $sel_qdtata['name'];?>"
                                   id="name" name="name">

                            <p>&nbsp;</p>
                        </div>
                        <div class="form-field">
                            <label for="slug">Slug</label>
                            <input type="text" size="40" value="<?php echo $sel_qdtata['slug'];?>" id="slug"
                                   name="slug">

                            <p>&nbsp;</p>
                        </div>

                        <div class="form-field">
                            <label for="designation">Designation*</label>
                            <input type="text" size="40" value="<?php echo $sel_qdtata['designation'];?>" id="designation"
                                   name="designation">

                            <p>&nbsp;</p>
                        </div>
                        <div class="form-field">
                            <label for="facebook_name">Facebook*</label>
                            <input type="text" size="40" value="<?php echo $sel_qdtata['facebook_name'];?>" id="facebook_name"
                                   name="facebook_name">

                            <p>&nbsp;</p>
                        </div>

                        <div class="form-field">
                            <label for="twitter_name">Twitter*</label>
                            <input type="text" size="40" value="<?php echo $sel_qdtata['twitter_name'];?>" id="twitter_name"
                                   name="twitter_name">

                            <p>&nbsp;</p>
                        </div>

                        <div class="form-field">
                            <label for="linkedin_name">LinkedIn*</label>
                            <input type="text" size="40" value="<?php echo $sel_qdtata['linkedin_name'];?>" id="linkedin_name"
                                   name="linkedin_name">

                            <p>&nbsp;</p>
                        </div>

                         <div class="form-field">
                            <label for="tag-slug">Upload Photo* [192*194] </label>
                            <input type="file" name="image"/>

                            <p><?php echo $sel_qdtata['image'];?></p>
                        </div>

                        <div class="form-field">
                            <label for="tag-description">Description</label>
                            <textarea name="description" id="tag-description" rows="5"
                                      cols="40"><?php echo $sel_qdtata['description'];?></textarea>

                            <p>&nbsp;</p>
                        </div>
                        <p class="submit">
                            <?php
                            if ($_GET['action'] == 'edit') {
                                echo '<input type="submit" value="UPDATE" name="update_item" class="button">';
                            }
                            else
                                echo '<input type="submit" value="ADD" name="submit_item" class="button">';
                            ?>

                        </p>
                    </form>
                </div>
            </div>
        </div>
        <!-- col-left -->
    </div>
    <!-- col-container -->
</div>
<!-- wrap nosubsub -->
<?php
}

?>