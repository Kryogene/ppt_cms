function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    var size = 0;

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

        // Only process image files.
        if (!f.type.match('image.*')) {
            continue;
        }

        $('.fig').remove();

        size = size + f.size;

        var reader = new FileReader();

        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
                // Render thumbnail.
                var figure = document.createElement('figure');
                figure.setAttribute("class", "fig");
                fileName = escape(theFile.name);
                fileNameExt = fileName.split(".");
                sKB = theFile.size / 1024;
                sMB = sKB / 1024;
                sKB = sKB.toFixed(2);
                sMB = sMB.toFixed(2);
                if(sMB > 1){ s = sMB+"MB"; }else{ s = sKB+"KB"; }

                figure.innerHTML = ['<figcaption><input type="hidden" name="img_name[]" value="', escape(theFile.name), '"><input type="text" name="photo_title[]" value="', fileNameExt[0], '"></figcaption><img align="center" class="thumb" src="', e.target.result,
                    '" title="', escape(theFile.name), '" /><br><textarea name="photo_description[]">Description</textarea>', s].join('');
                document.getElementById('list').insertBefore(figure, null);
            };
        })(f);

        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }
    sizeKB = size / 1024;
    sizeMB = sizeKB / 1024;
    if(size == 0)
    {
        $('.fig').remove();
    }
    if(sizeMB > 1)
    {
        sizeMB = sizeMB.toFixed(2);
        size = sizeMB+"MB";
    }
    else
    {
        sizeKB = sizeKB.toFixed(2);
        size = sizeKB+"KB";
    }
    document.getElementById('size').innerHTML = size;
}

document.getElementById('photos').addEventListener('change', handleFileSelect, false);