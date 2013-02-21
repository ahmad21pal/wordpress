<?php
/**
Plugin Name: Custom Upload
Plugin URI: http://wordpress.opensourcedevelopers.net/downloads/
Description: A simple plugin to upload any type of image in wordpress. We can use it to manage header gallery section.
Author: Shakti Kumar
Version: 1.1
Author URI: http://opensourcedevelopers.net/
 */

define('TXTFOLDER', get_bloginfo('wpurl') . "/wp-content/plugins/custom-upload/txtfiles");

function custom_upload_install()
{
    if (!file_exists(TXTFOLDER)) {
        mkdir(TXTFOLDER, 0777);
    }
}

register_activation_hook(__FILE__, 'custom_upload_install');

function custom_upload_create_table()
{
    // do NOT forget this global
    //mkdir("custom_upload_folder",0777);
    global $wpdb;

    // this if statement makes sure that the table doe not exist already
    if ($wpdb->get_var("show tables like custom_category") != 'custom_category') {
        $sql = "CREATE TABLE IF NOT EXISTS `custom_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
  `slug` varchar(222) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $sql2 = "CREATE TABLE IF NOT EXISTS `custom_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(222) NOT NULL,
  `slug` varchar(222) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(222) NOT NULL,
  `thumbnail` varchar(222) NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql2);
    }

}

// this hook will cause our creation function to run when the plugin is activated
register_activation_hook(__FILE__, 'custom_upload_create_table');


add_action('admin_menu', 'custom_upload_menu');

function custom_upload_menu()
{
    add_menu_page('Manage Custom Upload', 'Slider Uploads', 'manage_options', 'add-item', 'add-item', '', '3');
    //add_submenu_page( 'manage-custom-uploads', 'Add Image Category', 'Add Category', 'manage_options', 'add-category', 'add_image_category' );
    add_submenu_page('manage-custom-uploads', 'Add Items', 'Add Items', 'manage_options', 'add-item', 'add_item');
    //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
    //add_options_page('My Plugin Options', 'Custom Upload', 'manage_options', 'my-unique-identifier', 'custom_upload_options');
}


function custom_upload_options()
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
<?php
    if (($_GET['type'] == 'category') && ($_GET['action'] == 'delete')) {
        global $wpdb;
        $sqlDCategory = $wpdb->query("DELETE FROM `custom_category` WHERE id='" . $_GET['id'] . "' ");
        echo "<br><br><b style=\"color:#F00\">Category " . $_GET['id'] . ' Deleted</b>';

    }
    if (isset($_POST['submit'])) {

        if ($_POST['tag-name'] == "") {
            echo '<br><br><b style="color:#F00">Please fill Category Name</b>';
        }
        else
        {
            global $wpdb;
            $sqlCategory = "INSERT INTO `custom_category` (name,slug,description) VALUES ('" . $_POST['tag-name'] . "','" . $_POST['slug'] . "','" . $_POST['description'] . "') ";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sqlCategory);
            echo '<br><br><b style="color:#090">Category Added</b>';
        }
    }
    if (isset($_POST['update'])) {
        global $wpdb;
        $sqlUCategory = "UPDATE `custom_category` SET name = '" . $_POST['tag-name'] . "',description = '" . $_POST['description'] . "',slug = '" . $_POST['slug'] . "' WHERE id='" . $_POST['id'] . "'";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sqlUCategory);
        echo '<br><br><b style="color:#090">Category Updated</b>';

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
                            <th style="" class="manage-column column-cb check-column" id="cb" scope="col"></th>
                            <th style="" class="manage-column column-name" id="name" scope="col">Name</th>
                            <th style="" class="manage-column column-description" id="description" scope="col">
                                Description
                            </th>
                            <th style="" class="manage-column column-slug" id="slug" scope="col">Slug</th>
                            <th style="" class="manage-column column-posts num" id="posts" scope="col">Products</th>
                        </tr>
                        </thead>

                        <tbody class="list:tag" id="the-list">
                            <?php $sel_q = $wpdb->get_results("select * from custom_category ", ARRAY_A);
                            foreach ($sel_q as $sel_q_data)
                            {
                                ?>
                            <tr class="alternate" id="tag-8">
                                <th class="check-column" scope="row"><input type="checkbox" value="8"
                                                                            name="delete_tags[]"></th>
                                <td class="name column-name"><strong>
                                    <?php echo $sel_q_data['name'];?>
                                </strong><br>

                                    <div class="row-actions"><span class="edit"><a
                                        href="<?php echo 'admin.php?page=manage-custom-uploads&'; ?>id=<?php echo $sel_q_data['id'];?>&action=edit">Edit</a> | </span><span
                                        class="delete"><a
                                        href="<?php echo 'admin.php?page=manage-custom-uploads&'; ?>id=<?php echo $sel_q_data['id'];?>&action=delete&type=category"
                                        class="delete-tag"
                                        onclick="return deleteCategory(<?php echo $sel_q_data['id'];?>);">Delete</a></span>
                                    </div>
                                    <div id="inline_8" class="hidden"></div>
                                </td>
                                <td class="description column-description"><span
                                    class="manage-column column-description">
                  <?php echo $sel_q_data['description'];?>
                                    <td class="slug column-slug"> <span class="manage-column column-slug">
                  <?php echo $sel_q_data['slug'];?>
                </span></td>
                </span></td>
                                <?php $sel_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM custom_products where cat_id='" . $sel_q_data['id'] . "'"));

                                ?>
                                <td class="posts column-posts num"><a
                                    href="admin.php?page=add-item&cat_id=<?php echo $sel_q_data['id'];?>"><?php echo $sel_count; ?></a>
                                </td>
                            </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                    <br class="clear">
                </form>

            </div>
        </div>
        <!-- col-right -->
        <?php
        $sel_qdtata = $wpdb->get_row("select * from  custom_category where id='" . $_GET['id'] . "'", ARRAY_A);
        ?>

        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <?php
                    if ($_GET['action'] == 'edit') {
                        echo '<h2>Edit Catagory</h2>';
                    }
                    else if (($_GET['type'] == 'category') && ($_GET['action'] == 'delete')) {

                    }
                    else
                        echo '<h2>Add New Catagory</h2>';
                    ?>

                    <form id="addtag" method="post" action="admin.php?page=manage-custom-uploads" class="validate">
                        <div class="form-field form-required">
                            <input name="id" value="<?php echo $sel_qdtata['id'];?>" type="hidden"/>
                            <label for="tag-name">Name </label>
                            <input type="text" aria-required="true" size="40" value="<?php echo $sel_qdtata['name'];?>"
                                   id="tag-name" name="tag-name">

                            <p>&nbsp;</p>
                        </div>
                        <div class="form-field">
                            <label for="tag-slug">Slug</label>
                            <input type="text" size="40" value="<?php echo $sel_qdtata['slug'];?>" id="tag-slug"
                                   name="slug">

                            <p>&nbsp;</p>
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
                                echo '<input type="submit" value="UPDATE"  name="update" class="button">';
                            }
                            else
                                echo '<input type="submit" value="ADD"  name="submit" class="button">';
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

