/* 
 * this page is used for index marquee control
 */
//------------------------1st one for dristi akorshon
var speed1 = 1; // change scroll speed with this value
var height1 = 220;
/**
 * Initialize the marquee, and start the marquee by calling the marquee function.
 */
function init1(){
  var el1 = document.getElementById("marquee_replacement1");
  el1.style.overflow = 'hidden';
  scrollFromBottom1();
}
 
var go1 = 1;
var timeout1 = '';
/**
 * This is where the scroll action happens.
 * Recursive method until stopped.
 */
function scrollFromBottom1(){
  clearTimeout(timeout1);
  var el1 = document.getElementById("marquee_replacement1");
  if(el1.scrollTop >= el1.scrollHeight-height1){
    el1.scrollTop = 0;
  };
  el1.scrollTop = el1.scrollTop + speed1;
  if(go1 == 0){
    timeout1 = setTimeout("scrollFromBottom1()",50);
  };
}
 
/**
 * Set the stop variable to be true (will stop the marquee at the next pass).
 */
function stop1(){
  go1 = 1;
}
 
/**
 * Set the stop variable to be false and call the marquee function.
 */
function startit1(){
  go1 = 0;
  scrollFromBottom1();
}
//------------------------2nd one for product
var speed2 = 2; // change scroll speed with this value
var height2 = 530;
/**
 * Initialize the marquee, and start the marquee by calling the marquee function.
 */
function init2(){
  var el2 = document.getElementById("marquee_replacement2");
  el2.style.overflow = 'hidden';
  scrollFromBottom2();
}
 
var go2 = 1;
var timeout2 = '';
/**
 * This is where the scroll action happens.
 * Recursive method until stopped.
 */
function scrollFromBottom2(){
  clearTimeout(timeout2);
  var el2 = document.getElementById("marquee_replacement2");
  if(el2.scrollTop >= el2.scrollHeight-height2){
    el2.scrollTop = 0;
  };
  el2.scrollTop = el2.scrollTop + speed2;
  if(go2 == 0){
    timeout2 = setTimeout("scrollFromBottom2()",50);
  };
}
 
/**
 * Set the stop variable to be true (will stop the marquee at the next pass).
 */
function stop2(){
  go2 = 1;
}
 
/**
 * Set the stop variable to be false and call the marquee function.
 */
function startit2(){
  go2 = 0;
  scrollFromBottom2();
}

