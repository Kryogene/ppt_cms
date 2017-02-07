<?PHP

class sk_gallery
{
  
  function album_box($album, $photos)
  {
    $HTML = <<<HTML
    <div style="width: 98%; float: left; border-bottom: 1px solid #000000; margin: 5px 5px 5px 5px; padding: 10px;">
      <b><a href="index.php?p=gallery&album_id={$album->id}">{$album->Title}</a></b> ({$album->PhotosInAlbum})<br />
      {$photos}
    </div><br />
HTML;
    return $HTML;
  }
  
  function photo_box($photo)
  {
    $HTML = <<<HTML
      <img alt="{$photo->Title}" title="{$photo->Title}" onClick="expandPhoto('{$photo->getImageSrc()}')" id="{$photo->getImageSrc()}" class="photo hover" name="{$photo->AlbumTitle}" src="{$photo->getImageSmallSrc()}">
HTML;
    return $HTML;
  }
  
  function no_photos()
  {
    $HTML = <<<HTML
    <span style="font-style: italic; margin-left: 2em;">No Photos Have Been Uploaded To This Album Yet!</span>
HTML;
    return $HTML;
  }
  
}

?>