 <?php

/**
 * Lola's base settings
 *
 * This class is used modify the websites on Lola
 *
 * @author Alec Ritson <info@alecritson.co.uk>
 * @copyright 2013 Alec Ritson
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */


include ('kirby.php');

g::set('version', 1);

/*
public_html, htdocs, httpdocs, www etc
*/
g::set('webRoot', 'httpdocs');

/*
This is where you store all your websites for example D:/wamp/www
*/
g::set('rootHttpd', '/path/to/web/root');



/* DO NOT EDIT BELOW THIS LINE
-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- */


$lola = new websites;

class websites
{
    public $name,
           $toDelete,
           $docRoot;

    

    public function __construct() {

        /**
        * Grab the data from json
        *
        * @var array stores all the websites
        */

        
        if(!empty($_GET)) {
            $this->data = f::read('websites.json', 'json');
        } else {
            $this->data = f::read('app/websites.json', 'json');
        }

        if(array_key_exists('websites', $this->data)) {
            $this->websites = $this->data['websites'];
        } else {
            $this->websites = array();
        }

    }

    private function generateThumb($name) {

        /**
         * This takes the website name as its parameter
         * replaces the whitespace with -
         */

        $this->image = str_replace(" ", "-", $name);
        $this->thumbDir = "sites/";
        $this->thumbnail = $this->thumbDir . $this->image . ".jpg";

        // Check if a thumbnail exists in the directoy we set up above.

        if(file_exists($this->thumbnail)) {

        // If the thumbnail exists, echo the url out

        echo "/" . $this->thumbnail;

        // otherwise use the default thumbnail

        } else {
            echo "/" . $this->thumbDir . "defaultThumb.jpg";
        }
    }

    public function listWebsites()
    {
        if(empty($this->websites)) {

            echo "<p style=\"margin-top:20px\">You currently have no websites. To add a website, click the plus icon at the top</p>";
        }
        // Go through each of the websites that are from the parent class
        foreach($this->websites as $this->key => $this->value) {
    ?>
        <div class="box <?php if($this->value['active'] == true){ echo "active"; } ?>">
            <a href="#" class="delete" data-id="<?php echo $this->value['id']; ?>"><i class="icon-remove"></i></a>
            <section>
                <figure style="background-image:url('<?php $this->generateThumb($this->value['name']); ?>');?>">&nbsp;</figure>
                <h1><?php echo $this->value['name']?></h1>
                <a href="#" class="activate" data-control="toggle" data-id="<?php echo $this->value['id']; ?>" data-loc="<?php echo $this->value['directory']?>">
                    <span class="nubbin"></span>
                </a>
            </section>
        </div>

     <?php   }

    }

    public function addWebsite($siteName, $location) {

        // if sitename is empty, return error.



        if(empty($siteName)) {

            echo "You need to specify a website name";

        } else {
            // Get all of the ID's currently assigned and assign the last one to a variable
            foreach($this->websites as $this->key => $this->value) {
               $this->lastID = $this->value['id'];
            }

            // Assign new website an ID (incremented by 1)
            $this->newID = ++$this->lastID;

            $this->name = $siteName;

            // Remove any whitespace in the name.
            $siteName = str_replace(" ", "-", $siteName);
            $this->locName = $siteName;

            // If the location in the form is not set, use the one from the config.
            if(empty($location)) {
                $this->location = g::get('rootHttpd') . '/' . $this->locName . '/';
            } else {
                $this->location = $location . '/';
            }


            // Start building the new array

            $this->newSite = array(
                "id" => $this->newID,
                "name" => $this->name,
                "directory" => $this->location  .  g::get('webRoot'),
                "active" => false
            );

            // Go back to the original data array and insert there
            $this->data['websites'][] = $this->newSite;

          
            f::write('websites.json', $this->data);

            $this->_makeDirs($this->location);

            echo "Website has been added";
        }


    }

    public function deleteWebsite($id) {

        $array = $this->websites;
        $key = "id";
        $value = $id;

         foreach($array as $subKey => $subArray){
              if($subArray[$key] == $value){
                   unset($array[$subKey]);
              }
         }

         $this->data['websites'] = $array;

         f::write('websites.json', $this->data, $append=false);

    }

    public function updateVhosts($directory, $pendingSite) {

        $string = "<VirtualHost *:80>\n";
        $string .= "  ServerAdmin you@yourdomain.com \n";
        $string .= "  DocumentRoot \"" . $directory ."\" \n";
        $string .= "  ServerName localhost \n";
        $string .= "  <Directory " . $directory . "> \n";
        $string .= "    Order Deny,Allow \n";
        $string .= "    Allow from all \n";
        $string .= "  </Directory> \n";
        $string .= "</VirtualHost> \n";

        f::write('_vhosts/_default.conf', $string);

        $this->_setActive($pendingSite);

        echo "Website has been activated";
    }

    private function _setActive($website) {

        foreach($this->websites as $key => $value) {
            if($value['id'] != $website) {
                $value['active'] = false;
            } else {
                $value['active'] = true;
            }

            $sites['websites'][] = $value;

        }

       f::write('websites.json', $sites);


    }
    private function _makeDirs($location) {
        if(!file_exists($location) && !is_dir($location)) {
            dir::make($location);
            dir::make($location .  g::get('webRoot'));
        }
    }

}

?>