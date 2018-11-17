<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
	.mySlides {display: none;}
	.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}
	</style>
</head>
<body>
<?php
include("header.php");
?>

<table width="100%">
	<tr>
		<td align="center" width="80%">
			<div class="slideshow-container">

			<div class="mySlides fade">
			  <div class="numbertext">1 / 3</div>
			  <img src="sliderImg/images_3.jpg" style="width:100%">
			</div>

			<div class="mySlides fade">
			  <div class="numbertext">2 / 3</div>
			  <img src="sliderImg/images_2.jpg" style="width:100%">
			</div>

			<div class="mySlides fade">
			  <div class="numbertext">3 / 3</div>
			  <img src="sliderImg/images_1.jpg" style="width:100%">
			</div>

			</div>

			<div style="text-align:center">
			  <span class="dot"></span> 
			  <span class="dot"></span> 
			  <span class="dot"></span> 
			</div>
		</td>
		<td align="center" width="20%" valign="top">
			<table bgcolor="darkblue">
				<tr>
					<td><img src="images/careers.jpg"/></td>
				</tr>
				<tr>
					<td style="background-color: white;font-size: 20px;font-weight: bold;font-family: 'arial';">
						Recruitment of Engineering Graduates in ABC Corp. Applications can be submitted online.
						<br><br>
						<?php 
						include("credentials.php");
						$result = $conn->query("select * from config");
						$row = $result->fetch_assoc();
						echo "Application Start Date: ".$row['startDate'];
						echo "<p>Application End Date: ".$row['endDate'];
						 ?> 
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script>
var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 2000); // Change image every 2 seconds
}
</script>
</body>
</html>

