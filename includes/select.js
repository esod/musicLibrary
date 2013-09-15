var xmlhttp;

function findMusician(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="../includes/search.inc.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=findChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function findChanged()
{
if (xmlhttp.readyState==4)
{
document.getElementById("findHint").innerHTML=xmlhttp.responseText;
}
}

function showMusicians(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="../includes/getmusicians.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=musicianChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function musicianChanged()
{
if (xmlhttp.readyState==4)
{
document.getElementById("MusiciansHint").innerHTML=xmlhttp.responseText;
}
}

function showAlbums(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="../includes/getalbums.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=albumChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function albumChanged()
{
if (xmlhttp.readyState==4)
{
document.getElementById("AlbumHint").innerHTML=xmlhttp.responseText;
document.getElementById("SongHint").innerHTML=null;
}
}

function showSongs(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="../includes/getsongs.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=songChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function songChanged()
{
if (xmlhttp.readyState==4)
{
document.getElementById("SongHint").innerHTML=xmlhttp.responseText;
}
}
		//define the function to play songs
		function playMusic(userfolder, song) {
		var so = new SWFObject('../includes/mediaplayer.swf','mpl','100%','20','9');
		so.addParam('flashvars','file=../tracks/' + userfolder + '/' + song + '&autostart=true');
		so.write('flashplayer')
		}	
		//define the function to announce the song playing in the pop-up
		function nowPlaying(song){
		document.write(song);
		}
		
//define the function for AJAX. To be replaced with jQuery

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}