function add_item()
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
        $sqlDCategory = $wpdb->query("DELETE FROM `custom_products` WHERE id='" . $_GET['id'] . "' ");
        echo "<br><br><b style=\"color:#F00\">Item " . $_GET['id'] . ' Deleted</b>';

    }
    $allowedExts = array("jpg", "jpeg", "gif", "png");
    if (isset($_POST['submit_item'])) {

        if ($_POST['tag-name'] == "") {
            echo '<br><br><b style="color:#F00">Please fill Item Name</b>';
        }
        else
        {
            global $wpdb;

            if (!empty($_FILES)) {
                $file_names = array();
                $flag = 1;
                foreach ($_FILES as $fileName => $file) {
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
//                            echo "Upload: " . $file["name"] . "<br>";
//                            echo "Type: " . $file["type"] . "<br>";
//                            echo "Size: " . ($file["size"] / 1024) . " kB<br>";
//                            echo "Temp file: " . $file["tmp_name"] . "<br>";
                            $content_url = content_url();
                            $file_path = ABSPATH . "wp-content/uploads/slider_images/";
                            if (!is_dir($file_path)) {
                                mkdir($file_path, 777);
                            }

                            move_uploaded_file($file["tmp_name"], $file_path . $file["name"]);
                            $file_names[] = "/uploads/slider_images/" . $file["name"];
//                            echo "Stored in: " . $file_path . $file["name"];
                        }
                    }
                    else
                    {
                        $flag = 0;

                    }
                }
            }
            if (isset($file_names[0]) && isset($file_names[1]) && $flag) {
                $sqlItem = "INSERT INTO `custom_products` (name,slug,description,image,thumbnail,cat_id) VALUES ('" . $_POST['tag-name'] . "','" . $_POST['slug'] . "','" . $_POST['description'] . "','" . $file_names[0] . "','" . $file_names[1] . "','" . $_POST['cat_id'] . "') ";
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sqlItem);
                echo '<br><br><b style="color:#090">Item Added</b>';
            } else {
                echo '<br><br><b style="color:#F00">Something goes wrong or Image Error</b>';
            }

        }
    }
    if (isset($_POST['update_item'])) {

        if (!empty($_FILES)) {
            $file_names = array();
            $flag = 1;
            foreach ($_FILES as $fileName => $file) {
                $extension = end(explode(".", $file["name"]));
                if ((($file["type"] == "image/gif")
                    || ($file["type"] == "image/jpeg")
                    || ($file["type"] == "image/png")
                    || ($file["type"] == "image/pjpeg")
                    || ($file["type"] == "image/jpg"))
                    && in_array($extension, $allowedExts)
                ) {
                    if ($file["error"] > 0) {
//                        echo "Return Code: " . $file["error"] . "<br>";
                        $flag=0;
                    }
                    else
                    {
//                        echo "Upload: " . $file["name"] . "<br>";
//                        echo "Type: " . $file["type"] . "<br>";
//                        echo "Size: " . ($file["size"] / 1024) . " kB<br>";
//                        echo "Temp file: " . $file["tmp_name"] . "<br>";
                        $content_url = content_url();
                        $file_path = ABSPATH . "wp-content/uploads/slider_images/";
                        if (!is_dir($file_path)) {
                            mkdir($file_path, 777);
                        }
                        move_uploaded_file($file["tmp_name"], $file_path . $file["name"]);
                        $file_names[] = "/uploads/slider_images/" . $file["name"];
//                        echo "Stored in: " . $file_path . $file["name"];
                        //                            }
                    }
                }
                else
                {
                    $flag = 0;

                }
            }
        }

        global $wpdb;
        if (isset($file_names[0]) && isset($file_names[1]) && $flag) {
        $sqlUItem = "UPDATE `custom_products` SET name = '" . $_POST['tag-name'] . "',description = '" . $_POST['description'] . "',slug = '" . $_POST['slug'] . "',image='" . $file_names[0] . "',thumbnail='" . $file_names[1] . "' WHERE id='" . $_POST['id'] . "'";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sqlUItem);
            echo '<br><br><b style="color:#090">Item Updated</b>';
        }else{
            echo '<br><br><b style="color:#F00">Something goes wrong or Image Error</b>';
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
                            <th style="" class="manage-column column-cb check-column" id="cb" scope="col"></th>
                            <th style="" class="manage-column column-name" id="name" scope="col">Name</th>
                            <th style="" class="manage-column column-description" id="description" scope="col">
                                Description
                            </th>
                            <th style="" class="manage-column column-slug" id="slug" scope="col">Slug</th>
                            <th style="" class="manage-column column-image" id="slug" scope="col">Image</th>
                            <th style="" class="manage-column column-thumbnail" id="slug" scope="col">Thumbnail</th>
                            <th style="" class="manage-column column-posts num" id="posts" scope="col"></th>
                        </tr>
                        </thead>

                        <tbody class="list:tag" id="the-list">
                            <?php
                            $content_url = content_url();
                            $sel_q = $wpdb->get_results("select * from custom_products where cat_id='" . $_REQUEST['cat_id'] . "' ", ARRAY_A);
                            foreach ($sel_q as $sel_q_data)
                            {

                                ?>
                            <tr class="alternate" id="tag-8">
                                <th class="check-column" scope="row"><input type="checkbox" value="8"
                                                                            name="delete_tags[]"></th>
                                <td class="name column-name"><strong>
                                    <?php echo $sel_q_data['name'];?>
                                </strong><br>

                                    <div class="row-actions"><span class="edit"><a
                                        href="admin.php?page=add-item&cat_id=<?php echo $_REQUEST['cat_id']?>&id=<?php echo $sel_q_data['id'];?>&action=edit&type=item">Edit</a> | </span><span
                                        class="delete"><a
                                        href="admin.php?page=add-item&cat_id=<?php echo $_REQUEST['cat_id']?>&id=<?php echo $sel_q_data['id'];?>&action=delete&type=item"
                                        class="delete-tag"
                                        onclick="return deleteItem(<?php echo $sel_q_data['id'];?>);">Delete</a></span>
                                    </div>
                                    <div id="inline_8" class="hidden"></div>
                                </td>
                                <td class="description column-description">
                <span class="manage-column column-description">
                  <?php echo $sel_q_data['description'];?></span>
                                <td class="slug column-slug"> <span class="manage-column column-slug">
                  <?php echo $sel_q_data['slug'];?>
                </span></td>


                                <td class="slug column-thumbnail"> <span class="manage-column column-thumbnail">
                  <?php echo "<img src='".$content_url."".$sel_q_data['thumbnail']."' height=100px,width=200px>";?>
                </span></td>

                                <td class="slug column-thumbnail" > <span class="manage-column column-thumbnail">
                  <?php echo "<img src='".$content_url."".$sel_q_data['image']."' height=100px,width=200px>";?>
                </span></td>


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
        $sel_qdtata = $wpdb->get_row("select * from  custom_products where id='" . $_GET['id'] . "'", ARRAY_A);
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
                            <label for="tag-name">Name</label>
                            <input type="text" aria-required="true" size="40" value="<?php echo $sel_qdtata['name'];?>"
                                   id="tag-name" name="tag-name">

                            <p>&nbsp;</p>
                        </div>
                        <div class="form-field">
                            <label for="tag-slug">Slug</label>
                            <input type="text" size="40" value="<?php echo $sel_qdtata['slug'];?>" id="tag-slug"
                                   name="slug">

                            <p>&nbsp;</p>
                        </div>


                        <div class="form-field">
                            <label for="tag-slug">Upload Image</label>
                            <input type="file" name="image"/>

                            <p><?php echo $sel_qdtata['image'];?></p>
                        </div>

                        <div class="form-field">
                            <label for="tag-slug">Upload Thumbnail</label>
                            <input type="file" name="thumbnail"/>

                            <p><?php echo $sel_qdtata['thumbnail'];?></p>
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