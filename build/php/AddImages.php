<?php

require_once( dirname(__FILE__) . '/../../html/kuwos/pa/lib/util/SiteConfiguration.php');
require_once( dirname(__FILE__) . '/../../html/kuwos/pa/lib/images/Albums.php');
require_once( dirname(__FILE__) . '/../../html/kuwos/pa/lib/images/Images.php');

//echo "'" . md5('paulpass') . "'\r\n";
//echo "'" . md5('rebeccapass') . "'\r\n";
//echo "'" . md5('bobpass') . "'\r\n";

class TestImage {
  public $filename;
  public $url;
  public $caption;
  
  public function __construct($filename, $url, $caption) {
    $this->filename = $filename;
    $this->url = $url;
    $this->caption = $caption;
  }
  
  public static function addTestImagesToAlbum($albumName, $albumOwner, $testImages) {
    $album = Albums::getAlbumByOwnerAndTitle($albumOwner, $albumName);
    if (! $album) {
      echo "Could not find album";
      return false;
    }
    foreach ($testImages as $image) {
    //  $r= new HttpRequest($image->url, HttpRequest::METH_GET);
    //  print_r($r);
      $headers = array_change_key_case(get_headers($image->url, 1),CASE_LOWER);
      
      $imageSize = getimagesize($image->url);
      
      Images::addImage($album->getAlbumID(), $image->filename,
          "jpg", (string) date('Y-m-d H:i:s'),
          $image->caption, file_get_contents($image->url),
          $headers['content-length'], 'image/jpeg',
          $imageSize[0], $imageSize[1]);

      global $lemast_config;
      $handle = fopen($lemast_config->uploadDirectory . '/' . $image->filename, 'a');
      fwrite($handle, file_get_contents($image->url));
    }
  }
}

echo "Adding images to '[sportslover] : [I love football]'\r\n"; flush();
TestImage::addTestImagesToAlbum('I love football', 'sportslover',
    array(
        new TestImage('f1.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/sports/f1.jpg',
            'Football!Yay!'),
        new TestImage('f2.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/sports/f2.jpg',
            'Football!Yay!'),
        new TestImage('f3.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/sports/f3.jpg',
            'Football!Yay!'),
        new TestImage('f4.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/sports/f4.jpg',
            'Football!Yay!'),
        new TestImage('f5.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/sports/f5.jpg',
            'Football!Yay!'),
        new TestImage('f6.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/sports/f6.jpg',
            'Football!Yay!')));

echo "Adding images to '[sportslover] : [I also love football]'\r\n"; flush();
TestImage::addTestImagesToAlbum('I also love football', 'sportslover',
    array(
        new TestImage('s1.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/sports/s1.jpg',
            'Soccer!'),
        new TestImage('s2.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/sports/s2.jpg',
            'Soccer!'),
        new TestImage('s3.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/sports/s3.jpg',
            'Soccer!'),
        new TestImage('s4.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/sports/s4.jpg',
            'Soccer!') ) );

echo "Adding images to '[traveler] : [Around The World]'\r\n"; flush();
TestImage::addTestImagesToAlbum('Around The World', 'traveler',
    array(
        new TestImage('EiffelTower.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/travel/EiffelTower.jpg',
            'Eiffel Tower'),
        new TestImage('WashingtonDC.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/travel/WashingtonDC.jpg',
            'Washington D.C.'),
        new TestImage('GreatWall.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/travel/GreatWall.jpg',
            'The Great Wall of China'),
        new TestImage('Stonehenge.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/travel/Stonehenge.jpg',
            'Stonehenge'),
        new TestImage('TajMahal.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/travel/TajMahal.jpg',
            'The Taj Mahal'),
        new TestImage('Persepolis.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/travel/Persepolis.jpg',
            'Persepolis'),
        new TestImage('Seoul.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/travel/Seoul.jpg',
            'Seoul') ) );

echo "Adding images to '[spacejunkie] : [Cool Space Shots]'\r\n"; flush();
TestImage::addTestImagesToAlbum('Cool Space Shots', 'spacejunkie',
    array(
        new TestImage('EagleNebula.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/space/EagleNebula.jpg',
            'Eagle Nebula'),
        new TestImage('HelixNebula.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/space/HelixNebula.jpg',
            'Helix Nebula'),
        new TestImage('OrionNebula.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/space/OrionNebula.jpg',
            'Orion Nebula'),
        new TestImage('MilkyWay.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/space/MilkyWay.jpg',
            'Milky Way'),
        new TestImage('GalaxyCollision.jpg',
            'http://www-personal.umich.edu/~vahed/eecs485/pa2/space/GalaxyCollision.jpg',
            'Galaxy Collision') ) );