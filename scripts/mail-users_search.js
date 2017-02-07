// Get the <datalist> and <input> elements.
var dataList = document.getElementById('customdatalist');
var input = document.getElementById('to_search');
var to_list = document.getElementById('to_list');
var o_i = "";

$("#datalist .inner .exit").on("click", function(){
  $("#datalist").slideUp( "1000", function(){});
});

$("input[name='to_search']").on("focus", function(){
  search_load();
});


$("input[name='subject']").on("focus", function(){
  $("#datalist").slideUp( "1000", function(){});
});

$("textarea[name='message']").on("focus", function(){
  $("#datalist").slideUp( "1000", function(){});
});

function send_to(uid, uname)
{
  to_list.style.display = "block";
  var div = document.createElement('div');
  div.className = "to_recipient";
  if(document.getElementById(uid))
    return;
  div.setAttribute("id", uid);
  div.innerHTML = "<div class='exit' onclick='remove_to(" + uid + ")'></div><input type='hidden' name='to[]' value='" + uid + "'>" + uname;
  to_list.appendChild(div);
}

function remove_to(uid)
{
  var child = document.getElementById(uid);
  to_list.removeChild(child);
  if(to_list.textContent === "")
    to_list.style.display = "none";
}

function toggleOpen()
{
  $("#datalist").slideDown( "1000", function(){});
}

function search_load(){

  if(input.value.length < 3)
  {
    $("#datalist").slideUp( "1000", function(){
      //Do Nothing      
    });
    return;
  }
  $("#datalist").slideDown( "1000", function(){
    // Create a new XMLHttpRequest.
var request = new XMLHttpRequest();
// Handle state changes for the request.
request.onreadystatechange = function(response) {
  if (request.readyState === 4) {
    if (request.status === 200) {

          dataList.innerHTML = request.responseText;

    } else {
      // An error occured :(
      input.placeholder = "Couldn't load datalist options";
    }
  }
};

// Set up and make the request.
request.open('GET', 'requests/users.php?search=' + input.value, true);
request.send();
  })
}