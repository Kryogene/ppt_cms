/*function expandPhoto(imgName)
{
  var div = document.createElement('div');
  div.setAttribute("class", "fullScreen");
  div.innerHTML = ['<img class="photo" src="' + imgName + '">'];
  document.getElementById('Shell').insertBefore(div, null);
  
}*/

function expandPhoto(src)
{
    var imgDiv = document.createElement('div');
    imgDiv.setAttribute("id", "fullPhoto");
    imgDiv.setAttribute("class", "fullScreen");


    imgDiv.innerHTML = "<img onClick='closeImg()' class='closeIcon hover' src='images/icons/gallery/delete.png'><table class='fullImageTable'><tr><td width='40px'><img class=' floatLeft hover' onClick='galleryBack()' src='images/icons/gallery/lArrows.png'></td><td><img onclick='galleryNext()' id='fullIMG' class='fullPhoto hover' src='"+src+"'></td><td width='40px'><img onclick='galleryNext()' class='floatRight hover ' src='images/icons/gallery/rArrows.png'></td></tr></table>";
    $('body').append(imgDiv);
    $(imgDiv).hide().fadeToggle("1500");




}

function closeImg()
{
    $('#fullPhoto').fadeToggle("1500", function(){
        $('#fullPhoto').remove();
    });
}

function galleryBack()
{
    $('#fullIMG').fadeToggle('500', function(){
      
      var len = $('.photo').length;
      
        $('.photo').each(function(i) {

              if( $(this).attr("id") == $('#fullIMG').attr("src"))
              {
                  $('#fullIMG').attr("src",  $(this).prev().attr("id"));
              }
        });
          $('#fullIMG').delay("2500").fadeToggle('500');
    });
}

function galleryNext(restart)
{
    thisAlbum = null;
    var inE = 0;

    $('#fullIMG').fadeToggle('500', function(){
      var len = $('.photo').length;
        $('.photo').each(function(i) {
          
            if( ($(this).attr("id") == $('#fullIMG').attr("src") || inE !== 0) || restart == 1)
            {
              // Set the album so it doesnt skip
              if(thisAlbum == null)
                  thisAlbum = $(this).attr("name");
              // If this is the last image, let's restart!
              
              // Check if it is the next image and correct album. Also, if we have stated a restart let's automatically grab the first element.
                if((inE == 1 && thisAlbum == $(this).attr("name")) || restart == 1)
                {
                      $('#fullIMG').attr("src", $(this).attr("id"));
                      inE = 2;
                      return false;
                }
                if(inE != 2)
                    inE = 1;
            }
        });
        if(restart != 1)
          $('#fullIMG').delay("2500").fadeToggle('500');
    });


    thisAlbum = null;
}