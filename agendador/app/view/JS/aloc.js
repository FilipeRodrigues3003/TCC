document.addEventListener("dragstart", function(event) {
    // Change the opacity of the draggable element
    event.target.style.opacity = "0.2";
});
// While dragging the p element, change the color of the output text
document.addEventListener("drag", function(event) {
    //  document.getElementById("demo").style.color = "red";
});
// Output some text when finished dragging the p element and reset the opacity
document.addEventListener("dragend", function(event) {
    event.target.style.opacity = "1";
});
/* Events fired on the drop target */
// When the draggable p element enters the droptarget, change the DIVS's border style
document.addEventListener("dragenter", function(event) {
    if (event.target.className == "boxB" || event.target.className == "boxA") {
        event.target.style.border = "2px dashed rgba(66, 66, 66, 0.6)";
        event.target.style.opacity = "0.5";
    }
});
// By default, data/elements cannot be dropped in other elements. To allow a drop, we must prevent the default handling of the element
document.addEventListener("dragover", function(event) {
    event.preventDefault();
});
// When the draggable p element leaves the droptarget, reset the DIVS's border style
document.addEventListener("dragleave", function(event) {
    if (event.target.className == "boxB" || event.target.className == "boxA") {
        event.target.style.border = "";
        event.target.style.opacity = "1";
    }
});
/* On drop - Prevent the browser default handling of the data (default is open as link on drop)
   Reset the color of the output text and DIV's border color
   Get the dragged data with the dataTransfer.getData() method
   The dragged data is the id of the dragged element ("drag1")
   Append the dragged element into the drop element
*/
document.addEventListener("drop", function(event) {
    event.preventDefault();
    if (event.target.className == "boxB" || event.target.className == "boxA") {
        //document.getElementById("demo").style.color = "";
        event.target.style.border = "";
        event.target.style.opacity = "1";
        // var data = event.dataTransfer.getData("Text");
        // event.target.appendChild(document.getElementById(data));
    }
});
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});