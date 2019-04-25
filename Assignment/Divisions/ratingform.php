<!--
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

-Display the stars on the form

 -->
 <style>
 .rating{
   display: flex;
   justify-content: flex-flex-start;
 }

 input[type=radio]{
   display: none;
 }
 .radlabel{

 }
 </style>
<label style = "margin-top: 30px;">Rating:</label>
 <div class = "rating">
   <input type="radio" name="rating" id = "1" value="1" onclick="selected(this)">
   <input type="radio" name="rating" id = "2" value="2" onclick="selected(this)">
   <input type="radio" name="rating" id = "3" value="3" onclick="selected(this)">
   <input type="radio" name="rating" id = "4" value="4" onclick="selected(this)">
   <input type="radio" name="rating" id = "5" value="5" onclick="selected(this)">

   <label for = "1" class = "1"><br><img src = "./Images/empty.svg" height="20"></label>
   <label for = "2" class = "2"><br><img src = "./Images/empty.svg" height="20"></label>
   <label for = "3" class = "3"><br><img src = "./Images/empty.svg" height="20"></label>
   <label for = "4" class = "4"><br><img src = "./Images/empty.svg" height="20"></label>
   <label for = "5" class = "5"><br><img src = "./Images/empty.svg" height="20"></label>
 </div>

 <script>
 function selected(thisElement){
   // First set all the stars to empty
   for(var i = 1; i <=5; i++){
     document.getElementsByClassName(i)[0].innerHTML = '<br><img src = "./Images/empty.svg" height="20">';
   }
   // Then set the stars upto the element selected to star
   for(var i = 1; i <=thisElement.value; i++){
     document.getElementsByClassName(i)[0].innerHTML = '<br><img src = "./Images/star.svg" height="20">';
  }
 }
 </script>
