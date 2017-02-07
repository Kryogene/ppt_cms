var oldID = null;
var d = new Date();
var month = d.getMonth();
var year = d.getYear();

var quantity = $('.statisticTable tr').length;

$('#newRowButton').click(function() {
quantity = $('.statisticTable tr').length;
    $('.statisticTable tr:last')
        .clone()
        .insertAfter('.statisticTable tr:last');
  
    $('.statisticTable tr:eq('+quantity+')')
        .find('input')
        .val("");

    $('.statisticTable tr:eq('+quantity+')')
        .find('select')
		.val("");


});

    $(document).on('click', '.subtract', function () {
        quantity = Number($('#updateQuantity').val()) - 1;
        tr = $(this).parent().parent();
        trIndex = tr.index();
        if(quantity !== 0){
            tr.remove();
            $('#updateQuantity').val( quantity );
        }
    });

	function setID(ele)
	{
		classToChange = ele.className;
		element = $(ele);
		if($('#'+element.val()).length){
			if(element.prop('selectedIndex') != element.parent().parent().attr('id'))
			{
				alert("This Person Already Exists On This List!");
				return;
			}
		}
		$('#'+classToChange).attr('id', element.val());
		element.attr('class', element.val());
		$('._'+classToChange).attr('onclick', 'editVenue('+element.val()+')');
		$('._'+classToChange).attr('class', '_'+element.val());
		$('.'+classToChange).attr('id', element.val());
		$('.'+classToChange).attr('class', 'showVenues '+element.val());
		refreshVenue(ele);
	}